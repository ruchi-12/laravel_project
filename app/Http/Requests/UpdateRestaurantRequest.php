<?php

namespace App\Http\Requests;

use App\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('restaurant_create');
    }

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            'code' => [
                'required',
            ],
            'description'   => [
                'required',
            ],
            'phone'   => [
                'required',
                'integer',
            ],
            'email'   => [
                'required',
                'email',
            ],
        ];
    }
}
