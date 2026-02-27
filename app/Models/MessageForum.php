<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageForum extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'message',
        'message_id',
        'forum_id',
        'user_id',
        'message_type'
    ];
    
    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function message()
    {
        return $this->belongsToMany(MessageForum::class, 'message_id', 'id');
    }
    
    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class, 'message_id', 'id');
    }
}
