<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateObservation extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = [
        'date',
        'total_pending',
        'previous_open',
        'total_in_period',
        'closed_in_period',
        'planning',
        'plans',
        'specifications',
        'materials',
        'foundation',
        'vertical_elem',
        'mezzanines',
        'tank_pool',
        'metallic',
        'non_structural',
        'catered',
        'unattended',
        'total_attended'
    ];

    protected $appends = ['hashid'];
    protected $dates = ['deleted_at'];

    protected $hidden = ['id', 'project_id'];

    //region Mutator & Accessors
    public function setTotalPendingAttribute($value)
    {
        return $this->attributes['total_pending'] = !empty($value) ? $value : 0;
    }

    public function setPreviousOpenAttribute($value)
    {
        return $this->attributes['previous_open'] = !empty($value) ? $value : 0;
    }

    public function setTotalInPeriodAttribute($value)
    {
        return $this->attributes['total_in_period'] = !empty($value) ? $value : 0;
    }

    public function setClosedInPeriodAttribute($value)
    {
        return $this->attributes['closed_in_period'] = !empty($value) ? $value : 0;
    }

    public function setPlanningAttribute($value)
    {
        return $this->attributes['planning'] = !empty($value) ? $value : 0;
    }

    public function setPlansAttribute($value)
    {
        return $this->attributes['plans'] = !empty($value) ? $value : 0;
    }

    public function setSpecificationsAttribute($value)
    {
        return $this->attributes['specifications'] = !empty($value) ? $value : 0;
    }

    public function setMaterialsAttribute($value)
    {
        return $this->attributes['materials'] = !empty($value) ? $value : 0;
    }

    public function setFoundationAttribute($value)
    {
        return $this->attributes['foundation'] = !empty($value) ? $value : 0;
    }

    public function setVerticalElemAttribute($value)
    {
        return $this->attributes['vertical_elem'] = !empty($value) ? $value : 0;
    }

    public function setMezzaninesAttribute($value)
    {
        return $this->attributes['mezzanines'] = !empty($value) ? $value : 0;
    }

    public function setTankPoolAttribute($value)
    {
        return $this->attributes['tank_pool'] = !empty($value) ? $value : 0;
    }

    public function setMetallicAttribute($value)
    {
        return $this->attributes['metallic'] = !empty($value) ? $value : 0;
    }

    public function setNonStructuralAttribute($value)
    {
        return $this->attributes['non_structural'] = !empty($value) ? $value : 0;
    }

    public function setCateredAttribute($value) 
    {
        return $this->attributes['catered'] = !empty($value) ? $value : 0;
    }

    public function setUnattendedAttribute($value)
    {
        return $this->attributes['unattended'] = !empty($value) ? $value : 0;
    }

    public function setTotalAttendedAttribute($value)
    {
        return $this->attributes['total_attended'] = !empty($value) ? $value : 0;
    }

    //endregion

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
