<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\Zone;
use App\ZoneFloor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ZoneCheckedController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);

        return view('admin.projects.zones_checked.index', compact('project'));
    }

    public function store(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $floors = json_decode(json_encode($request->floors), FALSE);


        $newZone = new Zone([
            'name' => $request->zone_name
        ]);

        $project->zones()->save($newZone);

        foreach ($floors AS $floor) {
            $newFloor = new ZoneFloor([
                'number'  => $floor->number,
                'checked' => $floor->checked
            ]);

            $newZone->floors()->save($newFloor);

        }

        $zone = Zone::with('floors')->find($newZone->id);
        return response([
            'message' => 'Verificación Zona almacenada con éxito.',
            'zone'    => $zone
        ]);
    }

    public function getData($project_id)
    {
        $zones = Zone::where('project_id', $project_id)->with('floors')->get();

        return response($zones);
    }

    public function FloorStateUpdate($floor_id)
    {
        $floorState = ZoneFloor::find($floor_id)->changeStatus();

        return response(['state' => $floorState, 'id' => $floor_id]);
    }

    public function UploadPdf(Request $request, $zone_id)
    {
        $file = $request->file('file');
        $zone = Zone::find($zone_id);

        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('zones_pdf', $name, 'local_reports');

        $zone->pdf_path = $path;

        $zone->save();

        return response()->json(['message' => 'Informe Almacenado con éxito'], 200);
    }

    public function deletePdf($zone_id)
    {
        $zone = Zone::find($zone_id);


        try {
            if (Storage::disk('local_reports')->delete($zone->pdf_path)) {
                $zone->pdf_path = NULL;
                $zone->save();
                return response(['message' => 'Informe eliminado con éxito'], 200);
            } else {
                return response(['message' => 'No se pudo eliminar el archivo'], 200);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 200);
        }
    }

    public function updateObservations(Request $request, $zone_id)
    {
        $zone = Zone::find($zone_id);

        $zone->observations = $request->observations;
        $zone->save();

        return response(['message' => 'Observación almacenada con éxito'], 200);
    }
}
