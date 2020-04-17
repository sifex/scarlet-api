<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'installDir',
        'clanID',
        'type'
    ];

    /**
     * Visible
     */
    protected $visible = [
        'username',
        'installDir',
        'key',
        'clanID',
        'type'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(static function (User $user) {
            $user->key = $user->generateKey();
        });

        static::updating(static function (User $user) {
            $user->key = $user->generateKey();
        });
    }

    /**
     * Generate User Key
     * @return string
     */
    private function generateKey(): string
    {
        return md5(strtolower($this->username) . 'E6hJ9X2AptWH6bqU32');
    }
}
