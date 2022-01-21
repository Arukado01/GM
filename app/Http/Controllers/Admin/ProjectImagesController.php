<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\ProjectImages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectImagesController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);

        return view('admin.projects.images.index', compact('project'));
    }

    public function create(Request $request, $project_id)
    {
        $file = $request->file('file');
        $project = Project::find($project_id);

        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('project_images/' . strtolower(snake_case($project->name)), $name, 'local_reports');

        $project->projectImages()->create([
            'description' => $request->description,
            'url'         => $path,
            'date'        => $request->date,
        ]);

        return response()->json(['message' => 'Reporte agregado exitosamente'], 200);
    }

    public function getData($project_id)
    {
        $query = Project::find($project_id)->projectImages();

        if (!auth()->user()->isClient())
            $query = $query->withTrashed();

        $images = $query->orderBy('date', 'des')->get();
        return response($images);
    }

    public function delete(Request $request, $project_image_id)
    {
        $image = ProjectImages::withTrashed()->find($project_image_id);
        $message = 'Imagen deshabilitada con éxito.';
        if ($request->has('sof_delete')) {
            $image->delete();
        } else {
            Storage::disk('local_reports')->delete($image->url);
            $image->forceDelete();
            $message = 'Imagen eliminada con éxito.';
        }

        return response(compact('message'), 200);
    }

    public function restore($project_image_id)
    {
        ProjectImages::withTrashed()->find($project_image_id)->restore();

        $message = 'Imagen restaurada con éxito.';
        return response(compact('message'), 200);
    }
}
