<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{


    public function index(){

            return view('listings',[
                'listings'=> Listing::latest()->filter(\request(['tag','search']))->paginate(6 ),
                'heading'=> 'Latest Listings'


            ]);

    }

    public function index()
    {
        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
        $from = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 9:30:34');

        $diff_in_hours = $to->diffInda($from);

        dd($diff_in_hours);
    }

    public function show(Listing $listing){

        return view('listing',[
            'listing'=> $listing,
            'heading'=> 'Single Listing'
        ]);
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings','company')],
            'location'=> 'required',
            'email'=> ['required','email'],
            'tags'=> 'required',
            'description'=> 'required',
            'website'=> 'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        Listing::create($formFields);

        return redirect('/');
    }

    //edit listing
    public function edit(Listing $listing){
        return view('edit', [
            'listing' => $listing,
            ]);
    }

    public function update(Request $request, Listing $listing){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location'=> 'required',
            'email'=> ['required','email'],
            'tags'=> 'required',
            'description'=> 'required',
            'website'=> 'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);

        return back()->with('sucessfully');
    }

    //delete listing
    public function destroy(Listing $listing){
        $listing->delete();

        return redirect('/');
    }
}
