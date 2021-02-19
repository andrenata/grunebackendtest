<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
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
        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }
   

}
