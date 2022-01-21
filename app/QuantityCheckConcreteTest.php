<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuantityCheckConcreteTest extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'date',
        'destination',
        'm3_fused',
        'cant_theoretical_samples',
        'cant_samples_taken',
        'observation',
    ];
    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    //Region Accessors && Mutator
    public function setM3FusedAttribute($value)
    {
        return $this->attributes['m3_fused'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setCantTheoreticalSamplesAttribute($value)
    {
        return $this->attributes['cant_theoretical_samples'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setCantSamplesTakenAttribute($value)
    {
        return $this->attributes['cant_samples_taken'] = ($value != null || !empty($value)) ? $value : 0;
    }
    //endregion

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
