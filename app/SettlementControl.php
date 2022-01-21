<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettlementControl extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = ['zone', 'start_date', 'last_date', 'max_area', 'observations'];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];


    //Region Mutator & Accessors
    public function setMaxAreaAttribute($value)
    {
        $this->attributes['max_area'] = empty($value) ? 0 : $value;
    }

    public function setObservationsAttribute($value)
    {
        $this->attributes['observations'] = empty($value) ? '' : $value;
    }

    //endregion

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
