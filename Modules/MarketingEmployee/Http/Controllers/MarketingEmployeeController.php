<?php

namespace Modules\MarketingEmployee\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\MarketingEmployee\Entities\MarketingEmployee;

class MarketingEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $empoyeesData = MarketingEmployee::get();
        return view('marketingemployee::index',['employees' => $empoyeesData]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('marketingemployee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'mobile' => 'required',
           'password' => 'required',
        ]);
        $response = MarketingEmployee::create($request->all());
        if($response){
            return redirect()->back()->with('message', 'Employee Saved!');
        }
        return redirect()->back()->with('message', 'Failed!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('marketingemployee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        dd($id);
        return view('marketingemployee::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        dd($request->all(),$id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(MarketingEmployee $employee)
    {
        if($employee->delete()){
            return redirect()->back()->with('message', 'Employee Successfully Deleted!');
        }
        return redirect()->back()->with('message', 'Failed!');
    }

    public function login(Request $request){
        if(!$request->has('mobile') || !$request->has('mobile')){
            return response()->json(['status'=>true,'message' =>'Required fields missing !'],200);
        }
        $user = MarketingEmployee::where(['mobile' => $request->mobile])->first();

        if(is_null($user)) {
            return response()->json(['status' => false,'message' => 'User not found !']);
        }

        if(Hash::check($request->password, $user->password)){
            return response()->json(['status' => true,'message' => 'User found !','user' => $user]);
        }else{
            return response()->json(['status' => false,'message' => 'Wrong mobile or password !']);
        }
    }
}
