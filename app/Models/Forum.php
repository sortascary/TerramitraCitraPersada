<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'messageforum_id'
    ];

    public function forumaccess(): HasMany
    {
        return $this->HasMany(ForumAccess::class, 'forum_id', 'id');
    }

    public function messageforum(): HasMany
    {
        return $this->HasMany(MessageForum::class, 'forum_id', 'id')->latest();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'forum_accesses');
    }

}
