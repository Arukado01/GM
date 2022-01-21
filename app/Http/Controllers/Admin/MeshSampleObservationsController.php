<?php

namespace App\Http\Controllers\Admin;

use App\MeshSampleObservation;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeshSampleObservationsController extends Controller
{
    public function index($project_id)
    {
        $observations = Project::find($project_id)->meshSampleObservations()->get();

        return response($observations, 200);
    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $meshSampleObservation = new MeshSampleObservation($request->only('observations'));

        $project->meshSampleObservations()->save($meshSampleObservation);
        return response(['message' => 'Observación almacenada con éxito.'], 200);
    }

    public function update(Request $request, $mesh_sample_observation_id)
    {
        $observation = MeshSampleObservation::find($mesh_sample_observation_id)
            ->update($request->only('observations'));

        return response(['message' => 'Observación editada con éxito.'], 200);
    }

    public function delete($mesh_sample_observation_id)
    {
        MeshSampleObservation::find($mesh_sample_observation_id)->delete();

        return response(['message' => 'Observación eliminada con éxito.'], 200);
    }
}
