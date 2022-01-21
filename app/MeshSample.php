<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeshSample extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'date',
        'use',
        'diameter',
        'fy_mpa',
        'fu_mpa',
        'p_sold_min',
        'p_sold',
        'observations'
    ];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];


    //Region Mutator & Accessors
    public function setFyMpaAttribute($value)
    {
        $this->attributes['fy_mpa'] = empty($value) ? 0 : $value;
    }

    public function setFuMpaAttribute($value)
    {
        $this->attributes['fu_mpa'] = empty($value) ? 0 : $value;
    }

    public function setPSoldMinAttribute($value)
    {
        $this->attributes['p_sold_min'] = empty($value) ? 0 : $value;
    }

    public function setPSoldAttribute($value)
    {
        $this->attributes['p_sold'] = empty($value) ? 0 : $value;
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
