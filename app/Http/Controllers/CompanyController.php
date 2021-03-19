<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
    * Create a new CompanyController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompanyResource::collection(Company::orderBy('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
	        'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required|confirm|min:6',
            'logo'      => 'required',
            'url'       => 'required',
	    ]);
        
        if (!request()->hasFile('logo')) {
            return response()->json(['message' => 'Logo is required']);
        }
        
        $file         = request('logo');
        $newFileName  = uniqid()."_".now();
        $extension    = $file->getClientOriginalExtension();
        $newLogoName  = $newFileName.'.'.$extension;
        $path         = $file->storeAs('public/images/companies', $newLogoName);
        

        $company = Company::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'logo'        => $newLogoName,
            'url'         => $request->url,
        ]);
        return new CompanyResource($company);
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
    public function destroy(Company $company)
    {
        if (auth('api')->user()->isAdmin()):
            $company->delete();

            return response()->json(['Company deleted', 200, [
                        'companies' => CompanyResource::collection(Company::orderBy('id', 'desc')->get())
                    ]
            ]);
        endif;
        
        return response()->json(['Unauthorized', 400]);
    }
}
