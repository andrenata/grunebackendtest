<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;
use DB;
use Config;

class CompaniesController extends Controller {

    /**
     * Get named route
     *
     */
    private function getRoute() {
        return 'admin';
    }

    

    public function companies() {
        return view('backend.companies.index');
        // echo "test";
    }
    public function companiesadd() {
        // echo "text";
        $company = new Company();
        $company->form_action = $this->getRoute() . '.companies.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';

        $prefectures = DB::table('prefectures')->get();
        
        return view('backend.companies.form', array('company' => $company),
                compact('prefectures'));
    }

    public function create(Request $request){
        $datacompany = $request->all();

        $companycreate = DB::table('companies')->insertGetId([
            'name' => $datacompany['display_name'],
            'email' => $datacompany['display_email'],
            'prefecture_id' => $datacompany['display_prefecture'],
            'phone' => $datacompany['display_phone'],
            'postcode' => $datacompany['display_postcode'],
            'city' => $datacompany['display_city'],
            'local' => $datacompany['display_local'],
            'street_address' => $datacompany['display_street'],
            'business_hour' => $datacompany['display_hour'],
            'regular_holiday' => $datacompany['display_holiday'],
            'fax' => $datacompany['display_fax'],
            'url' => $datacompany['display_url'],
            'license_number' => $datacompany['display_licence']
        ]);

        if($companycreate){

            // PHOTO
            $image = $request->file('display_image');
            $imageName = 'image_'.$companycreate.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/files');
            $image->move($destinationPath, $imageName);

            $update = DB::table('companies')->where('id', '=', $companycreate)
                        ->update([
                            'image' => $imageName
            ]);

            if($update){
                return redirect()->route('companies')
                    ->with('success', 'Add Company Success!');
            }else{
                return redirect()->back()->withInput()
                            ->with('success', 'Please Try Again!');
            }
        }else{
            return redirect()->back()->withInput()
                        ->with('success', 'Please Try Again!');
        }
    }

    public function edit($id) {
        $company = Company::find($id);
        $company->form_action = $this->getRoute() . '.companies.update';
        $company->page_title = 'Company Edit Page';

        $company->page_type = 'edit';

        $prefectures = DB::table('prefectures')->get();
        
        return view('backend.companies.form', array('company' => $company),
                compact('prefectures'));
    }

    public function update(Request $request) {
        $datacompany = $request->all();
        $id = $request->get('id');

        $companny = DB::table('companies')->find($id);

        if($companny){
            $update = DB::table('companies')->where('id', '=', $id)
                    ->update([
                        'name' => $datacompany['display_name'],
                        'email' => $datacompany['display_email'],
                        'prefecture_id' => $datacompany['display_prefecture'],
                        'phone' => $datacompany['display_phone'],
                        'postcode' => $datacompany['display_postcode'],
                        'city' => $datacompany['display_city'],
                        'local' => $datacompany['display_local'],
                        'street_address' => $datacompany['display_street'],
                        'business_hour' => $datacompany['display_hour'],
                        'regular_holiday' => $datacompany['display_holiday'],
                        'fax' => $datacompany['display_fax'],
                        'url' => $datacompany['display_url'],
                        'license_number' => $datacompany['display_licence']
            ]);
            
            if(!empty($datacompany['display_image'])){
                // PHOTO
                $image = $request->file('display_image');
                $imageName = 'image_'.$id.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/files');
                $image->move($destinationPath, $imageName);

                $updateimage = DB::table('companies')->where('id', '=', $id)
                            ->update([
                                'image' => $imageName
                ]);
            }
            
            return redirect()->route('companies')
                ->with('success', 'Update Company Success!');
            
        }else{
            return redirect()->back()->withInput()
                            ->with('success', 'Please Try Again!');
        }
        
    }

    public function delete(Request $request) {
        $company = Company::find($request->get('id'));

        if($company){
            // Delete
            $del = $company->delete();

            if($del){
                return redirect()->route('companies')
                    ->with('success', 'Delete Company Success!');
            }else{
                return redirect()->route('companies')
                    ->with('success', 'Delete Company failed!');
            }
        }else{
            return redirect()->route('companies')
                ->with('success', 'Delete Company failed!');
        }
    }

    public function postcode($id){
        // $postcode = Postcode::find($id);
        // $postcode = DB::table('postcodes')
        //         ->where('postcode', '=', $id)
        //         ->get();

        $postcode = DB::table('postcodes')
                ->join('prefectures','prefectures.display_name','=','postcodes.prefecture')
                ->where('postcode', '=', $id)
                ->get();
 
        return $postcode->toJson();
    }
   

}
