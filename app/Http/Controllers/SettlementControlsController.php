<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Project;
use Yajra\DataTables\Facades\DataTables;

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


        $dt->rawColumns([
            'observations'
        ]);

        return $dt->make(true);
    }
}
