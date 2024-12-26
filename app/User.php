<?php

namespace App;

use App\Enum\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shetabit\TokenBuilder\Traits\HasTemporaryTokens;
use Uuid;

class User extends Authenticatable
{
    use HasFactory;
    use HasTemporaryTokens;
    use Notifiable;
    use SoftDeletes;

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
        'remark',
    ];

    /**
     * Visible
     */
    protected $visible = [
        'uuid',
        'username',
        'installDir',
        'type',
        'playerID',
        'comment',
        'remark',
        'deleted_at',
        'last_login_time',
        'last_download_time',
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
        'type' => UserRole::class,
    ];

    protected $attributes = [
        'type' => UserRole::APPLICANT,
    ];

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNote::class)->orderByDesc('created_at');
    }

    /**
     * Get the route key for the model.
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
            //            UserRole::SPECIAL,
            //            UserRole::VETERAN
        ])->contains($this->type);
    }
}
