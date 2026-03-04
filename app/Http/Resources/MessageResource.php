<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {       
        return [
            'id' => $this->id,
            'message' => $this->message,
            'message_type' => $this ->message_type,
            'message_reply' => $this->message_reply ? [
                'id' => $this->message_reply->id,
                'message' => $this->message_reply->message,
                'user' => new UserResource($this->message_reply->user),
            ] : null,
            'poll' => $this->message_type == 'poll'? $this->polloptions->map(fn($o) => [
                'id' => $o->id,
                'option' => $o->option,
                'votes_count' => $o->pollvotes->count(),
                'user_voted' => $o->pollvotes->where('user_id', auth()->id())->isNotEmpty(),
            ]) : null,
            'user' => $this->user? new UserResource($this->user) : null,
            'files' => MessageAttachmentResource::collection( $this->attachments),
            'created_at' => $this ->created_at,
        ];
    }
}
