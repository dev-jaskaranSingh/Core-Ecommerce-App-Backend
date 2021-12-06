<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Product;
use File;

class ProductController extends Controller
{

    protected $DB, $productModal;

    public function __construct(Request $request)
    {

        if (!$request->header('X-DB-Connection')) {
            die('Required header files missing!');
        }

        $this->DB = $request->header('X-DB-Connection');

        $this->productModal = new Product;
        $this->productModal->setConnection($this->DB);
    }

    /**
     * saveProduct
     *
     * @param  mixed $request
     * @return void
     */
    public function saveProduct(Request $request)
    {
        $modifiedArray = [];
        $images = [];
        if (!is_null($request->images)) {
            foreach ($request->images as $key => $image) {
                $folderPath = "uploads/images/products/";
                $image_parts = explode(";base64,", $image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.' . $image_type;
                $file = $folderPath . $fileName;
                file_put_contents($file, $image_base64);
                $images[++$key] = $fileName;
            }
        }
        $insertArray = [
            'images' => json_encode($images, true),
            'title' => $request->title,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'description'   => $request->description,
            'unit'         => $request->unit,
            'variant_id' => $request->variant_id,
            'category_id' => $request->category_id,
            'status'        => 1
        ];

        $isProductSaved = $this->productModal->create($insertArray);

        if ($isProductSaved) {
            return response()->json(['status' => true, 'message' => 'Product saved successfully.', 'last_saved_id' => $isProductSaved->id], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong.'], 500);
        }
    }

    /**
     * updateProduct
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateProduct(Request $request, $id)
    {

        if (is_null($this->productModal->where('id', $id)->first())) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
        }

        $images = $this->productModal->where('id', $id)->value('images');

        if (!is_null($request->images)) {
            foreach ($request->images as $image) {
                $folderPath = "uploads/images/products/";
                $image_parts = explode(";base64,", $image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.' . $image_type;
                $file = $folderPath . $fileName;
                file_put_contents($file, $image_base64);
                $images[] = $fileName;
            }
        }
        $insertArray = [
            'images' => json_encode($images, true),
            'title' => $request->title,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'description'   => $request->description,
            'unit' => $request->unit,
            'variant_id' => $request->variant_id,
            'category_id' => $request->category_id,
            'status' => 1
        ];

        $isProductSaved = $this->productModal->where('id', $id)->update($insertArray);

        if ($isProductSaved) {
            return response()->json(['status' => true, 'message' => 'Product updated successfully.', 'last_updated_id' => $request->id], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong.'], 500);
        }
    }

    /**
     * getProductsList
     *
     * @return void
     */
    public function getProductsList()
    {
        $products = $this->productModal->get();
        $data = $products->load('category:id,title', 'variant:id,title')
            ->groupBy('category.title')->map(function ($item, $title) {
                return [
                    'title' => $title,
                    'data' => $item
                ];
            });
        return response()->json([
            'status' => true,
            'message' => 'Products fetched successfully.',
            'images_url' => "https://core-ecommerce-app.ripungupta.com/public/uploads/images/products/",
            'data' => $data->values()
        ], 200);
    }

    /**
     * getProductById
     *
     * @param  mixed $id
     * @return void
     */
    public function getProductById($id)
    {
        $product = $this->productModal->find($id);
        if ($product) {
            return response()->json([
                'status' => true,
                'message' => 'Product fetched successfully.',
                'images_url' => "https://core-ecommerce-app.ripungupta.com/public/uploads/images/products/",
                'data' => $product->load('category:id,title', 'variant:id,title')
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.',
            ], 200);
        }
    }

    public function removeProductImage($productId, $imageKey)
    {
        $product = $this->productModal->find($productId);
        if (is_null($product)) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
        }

        $images = $product->images;

        if (count($images) == 0) {
            return response()->json(['status' => false, 'message' => 'No images available.'], 404);
        }

        if (!array_key_exists($imageKey, $images)) {
            return response()->json(['status' => false, 'message' => 'Image not found.'], 404);
        }



        if (File::exists(public_path("uploads/images/products/" . $images[$imageKey]))) {
            File::delete(public_path("uploads/images/products/" . $images[$imageKey]));
        }

        unset($images[$imageKey]);
        $product->images = json_encode($images, true);
        $product->save();

        return response()->json([
            'status' => true,
            'message' => 'Product image removed successfully.'
        ], 200);
    }
}
