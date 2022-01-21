<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class StateObservationsController extends Controller
{
    public function index($project_id)
    {
        $stateObservations = Project::find($project_id)->stateObservations;

        return response($stateObservations, 200);
    }
}
