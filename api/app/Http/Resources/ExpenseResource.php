<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $file_url = null;
        // $file_path = 'payments/' . $this->buyer_id . '/' . $this->mode_of_payment . '/' . $this->image;

        // if ($this->image) {
        //     $file_url = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(15));
        // }

        $amount = $this->agents_commission_san_vicente + $this->agents_commission_tiniwisan + $this->salary + 
            $this->office_rental_expense + $this->utility_expense + $this->fuel_gasoline + 
            $this->office_materials + $this->repair_maintenance + $this->representation_expense + $this->transportation +
            $this->retainers + $this->lot_cancellation + $this->web_system_development + $this->professional_fee + $this->processing_fee + $this->equipment + $this->others;

        $file_url = null;
        $file_path = 'expenses/' . $this->id . '/' . $this->image;

        if ($this->image) {
            $file_url = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(15));
        }

        return [
            'particular' => $this->particular,
            'file_name' => $this->image,
            'file_url' => $file_url,
            'date' => $this->date,
            'receipt_no' => $this->receipt_no,
            'amount' => $amount,
            'agents_commission_san_vicente' => $this->agents_commission_san_vicente,
            'agents_commission_tiniwisan' => $this->agents_commission_tiniwisan,
            'salary' => $this->salary,
            'office_rental_expense' => $this->office_rental_expense,
            'utility_expense' => $this->utility_expense,
            'fuel_gasoline' => $this->fuel_gasoline,
            'office_materials' => $this->office_materials,
            'repair_maintenance' => $this->repair_maintenance,
            'representation_expense' => $this->representation_expense,
            'transportation' => $this->transportation,
            'retainers' => $this->retainers,
            'lot_cancellation' => $this->lot_cancellation,
            'web_system_development' => $this->web_system_development,
            'professional_fee' => $this->professional_fee,
            'processing_fee' => $this->processing_fee,
            'equipment' => $this->equipment,
            'others' => $this->others,
            

        ];
    }
}
