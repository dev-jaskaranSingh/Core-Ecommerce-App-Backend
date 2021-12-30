<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\User;

class CustomerAuthController extends Controller
{
    protected $DB;
    protected $userModel;

    public function __construct(Request $request)
    {
        if (!$request->header('X-DB-Connection')) {
            die('Required header files missing!');
        }

        try {
            $this->DB = $request->header('X-DB-Connection');
            $this->userModel = new User;
            $this->userModel->setConnection($this->DB);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function sendSms($mobile, $message)
    {
        $url = "http://sms.trilliuminfosystems.com/api/send_sms.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=trillium&password=trillium@123&sender=TRILLIUM&mobile=" . $mobile . "&message=" . $message);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function sendOTP(Request $request)
    {
        $user = $this->userModel->where('mobile', $request->mobile)->first();
        if ($user) {
            $user->otp = rand(1000, 9999);
            $user->save();
            $message = "Your OTP is " . $user->otp;
            $this->sendSms($request->mobile, $message);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }


    public function verifyOTP(Request $request)
    {
        $user = $this->userModel->where('mobile', $request->mobile)->first();
        if ($user) {
            if ($user->otp == $request->otp) {
                $user->otp = null;
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified successfully',
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'OTP not matched'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }


    public function loginUserWithPassword(Request $request)
    {

        $request->validate([
            'emailOrMobile' => 'required',
            'password' => 'required'
        ]);

        $user = $this->userModel->where('email', $request->emailOrMobile)
            ->orWhere('mobile', $request->emailOrMobile)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if (!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid password'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function userRegister(Request $request)
    {
        $customerRoleId = 2;
        $insertData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:' . $this->DB . '.users',
            'mobile' => 'required|unique:' . $this->DB . '.users',
            'password' => 'required|min:6',
        ]);
        $isUserSaved = $this->userModel->create($insertData + ['role_id' => $customerRoleId]);
        if ($isUserSaved) {
            return response()->json(['status' => 'success', 'data' => $isUserSaved, 'message' => 'User registered successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => [], 'message' => 'User not registered'], 500);
        }
    }


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:' . $this->DB . '.users'
        ]);
        $user = $this->userModel->where('email', $request->email)->first();
        if ($user) {
            $user->otp = rand(1000, 9999);
            $user->save();
            $message = "Your OTP is " . $user->otp;
            $this->sendSms($user->mobile, $message);
            return response()->json(['status' => 'success', 'data' => $user, 'message' => 'OTP sent successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => [], 'message' => 'User not found'], 404);
        }
    }

}
