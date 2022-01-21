<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\QuantityCheckSampleObservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuantityCheckSampleObservationsController extends Controller
{
    public function index(Request $request, $project_id)
    {
        $observations = Project::find($project_id)
            ->quantityCheckSampleObservations()
            ->where('quantity_check_type', $request->quantity_check_type)->get();

        return response($observations, 200);

    }

    public function create(Request $request, $project_id)
    {
        $project = Project::find($project_id);
        $observation = new QuantityCheckSampleObservation($request->only(['observations', 'quantity_check_type']));

        $project->quantityCheckSampleObservations()->save($observation);

        return response(['message' => 'Observación almacenada con éxito']);
    }

    public function update(Request $request, $quantity_check_sample_obs_id)
    {
        $observation = QuantityCheckSampleObservation::find($quantity_check_sample_obs_id)
            ->update($request->only('observations'));

        return response(['message' => 'Observación editada con éxito']);
    }

    public function delete($quantity_check_sample_obs_id)
    {
        QuantityCheckSampleObservation::find($quantity_check_sample_obs_id)
            ->delete();

        return response(['message' => 'Observación eliminada con éxito']);
    }
}
