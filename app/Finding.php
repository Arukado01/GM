<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Finding
 * @property mixed  date    Fecha del hallazgo
 * @property string affair  Asunto del hallazgo
 * @property string finding descripción extensa del hallazgo
 * @package App
 */
class Finding extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'date',
        'affair',
        'finding'
    ];
    protected $appends = ['hashid'];
    protected $hidden = ['id', 'project_id'];
    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
