<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use DB;
use Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $withoutAppends = false;

    public function scopeWithoutAppends($query)
    {
        self::$withoutAppends = true;

        return $query;
    } 
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    } 

    public function devices() {
        return $this->hasMany(UserDevice::class, 'user_id', 'id'); 
    }

    public function getNameAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }
    public function getPhoneCodeAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }
    public function getMobileAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }
   
    public function getEmailAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    } 
    public function getPasswordAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }
    public function getDescriptionAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }
    
    public function getAvatarAttribute($details)
    {
        if ($details != '') {
            return asset('img/avatars').'/'.$details;
        }
        return asset('images/no_avatar.jpg');
    }  
    public function getImageAttribute($details)
    {
        if ($details != '') {
            return asset('img/avatars').'/'.$details;
        }
        return asset('images/no_avatar.jpg');
    } 
}

