<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuantityCheckSample extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'zone',
        'approx_area',
        'approx_intake',
        'cant_theoretical_sample',
        'percent_approx_advance',
        'test_performed',
        'pending_test_validation',
        'quantity_check_type'
    ];
    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    //Region Accessors && Mutator
    public function setApproxIntakeAttribute($value)
    {
        return $this->attributes['approx_intake'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setCantTheoreticalSampleAttribute($value)
    {
        return $this->attributes['cant_theoretical_sample'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setPercentApproxAdvanceAttribute($value)
    {
        return $this->attributes['percent_approx_advance'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setTestPerformedAttribute($value)
    {
        return $this->attributes['test_performed'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setPendingTestValidationAttribute($value)
    {
        return $this->attributes['pending_test_validation'] = ($value != null || !empty($value)) ? $value : 0;
    }
    //endregion

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
