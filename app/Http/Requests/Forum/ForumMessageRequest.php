<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class ForumMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => 'required|string',
            'forum_id' => 'required|string',
            'message_type' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*.file' => 'nullable|image|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120'
        ];
    }
}
