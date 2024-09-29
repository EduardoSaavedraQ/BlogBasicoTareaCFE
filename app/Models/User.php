<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'rpe',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function setRpeAttribute($value)
    {
        $this->attributes['rpe'] = strtoupper($value);
    }
    public function datos()
    {
        return $this->hasOne(Datosuser::class, 'rpe', 'rpe');
    }

    public function salud()
    {
        return $this->hasMany(MiSalud::class, 'rpe', 'rpe');
    }

    public function enfermedadesCronicas()
    {
        return $this->hasMany(usuario_enfermedad::class, 'rpe', 'rpe');
    }

    public function post(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function scopeSearchByName(Builder $query, $searchTerm)
    {
        return $query->whereHas('datosuser', function (Builder $q) use ($searchTerm) {
            $q->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$searchTerm}%"]);
        });
    }
}
