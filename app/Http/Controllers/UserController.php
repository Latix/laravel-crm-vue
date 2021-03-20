<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
    * Create a new CompanyController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::orderBy('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth('api')->user()->isAdmin())
            return response()->json(['status' => 400, 'message' => 'Unauthorized']);

        $validator = Validator::make(request()->all(), [
            'company_id'      => 'required',
	        'name'            => 'required',
            'email'           => 'required|email',
            'account_type'    => 'required',
            'password'        => 'required|confirm',
	    ]);
        
        if (User::where('email', request('email'))->first())
            return response()->json(['status' => 400, 'message' => 'Email already exists!']);

        $user = User::create([
            'company_id'         => $request->company_id,
            'name'               => $request->name,
            'email'              => $request->email,
            'account_type'       => $request->account_type,
            'password'           => bcrypt($request->password)
        ]);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
