<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Models\MainOtpProvider;
class MainOtpProviderTransformer extends TransformerAbstract {
    public function transform(MainOtpProvider $mainOtpProvider): array {
        return [
            'id' => (int) $mainOtpProvider->id,
            'name' => $mainOtpProvider->name,
            'status' => $mainOtpProvider->status,
        ];
    }
}
