<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LastDateUpdate extends Model
{
    use HashIdField;

    /*
        'sample_concrete',
        'verify_concrete',
        'sample_steel',
        'verify_steel',
        'sample_mesh',
        'verify_mesh'
    */
    protected $fillable = [
        'last_update',
        'type'
    ];

    protected $appends = ['hashid', 'project_id'];
    protected $hidden = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
