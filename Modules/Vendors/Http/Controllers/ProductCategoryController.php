<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\ProductCategory;
use Modules\Vendors\Entities\ProductVariant;
use Modules\Vendors\Entities\ProductCategoryVariant;

class ProductCategoryController extends Controller
{

    protected $DB, $productCategoryModal,$productVariantModal,$productCategoryVariantModal;

    public function __construct(Request $request)
    {

        if(!$request->header('X-DB-Connection')){
            die('Required header files missing!');
        }
        
        $this->DB = $request->header('X-DB-Connection');
        
        $this->productCategoryModal = new ProductCategory;
        $this->productCategoryModal->setConnection($this->DB);

        $this->productVariantModal = new ProductVariant;
        $this->productVariantModal->setConnection($this->DB);
        
        $this->productCategoryVariantModal = new ProductCategoryVariant;
        $this->productCategoryVariantModal->setConnection($this->DB);
    }

    public function SaveCategory(Request $request){

        $insertArray = [
            'title'         => $request->title,
            'description'   => $request->description,
            'units'         => $request->units,
            'status'        => 1
        ];

        $isCategorySaved = $this->productCategoryModal->create($insertArray);

        $receivedUnitsArray = json_decode($request->units, true);
        $unitsArray= $this->productVariantModal->get()->map(function($item){
            return $item->title;
        })->toArray();


        collect($receivedUnitsArray)->map(function($item,$index) use($unitsArray){
            if(!in_array($item,$unitsArray)){
                $this->productVariantModal->create([
                    'title' => $item
                ]);
            }
        });


        collect($receivedUnitsArray)->map(function($item) use ($isCategorySaved){
            $variant = $this->productVariantModal->where('title', $item)->first();
            $this->productCategoryVariantModal->create([
                'variant_id' => $variant->id,
                'category_id' => $isCategorySaved->id
            ]);
        });

        if($isCategorySaved){
            return response()->json(['status' => true , 'message' => 'Data saved successfully.'] , 200);
        }else{
            return response()->json(['status' => false , 'message' => 'Something Went Wrong.'] , 500);
        }
    }
    
    public function getCategoryList(){
        $categoryList = $this->productCategoryModal->select(['id', 'title', 'units'])->get()->toArray();
        return response()->json(['status' => true , 'data' => $categoryList] , 200);
    }

    public function getCategoryById($category_id){

        // $categoryData = $this->productCategoryModal->where('id',$category_id)->with('variants.variant_rel')
        // ->get()->map(function($item){
        //     $item->categoryVariants = $item->variants->map(function($dd){
        //         return $dd->variant_rel;
        //     });
        //     unset($item->variants);
        //     return $item;   
        // });


        $categoryData = $this->productCategoryModal->where('id',$category_id)->with('variants')
        ->get();
        return response()->json(['status' => true , 'data' => $categoryData] , 200);    
    }
}
