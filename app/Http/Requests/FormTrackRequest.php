<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FormTrackRequest extends FormRequest
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
       //dd($this->file('music')->getErrorMessage());
        return [
            'title' => ['required', 'min:8'],
            'image'=>['nullable', 'image','max:4000'],
            'music' => ['required', File::types(['mp3', 'wav'])->min(1024)->max(12 * 1024)],
            'description' => ['nullable'],
            'genres' => ['array', 'exists:genres,id'],
        ];
    }
}
