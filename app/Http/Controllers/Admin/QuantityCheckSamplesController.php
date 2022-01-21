<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Project;
use App\QuantityCheckSample;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuantityCheckSamplesController extends Controller
{
    public function index(Request $request, $project_id)
    {
        $quantityCheckSamples = Project::find($project_id)->quantityCheckSamples()
            ->where('quantity_check_type', $request->quantity_check_type)->get();
        $dt = DataTables::of($quantityCheckSamples)
            ->setRowId('hashid')
            ->addColumn('zone_value', function ($quantityCheckSample) {
                return $quantityCheckSample->zone;
            })
            ->editColumn('zone', function ($quantityCheckSample) {
                return StringHelpers::getToolTip($quantityCheckSample->zone, 15);
            })
            ->addColumn('percent_approx_advance_value', function ($quantityCheckSample) {
                return $quantityCheckSample->percent_approx_advance;
            })
            ->editColumn('percent_approx_advance', function ($quantityCheckSample) {
                return StringHelpers::getProgressBar($quantityCheckSample->percent_approx_advance);

            });

        $dt->addColumn('action', function ($quantityCheckSample) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.project.quantity_check_sample.update', [
                'quantity_check_samples_id' => $quantityCheckSample->hashid
            ]);

            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Verificación',
                true,
                'edit',
                null,
                'btn-edit-' . $quantityCheckSample->quantity_check_type . '-quantity-check-sample'
            );

            $routeDelete = route('admin.project.quantity_check_sample.delete', [
                'quantity_check_samples_id' => $quantityCheckSample->hashid
            ]);

            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Verificación',
                true,
                'trash',
                'danger',
                'btn-delete-' . $quantityCheckSample->quantity_check_type . '-quantity-check-sample'
            );
            $html .= '</div>';

            return $html;
        });


        $dt->rawColumns([
            'zone',
            'percent_approx_advance',
            'action'
        ]);

        return $dt->make(true);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $quantityCheckSample = new QuantityCheckSample($request->all());
        $project->quantityCheckSamples()->save($quantityCheckSample);

        $lastUpdate = $project->saveOrEditLastUpdate('verify_' . $request->quantity_check_type);

        return response()->json([
            'message'     => 'Verificación de muestra almacenada con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function update(Request $request, $quantity_check_samples_id)
    {

        $quantityCheckSamples = QuantityCheckSample::find($quantity_check_samples_id);
        $quantityCheckSamples->update($request->all());

        $project = $quantityCheckSamples->project()->first();
        $lastUpdate = $project->saveOrEditLastUpdate('verify_' . $quantityCheckSamples->quantity_check_type);

        return response([
            'message'     => 'Verificación de muestra editada con éxito.',
            'last_update' => $lastUpdate
        ], 200);
    }

    public function delete($quantity_check_samples_id)
    {
        QuantityCheckSample::find($quantity_check_samples_id)->delete();

        return response([
            'message'     => 'Verificación de muestra eliminada con éxito.'
        ], 200);
    }
}
