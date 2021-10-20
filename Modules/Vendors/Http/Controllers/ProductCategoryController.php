<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\ProductCategory;

class ProductCategoryController extends Controller
{

    protected $DB, $productCategoryModal;

    public function __construct(Request $request)
    {

        if(!$request->header('X-DB-Connection')){
            die('Required header files missing!');
        }
        
        $this->DB = $request->header('X-DB-Connection');
        $this->productCategoryModal = new ProductCategory;
        $this->productCategoryModal->setConnection($this->DB);

    }

    public function SaveCategory(Request $request){

        $insertArray = [
            'title'         => $request->title,
            'description'   => $request->description,
            'units'         => $request->units,
            'status'        => 1
        ];
        
        $isCategorySaved = $this->productCategoryModal->create($insertArray);

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
        $units = json_decode($this->productCategoryModal->find($category_id)->units, true);
        return response()->json(['status' => true , 'data' => $units] , 200);    
    }
}
