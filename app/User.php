<?php

namespace App;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property integer role_id
 * @property string  first_name
 * @property string  last_name
 * @property boolean first_session
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'avatar'];
    protected $appends = ['full_name', 'hashid'];
    protected $hidden = ['password', 'remember_token', 'id', 'role_id', 'pivot'];


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }

    //region RelationShips

    /**
     * Relación con los Proyectos.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Relación con los reportes que el usuario a subido o actualizado.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    //endregion

    //region Scopes
    /**
     * Función para validar si el usuario es Administrador
     * @return bool
     */
    public function isAdmin()
    {
        $value = $this->role_id == 1;
        return $value;
    }

    /**
     * Función para validar si el usuario es supervisor
     * @return bool
     */
    public function isSupervisor()
    {
        if ($this->role_id == 2)
            return true;

        return false;
    }

    public function isClient()
    {
        if ($this->role_id == 3)
            return true;

        return false;
    }

    /**
     * Función que valida si el usuario es Administrador o Supervisor
     * @return bool
     */
    public function isAdminOrSupervisor()
    {
        if ($this->role_id == 1 || $this->role_id == 2)
            return true;

        return false;
    }

    public function deleteCurrentAvatar()
    {
        if ($this->avatar != '') {
            $url = $this->avatar;
            $fileName = explode('/', $url);
            $fileName = $fileName[count($fileName) - 1];

            $pPath = public_path('accounts/profile_images/') . $fileName;
            if (file_exists($pPath))
                unlink($pPath);
        }
    }

    public function isFirstSession()
    {
        return $this->first_session;
    }
    //endregion

    //region Subscribe Methods

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    //endregion
}
