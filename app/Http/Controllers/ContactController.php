<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Company;

class ContactController extends Controller
{

    
    //Index
    public function index( CompanyRepository $company ){
        $contacts = Contact::where(function ($query){
            if($companyID=request()->query("company_id")){
                $query->where("company_id",$companyID);
            }
        })->where(function($query){
            if($search = request()->query('search')){
                $query->where("first_name","LIKE","%{$search}%");
                $query->where("last_name","LIKE","%{$search}%");
                $query->where("email","LIKE","%{$search}%");
            }
        })->orderby('id','desc')->paginate(7);
        $companies =$company->company_data();
        return view('contacts.index',['contacts'=>$contacts,'companies' => $companies]);
    }

    //Create
    public function create(){
        $companies = Company::pluck('name','id');
        return view('contacts.create',compact('companies'));
    }

    //Show
    public function show($id){
        $contact = Contact::find($id);
        return view('contacts.show')->with('contact',$contact);
    }

    //store
    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email',
            'phone'      => 'nullable',
            'address'    => 'nullable',
            'company_id' => 'required|exists:companies,id',
        ]);
       Contact::create($request->all());
       $message = "contact has been add successfully";
       return redirect()->route('contacts.index')->with('message',$message);
    }
    
    //edit
    public function edit($id){
        $companies = Company::pluck('name','id');
        $contact   = Contact::findOrFail($id);
        return view('contacts.edit',compact('companies','contact'));
    }
    public function update(Request $request, $id){
        $contact   = Contact::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email',
            'phone'      => 'nullable',
            'address'    => 'nullable',
            'company_id' => 'required|exists:companies,id',
        ]);
        $contact->update($request->all());
        $message = "Contact has been update successfully";
        return redirect()->route('contacts.index')->with('message',$message);
    }

    //destroy
    public function destroy($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        $message = "Contact has been removed successfully";
        return redirect()->route('contacts.index')->with('message',$message);
    }
}
