<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Project;
use Illuminate\Http\Request;
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
                return StringHelpers::getToolTip($steelSample->observations, 17);

            });


        $dt->rawColumns([
            'use',
            'observations',
        ]);

        return $dt->make(true);
    }

    public function getSampleObservations($project_id)
    {
        $observations = Project::find($project_id)->steelSampleObservations()->get();

        return response($observations, 200);
    }

    public function getQuantityCheckSamplesData(Request $request, $project_id)
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

        $dt->rawColumns([
            'zone',
            'percent_approx_advance',
        ]);

        return $dt->make(true);
    }

    public function getQuantityCheckSampleObservations(Request $request, $project_id)
    {
        $observations = Project::find($project_id)
            ->quantityCheckSampleObservations()
            ->where('quantity_check_type', $request->quantity_check_type)->get();

        return response($observations, 200);

    }
}
