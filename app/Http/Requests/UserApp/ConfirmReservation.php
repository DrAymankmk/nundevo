<?php

namespace App\Http\Requests\UserApp;

use App\Http\Requests\Request;

class ConfirmReservation extends Request
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
            'id' => 'required|exists:clinics,id',
            'appointment_time'=>'required|string',
            'date'  => ['required', 'date_format:Y-m-d'],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => trans('user.doctors.id'),
            'appointment_time.required' => trans('user.doctors.appointment_time'),
            'date.required' => trans('messages.auth.date_created'),
        ];
    }


}
