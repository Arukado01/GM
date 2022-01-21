<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Http\Controllers\Controller;
use App\Project;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);

        return view('admin.reports.index', compact('project'));
    }

    public function store(Request $request, $project_id)
    {
        $file = $request->file('file');
        $project = Project::find($project_id);


        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $title = $fileName;

        if ($request->has('title') && $request->title !== null) {
            $title = $request->title;
        }


        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('reports_pdf', $name, 'local_reports');

        $project->reports()->create([
            'title'   => $title,
            'url'     => $path,
            'start'   => $request->date,
            'user_id' => $request->user()->id
        ]);

        return response()->json(['message' => 'Reporte agregado exitosamente'], 200);
    }

    public function getReportsData($project_id)
    {
        $projects = Project::find($project_id)->reports()->orderBy('created_at', 'desc')->get();
        return DataTables::of($projects)
            ->setRowId('hashid')
            ->editColumn('url', function ($project) {
                return '<a href="' . asset($project->url) . '" target="_blank">'
                    . str_limit(asset($project->url), 30) . '  <i class="fa fa-external-link"></i>'
                    . '</a>';
            })
            ->addColumn('action', function ($project) {
                $html = '<div class="btn-group">';

                $routeDelete = route('admin.projects.reports.delete', ['concrete_sample_id' => $project->hashid]);
                $html .= StringHelpers::getBtn(
                    $routeDelete,
                    'Eliminar Muestra',
                    true,
                    'trash',
                    'danger',
                    'btn-delete-report'
                );
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['url', 'action'])
            ->make();
    }

    public function delete($report_id)
    {
        $report = Report::find($report_id);

        Storage::disk('local_reports')->delete($report->url);

        $report->forceDelete();

        return response([
            'message' => 'Certificado de calibración eliminado con éxito',
        ]);
    }
}
