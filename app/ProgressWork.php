<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgressWork extends Model
{
    use SoftDeletes, HashIdField;
    protected $fillable = [
        'zone',
        'piloting',
        'foundation',
        'structure',
        'masonry'
    ];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_a t'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    //Region Accessors && Mutator
    public function setPilotingAttribute($value)
    {
        return $this->attributes['piloting'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setFoundationAttribute($value)
    {
        return $this->attributes['foundation'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setStructureAttribute($value)
    {
        return $this->attributes['structure'] = ($value != null || !empty($value)) ? $value : 0;
    }

    public function setMasonryAttribute($value)
    {
        return $this->attributes['masonry'] = ($value != null || !empty($value)) ? $value : 0;
    }
    //region
}
