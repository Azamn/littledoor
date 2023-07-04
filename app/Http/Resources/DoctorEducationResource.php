<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorEducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $documents = [];

        if ($this->media->isNotEmpty()) {
            $docotrEducation = $this->media->where('collection_name', 'doctor-edu-certificate');
            if ($docotrEducation->isNotEmpty()) {
                foreach ($docotrEducation as $certificate) {
                    $doctorEducationDocumentUrl = $certificate->getFullUrl();

                    if ($doctorEducationDocumentUrl) {
                        array_push($documents, $doctorEducationDocumentUrl);
                    }
                }
            }
        }


        return [
            'id' => $this?->id,
            'doctor_id' => $this?->doctor_id,
            'name' => $this?->name,
            'institution_name' => $this?->institution_name,
            'field_of_study' => $this?->field_of_study,
            'start_date' => Carbon::parse($this?->start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($this?->end_date)->format('d-m-Y'),
            'documents' => $documents ?? NULL,
            'description' => $this?->description ?? NULL
        ];
    }
}
