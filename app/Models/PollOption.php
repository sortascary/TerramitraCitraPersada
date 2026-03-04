<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option',
        'message_id',
    ];

    public function pollvotes() {
        return $this->hasMany(PollVote::class, 'option_id', 'id');
    }
}
