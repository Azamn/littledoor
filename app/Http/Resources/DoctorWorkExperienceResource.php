<?php

namespace App\Http\Resources;

use App\Models\MasterSubCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorWorkExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subCategoriesData = [];
        $certificates = [];

        if ($this->sub_category_id) {
            $subCategoryIds = explode(',', $this->sub_category_id);

            foreach ($subCategoryIds as $subCategoryId) {

                $subCategory = MasterSubCategory::where('id', $subCategoryId)->first();
                if ($subCategory) {
                    $data = [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                    ];

                    array_push($subCategoriesData, $data);
                }
            }
        }

        if ($this->media->isNotEmpty()) {
            $docotrCertificate = $this->media->where('collection_name', 'doctor-work-certificate');
            if ($docotrCertificate->isNotEmpty()) {
                foreach ($docotrCertificate as $certificate) {
                    $doctorPrescriptionUrl = $certificate->getFullUrl();

                    if ($doctorPrescriptionUrl) {
                        array_push($certificates, $doctorPrescriptionUrl);
                    }
                }
            }
        }

        return [
            'id' => $this?->id,
            'doctor_id' => $this?->doctor_id,
            'category_id' => $this?->category_id,
            'category_name' => $this->category?->name,
            'sub_category' => $subCategoriesData ?? NULL,
            'certificate' => $certificates ?? NULL
        ];
    }
}
