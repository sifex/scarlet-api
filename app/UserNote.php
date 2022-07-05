<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'contents',
        'author_id',
    ];

    protected $with = [
        'author:username,id,uuid'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->without('notes');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class)->without('notes');
    }
}
