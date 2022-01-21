<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\MeshSample;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MeshSampleController extends Controller
{
    public function index($project_id)
    {
        $meshSamples = Project::find($project_id)->meshSamples()->get();
        $dt = DataTables::of($meshSamples)
            ->setRowId('hashid')
            ->addColumn('use_value', function ($meshSample) {
                return $meshSample->use;
            })
            ->editColumn('use', function ($meshSample) {
                return StringHelpers::getToolTip($meshSample->use, 15);
            })
            ->addColumn('observations_value', function ($meshSample) {
                return $meshSample->observations;
            })
            ->editColumn('observations', function ($meshSample) {
                return StringHelpers::getToolTip($meshSample->observations, 15);

            });

        $dt->addColumn('action', function ($meshSample) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.project.mesh_samples.update', ['mesh_sample_id' => $meshSample->hashid]);
            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Muestra',
                true,
                'edit',
                null,
                'btn-edit-mesh-sample'
            );

            $routeDelete = route('admin.project.mesh_samples.delete', ['mesh_sample_id' => $meshSample->hashid]);
            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Muestra',
                true,
                'trash',
                'danger',
                'btn-delete-mesh-sample'
            );
            $html .= '</div>';

            return $html;
        });


        $dt->rawColumns([
            'use',
            'observations',
            'action'
        ]);

        return $dt->make(true);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $meshSample = new MeshSample($request->all());

        $project->meshSamples()->save($meshSample);

        $lastUpdate = $project->saveOrEditLastUpdate('sample_mesh');

        return response()->json([
            'message' => 'Ensayo de mallas almacenado con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function update(Request $request, $mesh_sample_id)
    {
        $meshSample = MeshSample::find($mesh_sample_id);
        $meshSample->update($request->all());

        $project = $meshSample->project()->first();
        $lastUpdate = $project->saveOrEditLastUpdate('sample_mesh');

        return response([
            'message' => 'Ensayo de malla editado con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function delete($mesh_sample_id)
    {
        MeshSample::find($mesh_sample_id)->delete();
        return response([
            'message' => 'Ensayo de malla editado con éxito.'
        ], 200);
    }
}
