<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VideoWithAttributesValidationRule;

class PostRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'video' => ['nullable', 'file', new VideoWithAttributesValidationRule],
        ];
    }
}
