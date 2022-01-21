<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConcreteSampleObservation extends Model
{
    use SoftDeletes, HashIdField;
    protected $fillable = [
        'observations',
    ];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    //region Relation Ships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    //endregion
}
