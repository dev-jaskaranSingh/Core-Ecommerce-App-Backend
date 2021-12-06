<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\ProductVariant;

class ProductVariantController extends Controller
{

    protected $DB, $productVariantModal;
    
    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    
    public function __construct(Request $request)
    {

        if (!$request->header('X-DB-Connection')) {
            die('Required header files missing!');
        }
        try {
            $this->DB = $request->header('X-DB-Connection');
            $this->productVariantModal = new ProductVariant;
            $this->productVariantModal->setConnection($this->DB);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * getProductVariants
     *
     * @return void
     */
    
    public function getProductVariants()
    {
        try {
            $variants = $this->productVariantModal->get();
            $variantsArray = $this->productVariantModal->get(['title'])->map(function ($item) {
                return $item->title;
            })->toArray();
            return response()->json(['status' => true, 'dataArray' => array_values($variantsArray), 'data' => $variants], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
