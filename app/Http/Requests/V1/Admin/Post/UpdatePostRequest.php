<?php

namespace App\Http\Requests\V1\Admin\Post;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','min:1','max:255','unique:posts,title,' . $this->post->id],
            'image' => ['nullable','image','mimes:png,jpej,jpg'],
            'body' => ['required','min:10'],
            'category_id' => ['required','integer','exists:categories,id'],
            'status' => ['required','in:1,2'],
            'published_at' => ['nullable','integer']
        ];
    }
}
