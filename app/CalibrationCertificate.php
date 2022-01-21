<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed expiration_date
 */
class CalibrationCertificate extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'sample_type',
        'calibration_date',
        'expiration_date',
        'path'
    ];

    protected $appends = ['hashid', 'check'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getCheckAttribute()
    {
        $expirationDate = $this->expiration_date;
        $fechaActual = Date("Y-m-d");

        if ($fechaActual > $expirationDate)
            return 'VENCIDO';

        return 'VIGENTE';
    }

    public function getSampleTypeAttribute()
    {
        return ucfirst($this->attributes['sample_type']);
    }
}
