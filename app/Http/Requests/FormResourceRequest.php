<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormResourceRequest extends FormRequest
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
            'title' => ['required', 'min:8'],
            'resource_author' => ['nullable'],
            'image'=>['image','max:4000'],
            'slug' => ['required', 'min:8', 'regex:/^[a-z0-9\-]+$/', Rule::unique('resources')/* -> like table in DB */->ignore($this->route()->parameter('resource')) ],
            'description' => ['required'],
            'price' => ['numeric', 'nullable'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['array', 'exists:tags,id'],
            'comments' => ['array', 'exists:users,id'],
            'user_like_resource' => ['nullable'],
            'link' => ['nullable','url']
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'slug' => $this->input('slug') ?: \Str::slug($this->input('title'))
        ]);
    }
}
