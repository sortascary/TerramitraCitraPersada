<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'views',
        'user_id'
    ];

    public function contentattachments(): HasMany
    {
        return $this->HasMany(ContentAttachment::class, 'content_id', 'id');
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class, 'content_id', 'id');
    }

    public function contentviews() 
    {
        return $this->hasMany(ContentView::class, 'content_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
