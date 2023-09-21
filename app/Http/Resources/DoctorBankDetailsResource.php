<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorBankDetailsResource extends JsonResource
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
            'id' => $this->id,
            'account_type' => $this->account_type,
            'account_number' => $this->account_number,
            'account_holder_name' => $this->account_holder_name,
            'ifsc_code' => $this->ifsc_code,
            'branch_name' => $this->branch_name,
            'documents' => $this->media->isNotEmpty() ?  $this->media->where('collection_name', 'bank-passbook')->last()->getFullUrl() : NULL,
        ];
    }
}
