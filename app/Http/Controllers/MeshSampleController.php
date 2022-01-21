<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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

        $dt->rawColumns([
            'use',
            'observations',
            'action'
        ]);

        return $dt->make(true);
    }

    public function getMeshSampleObservations($project_id)
    {
        $observations = Project::find($project_id)->meshSampleObservations()->get();

        return response($observations, 200);
    }
}
