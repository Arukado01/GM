<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuantityCheckSampleObservation extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = ['observations', 'quantity_check_type'];
    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
