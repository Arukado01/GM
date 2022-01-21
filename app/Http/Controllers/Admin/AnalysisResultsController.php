<?php

namespace App\Http\Controllers\Admin;

use App\ConcreteSample;
use App\ConcreteSampleObservation;
use App\Helpers\StringHelpers;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class AnalysisResultsController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);

        if (empty($project))
            abort(401, 'El recurso solicitado no existe en la base de datos.');

        return view('admin.analysis.index', compact('project'));


    }

    public function getConcreteSamplesData($project_id)
    {
        $concrete_samples = Project::find($project_id)->concreteSamples()->orderBy('created_at', 'asc')->get();


        $dt = DataTables::of($concrete_samples)
            ->setRowId('hashid')->addColumn('destination_value', function ($concrete_samples) {
                return $concrete_samples->destination;
            })->editColumn('destination', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->destination, 5);
            })->addColumn('fc_seven_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_seven_days;
            })->editColumn('fc_seven_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_seven_days);
            })->addColumn('fc_fourteen_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_fourteen_days;
            })->editColumn('fc_fourteen_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_fourteen_days);
            })->addColumn('fc_twenty_eight_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_twenty_eight_days;
            })->editColumn('fc_twenty_eight_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_twenty_eight_days);
            })->addColumn('fc_fifty_six_days_value', function ($concrete_samples) {
                return $concrete_samples->fc_fifty_six_days;
            })->editColumn('fc_fifty_six_days', function ($concrete_samples) {
                return StringHelpers::getProgressBar($concrete_samples->fc_fifty_six_days);
            })->addColumn('sclerometry_value', function ($concrete_samples) {
                return $concrete_samples->sclerometry;
            })->editColumn('sclerometry', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->sclerometry, 15);
            })->addColumn('provider_value', function ($concrete_samples) {
                return $concrete_samples->provider;
            })->editColumn('provider', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->provider, 15);
            })->addColumn('cores_value', function ($concrete_samples) {
                return $concrete_samples->cores;
            })->editColumn('cores', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->cores, 15);
            })->addColumn('t_56_days_value', function ($concrete_samples) {
                return $concrete_samples->t_56_days;
            })->editColumn('t_56_days', function ($concrete_samples) {
                return StringHelpers::getToolTip($concrete_samples->t_56_days, 15);
            });

        $dt->addColumn('action', function ($concrete_samples) {
            $html = '<div class="btn-group">';
            $routeEdit = route('admin.project.analysis.update_concrete_samples', ['concrete_sample_id' => $concrete_samples->hashid]);
            $html .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Muestra',
                true,
                'edit',
                null,
                'btn-edit-concrete-sample'
            );

            $routeDelete = route('admin.project.analysis.delete_concrete_samples', ['concrete_sample_id' => $concrete_samples->hashid]);
            $html .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Muestra',
                true,
                'trash',
                'danger',
                'btn-delete-concrete-sample'
            );
            $html .= '</div>';

            return $html;
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

    public function saveConcreteSample(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $concreteSample = new ConcreteSample([
            'date'                 => $request->date,
            'destination'          => $request->destination,
            'type'                 => $request->type,
            'sample'               => $request->sample,
            'fc_seven_days'        => $request->fc_seven_days,
            'fc_fourteen_days'     => $request->fc_fourteen_days,
            'fc_twenty_eight_days' => $request->fc_twenty_eight_days,
            'fc_fifty_six_days'    => $request->fc_fifty_six_days,
            't_56_days'            => $request->t_56_days,
            'sclerometry'          => $request->sclerometry,
            'provider'             => $request->provider,
            'cores'                => $request->cores,
        ]);

        $project->concreteSamples()->save($concreteSample);
        $project->concreteSamples()->save($concreteSample);

        $lastUpdate = $project->saveOrEditLastUpdate('sample_concrete');

        return response()->json([
            'message'     => 'Muestra creada con éxito',
            'last_update' => $lastUpdate
        ]);
    }

    public function updateConcreteSample(Request $request, $concrete_sample_id)
    {
        $concreteSample = ConcreteSample::find($concrete_sample_id);
        $concreteSample->update($request->all());

        $project = $concreteSample->project()->first();
        $lastUpdate = $project->saveOrEditLastUpdate('sample_concrete');


        return response([
            'message'     => 'Información editada con éxito.',
            'last_update' => $lastUpdate
        ]);
    }

    public function deleteConcreteSample($concrete_sample_id)
    {
        ConcreteSample::find($concrete_sample_id)->delete();

        return response(['message' => 'Información eliminada con éxito.']);
    }

    public function getConcreteSampleObservations($project_id)
    {
        $project = Project::find($project_id)->concreteSamplesObservations()->get();

        return response()->json($project);
    }

    public function saveConcreteSampleObservations(Request $request, $project_id)
    {
        $observation = new ConcreteSampleObservation([
            'observations' => $request->observations
        ]);

        Project::find($project_id)->concreteSamplesObservations()->save($observation);

        return response(['message' => 'Observación almacenada con éxito']);
    }

    public function editConcreteSampleObservations(Request $request, $concrete_sample_observation_id)
    {
        ConcreteSampleObservation::find($concrete_sample_observation_id)->update(
            $request->only('observations')
        );
        return response(['message' => 'Observación editada con éxito'], 200);
    }

    public function deleteConcreteSampleObservations($concrete_sample_observation_id)
    {
        ConcreteSampleObservation::find($concrete_sample_observation_id)->delete();

        return response(['message' => 'Observación eliminada con éxito'], 200);
    }
}
