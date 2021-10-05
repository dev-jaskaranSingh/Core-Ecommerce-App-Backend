<?php

namespace Modules\MarketingEmployee\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\MarketingEmployee\Entities\MarketingEmployee;

class MarketingEmployeeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $employeesData = MarketingEmployee::get();
        return view('marketingemployee::index', ['employees' => $employeesData]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('marketingemployee::create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required | integer',
            'password' => 'required | min:6 ',
        ]);

        $response = MarketingEmployee::create($request->all());
        if ($response) {
            return redirect()->back()->with('message', 'Employee Saved!');
        }
        return redirect()->back()->with('message', 'Failed!');
    }

    /**
     * @param MarketingEmployee $employee
     * @return Application|Factory|View
     */
    public function edit(MarketingEmployee $employee)
    {
        return view('marketingemployee::edit', ['employee' => $employee]);
    }

    /**
     * @param Request $request
     * @param MarketingEmployee $employee
     * @return RedirectResponse
     */

    public function update(Request $request, MarketingEmployee $employee): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required | integer',
            'password' => 'required | min:6',
        ]);
        $response = $employee->update($request->all());

        if ($response) return redirect()->back()->with('message', 'Employee Updated Successfully!');
        return redirect()->back()->with('message', 'Failed!');
    }

    /**
     * @param MarketingEmployee $employee
     * @return RedirectResponse
     */
    public function destroy(MarketingEmployee $employee): RedirectResponse
    {
        if ($employee->delete()) return redirect()->back()->with('message', 'Employee Successfully Deleted!');
        return redirect()->back()->with('message', 'Failed!');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (!$request->has('mobile') || !$request->has('mobile')) {
            return response()->json(['status' => true, 'message' => 'Required fields missing !'], 200);
        }
        $user = MarketingEmployee::where(['mobile' => $request->mobile])->first();

        if (is_null($user)) {
            return response()->json(['status' => false, 'message' => 'User not found !']);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['status' => true, 'message' => 'User found !', 'user' => $user]);
        } else {
            return response()->json(['status' => false, 'message' => 'Wrong mobile or password !']);
        }
    }

    public function businessTypes()
    {
        $data = [
            0 => 'Grocery', 1 => 'Vegetables', 2 => 'Fruits', 3 => 'Dairy Products', 4 => 'Fast Foods'
        ];
        return response()->json(['status' => false, 'business' => $data]);
    }
}
