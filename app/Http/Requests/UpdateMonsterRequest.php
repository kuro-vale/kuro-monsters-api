<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMonsterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $favorite_color = ['black', 'white', 'red', 'yellow', 'blue', 'orange', 'green', 'purple'];

        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s-]*$/', 'max:25'],
            'favorite_color' => ['nullable', Rule::in($favorite_color)]
        ];
    }
}
