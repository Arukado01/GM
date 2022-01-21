<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SteelSample extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = ['date', 'use', 'type', 'fy_mpa', 'fu_mpa', 'observations'];
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
    //endregion

    //region Relation Ships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    //endregion
}
