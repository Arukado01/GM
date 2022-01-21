<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ConstructionLicenseController extends Controller
{
    public function store(Request $request, $project_id)
    {
        $file = $request->file('file');
        $project = Project::find($project_id);

        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $snakeProject = snake_case($project->name);
        $path = $file->storeAs('project_licences/' . strtolower($snakeProject), $name, 'local_reports');
        if (empty($project->licenses()->first())) {
            $project->licenses()->create([
                'path' => $path
            ]);
        } else {
            Storage::disk('local_reports')->delete($project->licenses()->first()->path);
            $project->licenses()->first()->update([
                'path' => $path
            ]);
        }

        return response([
            'message' => 'Licencia de Construcción almacenada con éxito.',
            'path'    => asset($path)
        ]);
    }
}
