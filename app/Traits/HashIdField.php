<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait HashIdField
{
    //region Accessors && Mutator
    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
    //endregion
}