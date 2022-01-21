<?php

namespace App;

use App\Traits\HashIdField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Project extends Model
{
    use SoftDeletes, HashIdField;

    protected $fillable = ['name', 'location'];
    protected $appends = ['hashid'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['id', 'pivot'];

    //region RelationShips

    /**
     * Relación de los proyectos con los usuarios correspondientes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relación de los proyectos con los reportes asociados.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Relación de los proyectos con la tabla de ensayos de Concreto
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function concreteSamples()
    {
        return $this->hasMany(ConcreteSample::class);
    }

    public function concreteSamplesObservations()
    {
        return $this->hasMany(ConcreteSampleObservation::class);
    }

    public function quantityCheckConcreteSamples()
    {
        return $this->hasMany(QuantityCheckConcreteTest::class);
    }

    public function quantityCheckConcreteSamplesObservations()
    {
        return $this->hasMany(QuantityCheckConcreteTestObservation::class);
    }

    public function steelSamples()
    {
        return $this->hasMany(SteelSample::class);
    }

    public function steelSampleObservations()
    {
        return $this->hasMany(SteelSampleObservation::class);
    }

    public function quantityCheckSamples()
    {
        return $this->hasMany(QuantityCheckSample::class);
    }

    public function quantityCheckSampleObservations()
    {
        return $this->hasMany(QuantityCheckSampleObservation::class);
    }

    public function meshSamples()
    {
        return $this->hasMany(MeshSample::class);
    }

    public function meshSampleObservations()
    {
        return $this->hasMany(MeshSampleObservation::class);
    }

    public function settlementControls()
    {
        return $this->hasMany(SettlementControl::class);
    }

    public function stateObservations()
    {
        return $this->hasMany(StateObservation::class);
    }

    public function projectImages()
    {
        return $this->hasMany(ProjectImages::class);
    }

    public function findings()
    {
        return $this->hasMany(Finding::class);
    }

    public function licenses()
    {
        return $this->hasMany(ConstructionLicense::class);
    }

    public function calibrationCertificates()
    {
        return $this->hasMany(CalibrationCertificate::class);
    }

    public function lastUpdates()
    {
        return $this->hasMany(LastDateUpdate::class);
    }

    public function progressWorks()
    {
        return $this->hasMany(ProgressWork::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function qualityPlan()
    {
        return $this->hasMany(QualityPlan::class);
    }
    //endregion

    //region Scopes
    public function ingSupervisorName()
    {
        return $this->users()->where('role_id', '!=', 3)->first()->full_name;
    }

    public function getLastUpdate($type)
    {
        if ($this->lastUpdates()) {
            $lastUpdate = $this->lastUpdates()->where('type', $type)->first();
            return $lastUpdate ? $lastUpdate->last_update : null;
        } else {
            return null;
        }
    }


    public function saveOrEditLastUpdate($type)
    {
        $lastUpdate = $this->lastUpdates()
            ->where('type', $type)
            ->first();

        $date = date('Y-m-d H:i:s');
        if (empty($lastUpdate)) {
            $lastUpdate = $this->lastUpdates()->create([
                'last_update' => $date,
                'type'        => $type
            ]);
        } else {
            $lastUpdate->update(['last_update' => $date]);
        }

        return $lastUpdate->last_update;
    }

    public function verifyConcreteUpdate()
    {
        if ($this->lastUpdates()) {
            return $this->lastUpdates()->where('type', 'verify_concrete')->first();
        } else {
            return null;
        }
    }

    public function progressWorkLastUpdate()
    {
        if ($this->has('progressWorks')->count() > 0) {
            $progressWork = $this->progressWorks()->orderBy('updated_at', 'desc')->first();

            if($progressWork)
                return $this->progressWorks()->orderBy('updated_at', 'desc')->first()->updated_at->format('Y-m-d H:i:s');

            return null;
        } else {
            return null;
        }
    }
    //endregion
}
