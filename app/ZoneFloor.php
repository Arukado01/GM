<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property boolean checked
 */
class ZoneFloor extends Model
{
    use SoftDeletes, HashIdField;
    protected $fillable = [
        'number',
        'checked'
    ];

    protected $appends = ['hashid'];
    protected $hidden = ['id', 'zone_id'];
    protected $dates = ['deleted_a t'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function changeStatus()
    {
        $state = !$this->checked;
        $this->attributes['checked'] = $state;

        $this->save();

        return $state;
    }
}
