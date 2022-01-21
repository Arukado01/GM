<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConcreteSample extends Model
{
    use SoftDeletes, HashIdField;
    protected $fillable = [
        'date',
        'destination',
        'type',
        'sample',
        'fc_seven_days',
        'fc_fourteen_days',
        'fc_twenty_eight_days',
        'fc_fifty_six_days',
        'sclerometry',
        'provider',
        'cores',
        't_56_days',
    ];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];


    //region Accessors Mutator
    public function setFcSevenDaysAttribute($value)
    {
        $this->attributes['fc_seven_days'] = empty($value) ? 0 : $value;
    }

    public function setFcFourteenDaysAttribute($value)
    {
        $this->attributes['fc_fourteen_days'] = empty($value) ? 0 : $value;
    }

    public function setFcTwentyEightDaysAttribute($value)
    {
        $this->attributes['fc_twenty_eight_days'] = empty($value) ? 0 : $value;
    }

    public function setFcFiftySixDaysAttribute($value)
    {
        $this->attributes['fc_fifty_six_days'] = empty($value) ? 0 : $value;
    }

    public function setSampleAttribute($value)
    {
        $this->attributes['sample'] = empty($value) ? 'NO' : $value;
    }
    //endregion

    //region Relation Ships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    //endregion
}
