<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CalibrationCertificatesController extends Controller
{
    public function getData($project_id)
    {
        $certificates = Project::find($project_id)->calibrationCertificates()->get();

        $dt = DataTables::of($certificates)
            ->setRowId('hashid')
            ->setRowClass(function ($certificate) {
                $class= '';
                switch (strtolower($certificate->check)) {
                    case 'vencido':
                        $class = 'alert-danger';
                        break;
                }

                return  $class;
            })
            ->editColumn('path', function ($certificate) {
                $route = asset($certificate->path);
                return StringHelpers::getBtn($route, 'Ver Certificado de Calibración', false, 'eye', 'info', null, '_black');
            });


        $dt->rawColumns(['path']);
        return $dt->make(true);
    }
}
