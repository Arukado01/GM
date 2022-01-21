<?php namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index');
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function edit($project_id)
    {
        $project = Project::with(['users' => function ($q) {
            $q->whereIn('role_id', [1, 2]);
        }])->find($project_id);

        return view('admin.projects.edit', compact('project'));
    }

    public function editOrCreate(Request $request, $user_id, $project_id = null)
    {
        $project = null;
        $message = 'Proyecto creado con éxito.';

        if ($project_id != null) {
            $project = Project::find($project_id);
            $message = 'Proyecto actualizado con éxito.';
        } else {
            $project = new Project();
        }

        $project->name = $request->name;
        $project->location = $request->location;

        $project->save();

        $users = $project->users()->where('role_id', '!=', 3)->get();
        foreach ($users as $user) {
            $project->users()->detach($user);
        }

        $user = User::find($user_id);
        $project->users()->attach($user);

        /*
                $clients = $project->users()->where('role_id', 3)->get();
                foreach ($clients as $client){
                    $project->users()->detach($client);
                }*/

        return response()->json([
            'message'    => $message,
            'redirectTo' => route('admin.projects.index')
        ], 200);
    }

    public function addClientsToProject($project_id, $client_id)
    {
        $message = 'Cliente asignado con éxito.';
        $code = 200;
        $project = Project::find($project_id);
        $client = User::find($client_id);

        $ctn = $project->users()->where('users.id', $client_id)->count();


        if ($ctn <= 0) {
            $project->users()->attach($client);
        } else {
            $message = "El cliente $client->full_name ya se encuentra asignado al proyecto $project->name";
            $code = 401;
        }

        return response()->json(['message' => $message], $code);
    }

    public function removeClientsFromProject($project_id, $client_id)
    {
        $message = 'El cliente se ha removido con éxito.';
        $code = 200;
        $project = Project::find($project_id);
        $client = User::find($client_id);

        $project->users()->detach($client);
        return response(['message' => $message], $code);
    }

    public function getProjectData()
    {
        $projects = Project::whereHas('users', function ($query) {
            if (!auth()->user()->isAdmin())
                $query->where('user_id', auth()->user()->id);
        })->with(['users' => function ($query) {
            $query->whereIn('role_id', [1, 2]);
        }])->get();

        return DataTables::of($projects)
            ->setRowId('hashid')
            ->addColumn('full_name', function ($project) {
                $full_name = $project->users->first()->full_name;
                $name = str_limit($full_name, 10);
                $html = <<<EOT
                    <div class="tooltip-core">
                        $name
                        <span class="tooltiptext-core">$full_name</span>
                    </div>
EOT;

                return $html;
            })
            ->setRowClass(function ($project) {
                return $project->users->first()->id == auth()->user()->id ? 'alert-success' : '';
            })
            ->addColumn('action', function ($project) {
                $html = '<div class="btn-group">';

                $btnEditar = route('admin.projects.edit', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnEditar,
                    'Editar Proyecto',
                    false,
                    'edit',
                    'success',
                    ''
                );

                $btnUpload = route('admin.reports.index', ['project_id' => $project->hashid]);

                $html .= StringHelpers::getBtn(
                    $btnUpload,
                    'Subir Reporte',
                    false,
                    'upload',
                    'info',
                    ''
                );

                $btnUploadImages = route('admin.projects.images.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnUploadImages,
                    'Subir Imágenes',
                    false,
                    'picture-o',
                    'primary',
                    ''
                );

                $btnAnalytics = route('admin.projects.analysis.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnAnalytics,
                    'Análisis, resultados y tomas de muestra',
                    false,
                    'table',
                    'secondary',
                    ''
                );

                $btnAnalytics = route('admin.projects.calibration_certificates.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnAnalytics,
                    'Certificados de Calibración',
                    false,
                    'list-alt',
                    'secondary',
                    ''
                );

                $btnProgressWork = route('admin.projects.progress_works.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnProgressWork,
                    'Avance de Obra',
                    false,
                    'tasks',
                    'secondary',
                    ''
                );

                $btnFindings = route('admin.projects.findings.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnFindings,
                    'Hallazgos',
                    false,
                    'binoculars',
                    'secondary',
                    ''
                );

                $btnZonesChecked = route('admin.projects.zones_checked.index', ['project_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $btnZonesChecked,
                    'Zonas Verificadas Dimensionalmente',
                    false,
                    'check-square-o',
                    'secondary',
                    ''
                );

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['full_name', 'action'])
            ->make(true);
    }

    public function getClientsData($project_id)
    {
        $project = Project::find($project_id);
        $clients = $project->users()
            ->where('users.role_id', 3)
            ->get();

        return DataTables::of($clients)
            ->setRowId('hashid')
            ->addColumn('full_name', function ($client) {
                return $client->full_name;
            })
            ->editColumn('created_at', function ($client) {
                return date_format($client->created_at, 'Y-m-d');
            })
            ->addColumn('action', function ($client) use ($project) {

                $btnEditar = route('admin.projects.delete_clientes_relations', [
                    'project_id' => $project->hashid,
                    'client_id'  => $client->hashid
                ]);
                $html = <<<EOT
                    <div>
                        <div class="tooltip-core">
                            <a class="btn btn-sm btn-outline-danger btn-remove-relation" href="{$btnEditar}">
                                <i class="fa fa-trash"></i>
                            </a>
                            <span class="tooltiptext-core">Quitar asignación</span>
                        </div>
EOT;

                return $html;
            })
            ->rawColumns(['full_name', 'action'])
            ->make(true);
    }
}
