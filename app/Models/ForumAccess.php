<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    public function forum(): BelongsTo
    {
        return $this->BelongsTo(Forum::class, 'forum_id', 'id');
    }
}
