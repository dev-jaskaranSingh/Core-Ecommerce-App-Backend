<?php

namespace Modules\MarketingEmployee\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MarketingEmployee\Entities\MarketingLead;
use PHPUnit\Exception;
use DB;
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
     * @param null $employee_id
     * @return JsonResponse
     */
    public function getEmployeeLeads($employee_id = null): JsonResponse
    {
        if (is_null($employee_id)) return response()->json(['status' => false, 'message' => 'required fields missing']);

        $selectedFields = ['id', 'business_name', 'business_address', 'lead_status', 'created_at'];

        $allLeadsCount = MarketingLead::where('employee_id', $employee_id)->latest()->get($selectedFields);

        $todayLeadsCount = MarketingLead::where('employee_id', $employee_id)
            ->whereDate('created_at', Carbon::today())
            ->latest()->get($selectedFields);

        return response()->json(['status' => true, 'allLeads' => $allLeadsCount, 'todayLeads' => $todayLeadsCount]);
    }

    /**
     * @param null $employee_id
     * @return JsonResponse
     */
    public function getEmployeeLeadsCount($employee_id = null): JsonResponse
    {
        if (is_null($employee_id)) return response()->json(['status' => false, 'message' => 'required fields missing']);

        $allLeadsCount = MarketingLead::where('employee_id', $employee_id)->count();
        $todayLeadsCount = MarketingLead::where('employee_id', $employee_id)
            ->whereDate('created_at', Carbon::today())->count();

        return response()->json(['status' => true, 'allLeadsCount' => $allLeadsCount, 'todayLeadsCount' => $todayLeadsCount]);
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

    /**
     * @return Application|Factory|View
     */
    public function leadsListIndex()
    {
        $marketingLeads = MarketingLead::with('lead_employee:id,name,mobile')->latest()
            ->get()->except(['updated_at']);
        return view('marketingemployee::leads.index', compact('marketingLeads'));
    }

    //create function to delete lead
    public function deleteLead(Request $request)
    {
        $id = $request->id;
        $delete = MarketingLead::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Lead deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Failed to delete lead']);
    }

    public function approveLead(Request $request)
    {
        $requestArray = json_decode($request->leadDetails,true);
        $businessName = $requestArray['business_name'];
        $businessId  = $requestArray['id'];

        $dbName = strtolower($businessName.'_'.$businessId);
        DB::statement('CREATE DATABASE '.$dbName);
    }

    public function editLead(MarketingLead $lead)
    {
        dd($lead);
    }

}
