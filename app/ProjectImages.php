<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed url
 */
class ProjectImages extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'date',
        'url',
        'description'
    ];
    protected $appends = ['hashid', 'full_url'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getFullUrlAttribute()
    {
        return asset($this->url);
    }
}
