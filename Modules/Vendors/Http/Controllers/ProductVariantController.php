<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\ProductVariant;

class ProductVariantController extends Controller
{

    protected $DB, $productVariantModal;

    public function __construct(Request $request)
    {

        if(!$request->header('X-DB-Connection')){
            die('Required header files missing!');
        }
        
        $this->DB = $request->header('X-DB-Connection');
        $this->productVariantModal = new ProductVariant;
        $this->productVariantModal->setConnection($this->DB);

    }

    public function getProductVariants(){
 
        $variants = $this->productVariantModal->get();
        $variantsArray = $this->productVariantModal->get(['title'])->map(function($item){
            return $item->title;
        })->toArray();
 
        return response()->json(['status' => true , 'dataArray' => array_values($variantsArray),'data' => $variants] , 200);
 
    }

}
