<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Project;
use App\QuantityCheckConcreteTest;
use App\QuantityCheckConcreteTestObservation;
use App\QuantityCheckSampleObservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuantityCheckConcreteTestController extends Controller
{
    public function getData($project_id)
    {
        $quantityChecks = Project::find($project_id)->quantityCheckConcreteSamples()->get();

        $dt = DataTables::of($quantityChecks)
            ->setRowId('hashid')
            ->addColumn('destination_value', function ($quantityCheck) {
                return $quantityCheck->destination;
            })
            ->editColumn('destination', function ($quantityCheck) {
                return StringHelpers::getToolTip($quantityCheck->destination, 30);
            })
            ->addColumn('observation_value', function ($quantityCheck) {
                return $quantityCheck->observation;
            })
            ->editColumn('observation', function ($quantityCheck) {
                return StringHelpers::getToolTip($quantityCheck->observation, 30);

            });

        $dt->addColumn('action', function ($quantityCheck) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.project.quantity_check_test.update', ['quantity_concrete_test_id' => $quantityCheck->hashid]);
            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Hallazgo',
                true,
                'edit',
                null,
                'btn-edit-quantity-test'
            );

            $routeDelete = route('admin.project.quantity_check_test.delete', ['quantity_concrete_test_id' => $quantityCheck->hashid]);
            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Hallazgo',
                true,
                'trash',
                'danger',
                'btn-delete-quantity-test'
            );
            $html .= '</div>';

            return $html;
        });


        $dt->rawColumns([
            'destination',
            'observation',
            'action'
        ]);

        return $dt->make(true);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $qualityCheck = new QuantityCheckConcreteTest($request->all());
        $project->quantityCheckConcreteSamples()->save($qualityCheck);

        $lastUpdate = $project->saveOrEditLastUpdate('verify_concrete');

        return response([
            'message'     => 'Verificación almacenada con éxito',
            'last_update' => $lastUpdate
        ]);
    }

    public function update(Request $request, $quantity_concrete_test_id)
    {
        $quantity = QuantityCheckConcreteTest::find($quantity_concrete_test_id);
        $quantity->update($request->all());

        $project = $quantity->project()->first();
        $lastUpdate = $project->saveOrEditLastUpdate('verify_concrete');


        return response([
            'message' => 'Verificación editada con éxito',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function delete($quantity_concrete_test_id)
    {
        QuantityCheckConcreteTest::find($quantity_concrete_test_id)->delete();

        return response(['message' => 'Información eliminada con éxito.']);
    }

    public function getQuantityConcreteSampleObservations($project_id)
    {
        $observations = Project::find($project_id)->quantityCheckConcreteSamplesObservations()->get();

        return response()->json($observations, 200);
    }

    public function saveQuantityConcreteSampleObservations(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $observation = new QuantityCheckConcreteTestObservation($request->only('observation'));

        $project->quantityCheckConcreteSamplesObservations()->save($observation);

        return response(['message' => 'Observación almacenada con éxito.'], 200);
    }

    public function editQuantityConcreteSampleObservations(Request $request, $quantity_check_concrete_test_observation_id)
    {
        $observation = QuantityCheckConcreteTestObservation::find($quantity_check_concrete_test_observation_id)
            ->update($request->only('observation'));

        return response(['message' => 'Observación editada con éxito.'], 200);
    }

    public function deleteQuantityConcreteSampleObservations($quantity_check_concrete_test_observation_id)
    {
        QuantityCheckConcreteTestObservation::find($quantity_check_concrete_test_observation_id)
            ->delete();

        return response(['message' => 'Observación eliminada con éxito.'], 200);
    }
}
