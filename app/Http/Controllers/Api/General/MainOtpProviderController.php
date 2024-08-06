<?php
namespace App\Http\Controllers\Api\General;
use App\Http\Controllers\Controller;
use App\Models\MainOtpProvider;
use App\Transformers\MainOtpProviderTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\{Collection};
use League\Fractal\Manager;
class MainOtpProviderController extends Controller {
    public function __construct(protected Manager $fractal) {
        $this->fractal = $fractal;
    }

    /*public function index() {
        $providers = MainOtpProvider::paginate(10);
        $collection = new Collection($providers, new MainOtpProviderTransformer);
        $collection->setPaginator(new IlluminatePaginatorAdapter($providers));
        return response()->json($this->fractal->createData($collection)->toArray());
    }*/
    public function index() {
        $providers = MainOtpProvider::paginate(10);
        $collection = new Collection($providers, new MainOtpProviderTransformer);
        $collection->setPaginator(new IlluminatePaginatorAdapter($providers));
        $data = $this->fractal->createData($collection)->toArray();
        return response()->json([
            'data' => $data['data'],
            'message' => ['return Otp Provider Successfully.'],
            'status' => '200',
            'meta' => [
                'pagination' => $data['meta']['pagination']
            ]
        ]);
    }
}