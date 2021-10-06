<?php

namespace Modules\MarketingEmployee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MarketingEmployee\Entities\MarketingLead;
use PHPUnit\Exception;

class MarketingLeadController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveLead(Request $request): JsonResponse
    {

        try {
            if (in_array(null, $request->all(), true)) return response()->json(['status' => false, 'message' => 'required fields missing']);

            $required = ['businessCategoryId', 'deliveryStatus', 'businessAddress', 'businessName', 'email', 'name', 'mobile', 'employee_id'];
            $requestData = $request->all();

            if (count(array_intersect_key(array_flip($required), $requestData)) !== count($required)) return response()->json(['status' => false, 'message' => 'required fields missing']);

            $insertArray = [
                "business_category_id" => $request->businessCategoryId,
                "delivery_status" => $request->deliveryStatus,
                "business_address" => $request->businessAddress,
                "business_name" => $request->businessName,
                "email" => $request->email,
                "name" => $request->name,
                "mobile" => $request->mobile,
                "employee_id" => $request->employee_id
            ];
            $response = MarketingLead::create($insertArray);
            if ($response) {
                return response()->json(['status' => true, 'message' => 'successfully saved!', 'last_saved_id' => $response->id]);
            }
            return response()->json(['status' => false, 'message' => 'Failed to save!']);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
