<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Project;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param null $project_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id = null)
    {
        if (auth()->user()->isFirstSession())
            return redirect()->route('profile');

        $projects = auth()->user()->projects()->get();
        if ($project_id !== null) {
            $project = Project::find($project_id);
        } else {
            $project = $projects->first();
        }

        return view('home', compact('projects', 'project'));
    }

    public function getReportData($project_id)
    {
        $reports = Project::find($project_id);
        return response()->json($reports->reports()->select(['id', 'title', 'url', 'start'])->get(), 200);
    }

    public function getDataConcreteSamples($project_id)
    {
        $concrete_samples = Project::find($project_id)
            ->concreteSamples()
            ->orderBy('created_at', 'asc')
            ->get();


        $dt = DataTables::of($concrete_samples)
            ->setRowId('hashid')
            ->editColumn('destination', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->destination, 5);
            })
            ->addColumn('fc_seven_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_seven_days;
            })
            ->editColumn('fc_seven_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_seven_days);
            })
            ->addColumn('fc_fourteen_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_fourteen_days;
            })
            ->editColumn('fc_fourteen_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_fourteen_days);
            })
            ->addColumn('fc_twenty_eight_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_twenty_eight_days;
            })
            ->editColumn('fc_twenty_eight_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_twenty_eight_days);
            })
            ->addColumn('fc_fifty_six_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_fifty_six_days;
            })
            ->editColumn('fc_fifty_six_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_fifty_six_days);
            })
            ->addColumn('observations_value', function ($concrete_samples) {
                return $concrete_samples->observations;
            })
            ->addColumn('sclerometry_value', function ($concrete_samples) {
                return $concrete_samples->sclerometry;
            })
            ->editColumn('sclerometry', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->sclerometry, 15);
            })
            ->addColumn('provider_value', function ($concrete_samples) {
                return $concrete_samples->provider;
            })
            ->editColumn('provider', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->provider, 15);
            })
            ->addColumn('cores_value', function ($concrete_samples) {
                return $concrete_samples->cores;
            })
            ->editColumn('cores', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->cores, 15);
            })->addColumn('t_56_days_value', function ($concrete_samples) {
                return $concrete_samples->t_56_days;
            })->editColumn('t_56_days', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->t_56_days, 15);
            });

        $dt->rawColumns([
            'destination',
            'fc_seven_days',
            'fc_fourteen_days',
            'fc_twenty_eight_days',
            'fc_fifty_six_days',
            'sclerometry',
            'provider',
            'cores',
            't_56_days',
            'action'
        ]);

        return $dt->make(true);
    }

    public function getConcreteSampleObservations($project_id)
    {
        $project = Project::find($project_id)->concreteSamplesObservations()->get();
        return response()->json($project);
    }

    /*---------------------------------------------------------*/

    public function getQuantityCheckConcreteTestData($project_id)
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

        $dt->rawColumns([
            'destination',
            'observation',
        ]);

        return $dt->make(true);
    }

    public function getQuantityConcreteSampleObservations($project_id)
    {
        $observations = Project::find($project_id)->quantityCheckConcreteSamplesObservations()->get();

        return response()->json($observations, 200);
    }
}
