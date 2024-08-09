<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasTeams;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Spatie\Permission\Traits\HasRoles;
use App\Models\RolesHistoria;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use AuthenticatesWithLdap;
    use HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'cedula',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function persona(): HasOne
    {
        return $this->hasOne(Persona::class, 'per_cedula', 'cedula');
    }
    public function rolesHistory(): HasMany
    {
        return $this->hasMany(RolesHistoria::class, 'user_id');
    }

    public function hasRoleByName(string $roleName): bool
    {
        return $this->rolesHistory()
                    ->whereHas('role', function($query) use ($roleName) {
                        $query->where('name', $roleName);
                    })
                    ->exists();
    }
}
