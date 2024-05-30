<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Work;

use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    
    public function show($name) {
        $company = Company::where('name', $name)->first();
        if (!$company) {
            return abort(404);
        }
        $works = Work::where('company_id', $company->id)->get();
        return view('company.show', [
            'company' => $company,
            'works' => $works
        ]);
    }
    
    public function create() {
        return view('company.form', [
            'action' => route('company.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'image'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
        }

        if($validator->fails())
            return response($validator->messages()->toArray(), 400);

        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            // 'image' => $image,
        ]);

        $company->refresh();

        return response(json_encode($company, JSON_UNESCAPED_UNICODE), 200)
            ->header('Content-Type', 'application/json;charset=utf-8');
    }

    public function edit($name) {
        $company = Company::where('name', $name)->first();
        if (!$company){
            abort(404);
        }

        return view('company.form', [
            'company' => $company,
            'action' => route('company.update', $company->name),
            'method' => 'PATCH'
        ]);
    }
    
    public function update(Request $request, $name) {
        $company = Company::where('name', $name)->first();
        if (!$company) {
            abort(404);
        }

        $company->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('company.edit', $company->name);
    }

}