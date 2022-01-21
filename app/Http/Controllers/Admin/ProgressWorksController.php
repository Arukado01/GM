<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\ProgressWork;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProgressWorksController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);
        $lastUpdate = $project->progressWorkLastUpdate();

        return view('admin.projects.progress_works.index', compact('project', 'lastUpdate'));
    }

    public function store(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $progressWork = new ProgressWork($request->all());
        $project->progressWorks()->save($progressWork);

        $lastUpdate = $project->progressWorkLastUpdate();
        return response([
            'message'     => 'Avance de Obra almacenado con éxito',
            'last_update' => $lastUpdate
        ]);
    }

    public function update(Request $request, $progress_work_id)
    {
        ProgressWork::find($progress_work_id)
            ->update($request->all());

        $lastUpdate = ProgressWork::orderBy('updated_at', 'decs')->first();
        if ($lastUpdate)
            $lastUpdate = $lastUpdate->updated_at->format('Y-m-d H:i:s');

        return response([
            'message'     => 'Avance de Obra editado con éxito',
            'last_update' => $lastUpdate
        ]);
    }

    public function delete($progress_work_id)
    {
        ProgressWork::find($progress_work_id)->delete();

        return response([
            'message' => 'Avance de Obra eliminado con éxito'
        ]);
    }

    public function getData($project_id)
    {
        $progressWorks = Project::find($project_id)->progressWorks()->get();

        $dt = DataTables::of($progressWorks)
            ->setRowId('hashid')
            ->addColumn('piloting_value', function ($progressWork) {
                return $progressWork->piloting;
            })
            ->editColumn('piloting', function ($progressWork) {
                return StringHelpers::getProgressBar($progressWork->piloting);
            })
            ->addColumn('foundation_value', function ($progressWork) {
                return $progressWork->foundation;
            })
            ->editColumn('foundation', function ($progressWork) {
                return StringHelpers::getProgressBar($progressWork->foundation);
            })
            ->addColumn('structure_value', function ($progressWork) {
                return $progressWork->structure;
            })
            ->editColumn('structure', function ($progressWork) {
                return StringHelpers::getProgressBar($progressWork->structure);
            })
            ->addColumn('masonry_value', function ($progressWork) {
                return $progressWork->masonry;
            })
            ->editColumn('masonry', function ($progressWork) {
                return StringHelpers::getProgressBar($progressWork->masonry);
            });


        $dt->addColumn('action', function ($progressWork) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.projects.progress_works.update', [
                'progress_work_id' => $progressWork->hashid
            ]);

            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Avance de Obra',
                true,
                'edit',
                null,
                'btn-edit-progress-work'
            );

            $routeDelete = route('admin.projects.progress_works.delete', ['progress_work_id' => $progressWork->hashid]);
            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Verificación',
                true,
                'trash',
                'danger',
                'btn-delete-progress-work'
            );

            $html .= '</div>';

            return $html;
        });

        $dt->rawColumns([
            'piloting',
            'foundation',
            'structure',
            'masonry',
            'action'
        ]);

        return $dt->make(true);
    }
}
