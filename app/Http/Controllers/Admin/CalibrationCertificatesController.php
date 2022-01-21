<?php

namespace App\Http\Controllers\Admin;

use App\CalibrationCertificate;
use App\Helpers\StringHelpers;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CalibrationCertificatesController extends Controller
{
    public function index($project_id)
    {
        $project = Project::find($project_id);

        return view('admin.projects.calibration_certificates.index', compact('project'));
    }

    public function getData($project_id)
    {
        $certificates = Project::find($project_id)->calibrationCertificates()->get();

        $dt = DataTables::of($certificates)
            ->setRowId('hashid')
            ->setRowClass(function ($certificate) {
                $class = '';
                switch (strtolower($certificate->check)) {
                    case 'vigente':
                        $class = 'alert-success';
                        break;
                    case 'vencido':
                        $class = 'alert-danger';
                        break;
                }

                return $class;
            })
            ->editColumn('path', function ($certificate) {
                $route = asset($certificate->path);
                return StringHelpers::getBtn($route, 'Ver Certificado de Calibración', false, 'eye', 'info', null, '_black');
            });

        $dt->addColumn('action', function ($certificate) {
            $btnActions  = <<<EOT
                <div class="btn-group" role="group">
EOT;



            $routeEdit = route('admin.project.calibration_certificate.update', ['calibration_certificate_id' => $certificate->hashid]);
            $btnActions .= StringHelpers::getBtn(
                $routeEdit,
                'Editar Certificado de Calibración',
                true,
                'edit',
                null,
                'btn-edit-calibration-certificate'
            );

            $routeDelete = route('admin.project.calibration_certificate.delete', ['calibration_certificate_id' => $certificate->hashid]);
            $btnActions .= StringHelpers::getBtn(
                $routeDelete,
                'Eliminar Certificado de Calibración',
                true,
                'trash',
                'danger',
                'btn-delete-calibration-certificate'
            );
            $btnActions .= '</div>';
            return $btnActions;
        });


        $dt->rawColumns(['path', 'action']);
        return $dt->make(true);
    }

    public function store(Request $request, $project_id)
    {
        $file = $request->file('file');
        $expiration_date = Carbon::createFromFormat('Y-m-d', $request->calibration_date)
            ->addYear(1)
            ->toDateString();

        $project = Project::find($project_id);

        $name = Carbon::now()->second . '_' . $file->getClientOriginalName();
        $snakeProject = snake_case($project->name);
        $path = $file->storeAs('project_certificates/' . strtolower($snakeProject), $name, 'local_reports');

        $project->calibrationCertificates()->create([
            'sample_type'      => $request->sample_type,
            'calibration_date' => $request->calibration_date,
            'expiration_date'  => $expiration_date,
            'path'             => $path
        ]);


        return response([
            'message' => 'Certificado de calibración almacenado con éxito',
        ]);
    }

    public function update(Request $request, $calibration_certificate_id)
    {
        $calibration_certificate = CalibrationCertificate::find($calibration_certificate_id);

        if ($request->hasFile('file')) {
            Storage::disk('local_reports')->delete($calibration_certificate->path);

            $file = $request->file('file');
            $name = Carbon::now()->second . '_' . $file->getClientOriginalName();

            $snakeProject = snake_case($calibration_certificate->project->name);
            $path = $file->storeAs('project_certificates/' . strtolower($snakeProject), $name, 'local_reports');

            $calibration_certificate->path = $path;
        }

        $expiration_date = Carbon::createFromFormat('Y-m-d', $request->calibration_date)
            ->addYear(1)
            ->toDateString();

        $calibration_certificate->sample_type = $request->sample_type;
        $calibration_certificate->calibration_date = $request->calibration_date;
        $calibration_certificate->expiration_date = $expiration_date;

        $calibration_certificate->save();

        return response([
            'message' => 'Certificado de calibración editado con éxito',
        ]);
    }

    public function delete($calibration_certificate_id)
    {
        $calibration_certificate = CalibrationCertificate::find($calibration_certificate_id);
        Storage::disk('local_reports')->delete($calibration_certificate->path);
        $calibration_certificate->forceDelete();

        return response([
            'message' => 'Certificado de calibración eliminado con éxito',
        ]);
    }
}
