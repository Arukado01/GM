<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\SteelSampleObservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SteelSampleObservationsController extends Controller
{
    public function index($project_id)
    {
        $observations = Project::find($project_id)->steelSampleObservations()->get();

        return response($observations, 200);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $steelSampleObservation = new SteelSampleObservation($request->only('observations'));

        $project->steelSampleObservations()->save($steelSampleObservation);
        return response(['message' => 'Observación almacenada con éxito.'], 200);
    }

    public function update(Request $request, $steel_sample_observation_id)
    {
        $observation = SteelSampleObservation::find($steel_sample_observation_id)
            ->update($request->only('observations'));

        return response(['message' => 'Observación editada con éxito.'], 200);
    }

    public function delete($steel_sample_observation_id)
    {
        SteelSampleObservation::find($steel_sample_observation_id)->delete();
        return response(['message' => 'Observación eliminada con éxito.'], 200);
    }
}
