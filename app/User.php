<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can have many articles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ads() {
        return $this->hasMany('App\Ads');
    }

    public function articles() {
        return $this->hasMany('App\Articles');
    }
    
    public function isAModerator() {
        return true;
    }

    public function isAAdministrator() {
        return false;
    }
}
