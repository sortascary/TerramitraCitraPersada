<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();
        
        $unreadCount = $user ? $user->unreadNotifications()
            ->where('data->forum_id', $this->id)
            ->count() : 0;
            
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'message' => $this->messageforum->first() ? new MessageResource($this->messageforum->first()) : null,
            'unread' => $unreadCount,
            'created_at' => $this ->created_at,
        ];
    }
}
