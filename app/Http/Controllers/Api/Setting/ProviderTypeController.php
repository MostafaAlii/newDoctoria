<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProviderTypeResource;
use App\Http\Resources\ProviderResource;
use App\Http\Traits\Api_Trait;
use App\Models\ProviderType;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderTypeController extends Controller
{
    //
    use Api_Trait;

    public function provider_type() {
        $providerTypes=ProviderType::get();
        return $this->returnData(ProviderTypeResource::collection($providerTypes),[helperTrans('api.Provider Types Data')]);
    }

    public function providers(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'slug' => 'required|exists:provider_types,slug',
        ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1), 403);
        }

        $providers = Provider::whereHas('provider_types', function ($query) use ($request) {
            $query->where('provider_types.slug', $request->slug);
        })->get();

        return $this->returnData(ProviderResource::collection($providers), [helperTrans('api.Providers Data')], 200);

    }
}