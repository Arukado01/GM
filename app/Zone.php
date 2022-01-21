<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property String observations
 */
class Zone extends Model
{
    use SoftDeletes, HashIdField;
    protected $fillable = [
        'name',
        'path_pdf',
        'observations'
    ];

    protected $appends = ['hashid', 'route_pdf'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_a t'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function floors()
    {
        return $this->hasMany(ZoneFloor::class);
    }

    //region Mutator and Accessors
    public function getRoutePdfAttribute()
    {
        return asset($this->pdf_path);
    }
    //endregion
}
