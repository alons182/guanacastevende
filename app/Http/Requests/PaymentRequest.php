<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PaymentRequest extends Request
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
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'telephone' => 'required|max:15',
            'address' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:15',
            'country' => 'required',
            'zipcode' => 'required|max:10'

        ];
    }
}
