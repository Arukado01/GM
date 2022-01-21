<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelpers;
use App\Project;
use App\SettlementControl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class SettlementControlsController extends Controller
{
    public function index($project_id)
    {
        $settlementControls = Project::find($project_id)->settlementControls()->get();

        $dt = DataTables::of($settlementControls)
            ->setRowId('hashid')
            ->addColumn('observations_value', function ($settlementControl) {
                return $settlementControl->observations;
            })
            ->editColumn('observations', function ($settlementControl) {
                return StringHelpers::getToolTip($settlementControl->observations, 15);

            });

        $dt->addColumn('action', function ($settlementControl) {
            $html = '<div class="btn-group">';

            $routeEdit = route('admin.project.settlement_control.update', [
                'settlement_control_id' => $settlementControl->hashid
            ]);

            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Control de Asentamiento',
                true,
                'edit',
                null,
                'btn-edit-settlement-sample'
            );

            $routeDelete = route('admin.project.settlement_control.delete', [
                'settlement_control_id' => $settlementControl->hashid
            ]);

            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Control de Asentamiento',
                true,
                'trash',
                'danger',
                'btn-delete-settlement-sample'
            );
            $html .= '</div>';

            return $html;
        });


        $dt->rawColumns([
            'observations',
            'action'
        ]);

        return $dt->make(true);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);
        $settlementControl = new SettlementControl($request->all());

        $project->settlementControls()->save($settlementControl);

        return response(['message' => 'Control de asentamiento almacenado con éxito.']);
    }

    public function update(Request $request, $settlement_control_id)
    {
        SettlementControl::find($settlement_control_id)
            ->update($request->all());

        return response(['message' => 'Control de asentamiento editado con éxito.']);
    }

    public function delete($settlement_control_id)
    {
        SettlementControl::find($settlement_control_id)->delete();
        return response(['message' => 'Control de asentamiento eliminado con éxito.']);
    }
}
