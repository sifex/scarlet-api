<?php

namespace App;

use App\Enum\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shetabit\TokenBuilder\Traits\HasTemporaryTokens;
use Uuid;


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
//    protected $visible = [
//        'uuid',
//        'username',
//        'installDir',
//        'type',
//        'playerID',
//        'comment',
//        'remark'
//    ];

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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function isAdministrator(): bool
    {
        return collect([
            UserRole::STAFF,
            UserRole::LEADER,
            UserRole::SPECIAL,
            UserRole::VETERAN
        ])->contains($this->type);
    }
}
