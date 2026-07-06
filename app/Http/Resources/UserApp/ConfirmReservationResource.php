<?php

namespace App\Http\Resources\UserApp;

use App\Models\PatientService;
use App\Models\ReservationRate;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'clinic_id'          => $this->clinic_id,
            'is_rated'          => ReservationRate::where('reservation_id',$this->id)->exists(),
            'clinic_name'          => $this->clinic->name,
            'clinic_image'          => $this->clinic->image,
            'reception_id'          => $this->reception_id,
            'reception_name'          => $this->reception->name,
            'reception_image'          => $this->reception->image,
            'doctor_id'          => $this->doctor_id,
            'doctor_name'          => $this->doctor->name,
            'doctor_image'          => $this->doctor->image,
            'specialties' => !empty($this->doctor->specialties) ? "Obstetrics and Gynecology": "",
            'status_id'          => $this->status_id,
            'date'          => $this->date,
            'appointment'          => $this->appointment,
            'user_name'          => $this->user->name,
            'user_image'          => $this->user->image,
            'booking_number'      =>  asset('media/reservations/' . $this->booking_number. '.' . 'png')
        ];
    }
}
