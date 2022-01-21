<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EspTecController extends Controller
{
    public function store(Request $request, $project_id)
    {
        $file = $request->file('file');
        $project = Project::find($project_id);

        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $snakeProject = snake_case($project->name);
        $path = $file->storeAs('quality_plan/' . strtolower($snakeProject), $name, 'local_reports');
        /*chmod("$path", 777);*/
        if (empty($project->espTec()->first())) {
            $project->espTec()->create([
                'path' => $path
            ]);
        } else {
            Storage::disk('local_reports')->delete($project->espTec()->first()->path);
            $project->espTec()->first()->update([
                'path' => $path
            ]);
        }

        return response([
            'message' => 'Especificación Técnica almacenado con éxito.',
            'path'    => asset($path)
        ]);
    }
}
