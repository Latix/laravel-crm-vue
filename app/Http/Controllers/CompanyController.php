<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Service\AppHelper;
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
        
        $file              = request('logo');
        $file_path         = 'public/images/companies';

        $logoName          = (new AppHelper)->handleFileUpload($file, $file_path);

        $company = Company::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'logo'        => $logoName,
            'url'         => $request->url,
        ]);
        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {;
        $validator = Validator::make(request()->all(), [
	        'name'      => 'required',
            'url'       => 'required',
	    ]);
        
        if (request()->hasFile('logo')) {
            $file              = request('logo');
            $file_path         = 'public/images/companies';

            (new AppHelper)->removeExistingFile($company->getLogo());
            $logoName          = (new AppHelper)->handleFileUpload($file, $file_path);

            $company->update([
                'logo'        => $logoName,
            ]);
        }

        if(!empty(request('password'))) {
            if (request('password') === request('password_confirmation'))
            {
                $company->update([
                    'password' => bcrypt(request('password'))
                ]);
            }
        }
    
        $company->update([
            'name'        => $request->name,
            'url'         => $request->url
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Company Updated!",
            'company' => new CompanyResource($company)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company  $company
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
