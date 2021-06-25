<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    use HasRoles;
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function createUser($data)
    {
        $user = User::create([
            'first_name' => $data['owner_first_name'],
            'last_name' => $data['owner_last_name'],
            'username' => $data['owner_username'],
            'email' => $data['owner_email'],
            'password' => bcrypt($data['password']),
            'language' => 'en'
        ]);

        return $user;
    }

    public function Business()
    {
        return $this->hasOne(Business::class, 'owner_id');
    }

    public function locations()
    {
        return $this->belongsToMany(BusinessLocation::class)->select(array('business_locations.id','business_id','name','city','country','state','zip_code'));
    }
}
