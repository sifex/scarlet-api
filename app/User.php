<?php

namespace App;

use App\Enum\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shetabit\TokenBuilder\Traits\HasTemporaryTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasTemporaryTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'installDir',
        'type',
        'playerID',
        'comment',
        'remark'
    ];

    /**
     * Visible
     */
    protected $visible = [
        'username',
        'installDir',
        'type',
        'playerID',
        'comment',
        'remark'
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
        'type' => UserRole::class
    ];
}
