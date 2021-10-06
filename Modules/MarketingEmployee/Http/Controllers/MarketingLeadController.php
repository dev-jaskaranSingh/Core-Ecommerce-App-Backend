<?php

namespace Modules\MarketingEmployee\Http\Controllers;

use Carbon\Carbon;
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

    /**
     * @param $employee
     * @return JsonResponse
     */
    public function getEmployeeLeads($employee_id = null): JsonResponse
    {
        if (is_null($employee_id)) return response()->json(['status' => false, 'message' => 'required fields missing']);

        $selectedFields = ['id','business_name','business_address','lead_status','created_at'];
        $allLeadsCount = MarketingLead::where('employee_id', $employee_id);
        $todayLeadsCount = $allLeadsCount->whereDate('created_at', Carbon::today())->get($selectedFields);

        return response()->json(['status' => true, 'allLeads' => $allLeadsCount->get($selectedFields), 'todayLeads' => $todayLeadsCount]);
    }

    /**
     * @param $employee
     * @return JsonResponse
     */
    public function getEmployeeLeadsCount($employee_id = null): JsonResponse
    {
        if (is_null($employee_id)) return response()->json(['status' => false, 'message' => 'required fields missing']);

        $allLeadsCount = MarketingLead::where('employee_id', $employee_id);
        $todayLeadsCount = $allLeadsCount->whereDate('created_at', Carbon::today())->count();

        return response()->json(['status' => true, 'allLeadsCount' => $allLeadsCount->count(), 'todayLeadsCount' => $todayLeadsCount]);
    }

    /**
     * @param null $mobile
     * @return JsonResponse
     */
    public function getEmployeeByMobile($mobile = null): JsonResponse
    {
        if (is_null($mobile)) return response()->json(['status' => false, 'message' => 'required fields missing']);

        $isLeadExist = MarketingLead::where('mobile', $mobile)->count();

        return response()->json(['status' => true, 'isLeadExist' => $isLeadExist > 0]);
    }
}
