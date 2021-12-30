<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\ProductCategory;
use Modules\Vendors\Entities\ProductVariant;
use Modules\Vendors\Entities\ProductCategoryVariant;

class ProductCategoryController extends Controller
{

    protected $DB, $productCategoryModal, $productVariantModal, $productCategoryVariantModal;
    
    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {

        if (!$request->header('X-DB-Connection')) {
            die('Required header missing!');
        }

        try {
            $this->DB = $request->header('X-DB-Connection');

            $this->productCategoryModal = new ProductCategory;
            $this->productCategoryModal->setConnection($this->DB);

            $this->productVariantModal = new ProductVariant;
            $this->productVariantModal->setConnection($this->DB);

            $this->productCategoryVariantModal = new ProductCategoryVariant;
            $this->productCategoryVariantModal->setConnection($this->DB);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * SaveCategory
     *
     * @param  mixed $request
     * @return void
     */
    public function SaveCategory(Request $request)
    {

        try {
            $insertArray = [
                'title'         => $request->title,
                'description'   => $request->description,
                'units'         => $request->units,
                'status'        => 1
            ];

            $isCategorySaved = $this->productCategoryModal->create($insertArray);

            $receivedUnitsArray = json_decode($request->units, true);
            $unitsArray = $this->productVariantModal->get()->map(function ($item) {
                return $item->title;
            })->toArray();


            collect($receivedUnitsArray)->map(function ($item, $index) use ($unitsArray) {
                if (!in_array($item, $unitsArray)) {
                    $this->productVariantModal->create([
                        'title' => $item
                    ]);
                }
            });


            collect($receivedUnitsArray)->map(function ($item) use ($isCategorySaved) {
                $variant = $this->productVariantModal->where('title', $item)->first();
                $this->productCategoryVariantModal->create([
                    'variant_id' => $variant->id,
                    'category_id' => $isCategorySaved->id
                ]);
            });

            if ($isCategorySaved) {
                return response()->json(['status' => true, 'message' => 'Data saved successfully.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Something Went Wrong.'], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * getCategoryList
     *
     * @return void
     */
    public function getCategoryList()
    {
        try {
            $categoryList = $this->productCategoryModal->select(['id', 'title', 'units'])->get()->toArray();
            return response()->json(['status' => true, 'data' => $categoryList], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * getCategoryById
     *
     * @param  mixed $categoryId
     * @return void
     */
    public function getCategoryById($categoryId)
    {
        try {
            $categoryModel = $this->productCategoryModal->where('id', $categoryId);
            if (!$categoryModel->first()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found!'
                ], 200);
            }
            return response()->json([
                'status' => true,
                'data' => $categoryModel->with('variants')->get()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getCategoryProducts($categoryId){
        try {
            $categoryModel = $this->productCategoryModal->where('id',$categoryId);
            if (!$categoryModel->first()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found!'
                ], 200);
            }
            $categoryData = $categoryModel->first();
            $categoriesData = $categoryData->load('children.products')->children;
            $categoriesData = $categoriesData->map(function($item){
                return [
                    'title' => $item->title,
                    'data' => [['list' => $item->products]]                    
                ];
            });
            
            return response()->json([
                'status' => true,
                'selectedCategory' => $categoryData,
                'data' => $categoriesData
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function getOnlyCategoryProducts($categoryId)
    {
        try {
            $categoryModel = $this->productCategoryModal->where('id', $categoryId);
            if (!$categoryModel->first()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found!'
                ], 200);
            }
            $categoryData = $categoryModel->first()
            ->load('products', 'products.variant:id,title');
            
            return response()->json([
                'status' => true,
                'data' => $categoryData
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }   
    }
}
