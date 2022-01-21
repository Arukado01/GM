<?php

namespace App;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Report extends Model
{
    use SoftDeletes, FormatDates;

    protected $fillable = ['title', 'url', 'start', 'user_id'];
    protected $appends = ['hashid'];
    protected $hidden = ['id'];
    protected $dates = ['deleted_at'];


    //region Accessors && Mutator
    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
    public function getUrlAttribute($file)
    {
        return asset($file);
    }
    //endregion
    //region RelationShips
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //endregion
}
