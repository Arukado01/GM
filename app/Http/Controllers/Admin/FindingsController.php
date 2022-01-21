<?php

namespace App\Http\Controllers\Admin;

use App\Finding;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FindingsController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);
        return view('admin.projects.findings.index', compact('project'));
    }

    public function store(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $finding = new Finding([
            'date'    => $request->date,
            'affair'  => $request->affair,
            'finding' => $request->finding
        ]);

        $project->findings()->save($finding);

        return response(['message' => 'Hallazgo almacenado con éxito.']);
    }

    public function getData($project_id)
    {
        $findings = Project::find($project_id)->findings()->orderBy('date', 'desc')->get();

        return response(compact('findings'), 200);
    }

    public function update(Request $request, $finding_id)
    {
        Finding::find($finding_id)->update($request->all());
        return response(['message' => 'Hallazgo editado con éxito.']);
    }

    public function delete($finding_id)
    {
        Finding::find($finding_id)->delete();
        return response(['message' => 'Hallazgo eliminado con éxito.']);
    }
}
