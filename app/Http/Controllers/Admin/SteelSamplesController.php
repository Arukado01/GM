<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Project;
use App\SteelSample;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SteelSamplesController extends Controller
{
    public function index($project_id)
    {
        $steelSamples = Project::find($project_id)->steelSamples()->get();
        $dt = DataTables::of($steelSamples)
            ->setRowId('hashid')
            ->addColumn('use_value', function ($steelSample) {
                return $steelSample->use;
            })
            ->editColumn('use', function ($steelSample) {
                return StringHelpers::getToolTip($steelSample->use, 15);
            })
            ->addColumn('observations_value', function ($steelSample) {
                return $steelSample->observations;
            })
            ->editColumn('observations', function ($steelSample) {
                return StringHelpers::getToolTip($steelSample->observations, 15);

            });

        $dt->addColumn('action', function ($steelSample) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.project.steel_samples.update', ['steel_sample_id' => $steelSample->hashid]);

            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Muestra',
                true,
                'edit',
                null,
                'btn-edit-steel-sample'
            );

            $routeDelete = route('admin.project.steel_samples.delete', ['steel_sample_id' => $steelSample->hashid]);
            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Muestra',
                true,
                'trash',
                'danger',
                'btn-delete-steel-sample'
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

        $steelSample = new SteelSample($request->all());
        $project->steelSamples()->save($steelSample);

        $lastUpdate = $project->saveOrEditLastUpdate('sample_steel');

        return response()->json([
            'message' => 'Muestra de acero almacenada con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function update(Request $request, $steel_sample_id)
    {
        $steelSample = SteelSample::find($steel_sample_id);
        $steelSample->update($request->all());

        $project = $steelSample->project()->first();
        $lastUpdate = $project->saveOrEditLastUpdate('sample_steel');

        return response([
            'message' => 'Verificación de acero editada con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function delete($steel_sample_id)
    {
        SteelSample::find($steel_sample_id)->delete();

        return response([
            'message' => 'Verificación de acero eliminada con éxito.',
        ], 200);
    }
}
