<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Product;
use Modules\Vendors\Entities\Order;

class OrderController extends Controller
{

    protected $DB, $orderModel;

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
            $this->orderModel = new Order;
            $this->orderModel->setConnection($this->DB);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * saveOrder
     *
     * @param  mixed $request
     * @return json_response
     */
    public function saveOrder(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => "Work in progress"
        ]);
    }

    /**
     * getOrderById
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function getOrderById(Request $request, $id)
    {
        try {
            $order = $this->orderModel->find($id);
            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found!'
                ]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $order
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * getOrderList
     *
     * @param  mixed $request
     * @return void
     */
    public function getOrderList(Request $request)
    {
        try {
            $orders = $this->orderModel->all();

            if (!$orders) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No orders found!'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $orders
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
