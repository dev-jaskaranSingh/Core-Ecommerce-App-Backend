<?php

namespace Modules\SuperAdmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SuperAdmin\Entities\Vendors;
use Hash;

class SuperAdminAuthController extends Controller
{
    public function vendorLogin(Request $request)
    {
        if (!$request->has('mobile') || !$request->has('password')) {
            return response()->json(['status' => true, 'message' => 'Required fields missing !'], 200);
        }
    
        $vendor = Vendors::with('app_details')->where(['mobile' => $request->mobile])->first();

        if (is_null($vendor)) {
            return response()->json(['status' => false, 'message' => 'vendor not found !']);
        }

        if (Hash::check($request->password, $vendor->password)) {
            return response()->json(['status' => true, 'message' => 'vendor found !', 'vendor' => $vendor]);
        } else {
            return response()->json(['status' => false, 'message' => 'Wrong mobile or password !']);
        }
    }
}
