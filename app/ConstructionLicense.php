<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstructionLicense extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'path',
    ];
    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
