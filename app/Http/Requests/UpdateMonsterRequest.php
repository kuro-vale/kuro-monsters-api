<?php

namespace App\Http\Requests;

use App\Models\Monster;
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
        $monster = Monster::find($this->route('monster'));

        return $this->user()->can('update', $monster);
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
