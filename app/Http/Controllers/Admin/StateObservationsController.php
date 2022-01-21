<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\StateObservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateObservationsController extends Controller
{
    public function index($project_id)
    {
        $stateObservations = Project::find($project_id)->stateObservations;

        return response($stateObservations, 200);
    }

    public function store(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $stateObservation = new StateObservation($request->all());

        $project->stateObservations()->save($stateObservation);

        return response(['message' => 'Estado de Observaciones almacenado con éxito.'], 200);
    }

    public function update(Request $request, $state_observation_id)
    {
        StateObservation::find($state_observation_id)
            ->update($request->all());

        return response(['message' => 'Estado de Observaciones editado con éxito.'], 200);
    }
}
