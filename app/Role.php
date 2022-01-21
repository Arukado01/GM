<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Role extends Model
{
    protected $fillable = ['name'];
    protected $appends = ['hashid'];
    protected $hidden = ['id'];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }

    //region RelationShips
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //endregion
}
