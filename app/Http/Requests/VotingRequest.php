<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VotingRequest extends FormRequest
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
        return [
           
            'time_phase_1' => 'required|numeric|min:1|max:99',
            'time_phase_2' => 'required|numeric|min:1|max:99',
        ];
    }

    public function messages()
    {
        return [

            'required' => 'Поле :attribute обязательно к заполнению.',
            'min' => 'Значение поле :attribute не должно быть менее :min.',
            'max' => 'Значение поле :attribute не должно быть более :max.',
        ];
    }
}
