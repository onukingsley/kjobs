<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    //show Register/Create Form
    public function create(){
        return view('register');
    }

    public function store(Request $request){
        $requestform = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','confirmed', 'min:6']
        ]);
        //hash password
        $requestform['password'] = bcrypt($requestform['password']);

        //create User
        $user = User::create($requestform);

        //login
        auth()->login($user);
        return redirect('/')->with('message','User created and logged in');
    }

    // logout user
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('messsage','you have been logged out');
    }

    public function login(){
        return view('login');
    }

    public function authenticate(Request $request){
        $formRequest = $request->validate([
            'email' => ['required','email'],
            'password' => 'required'
        ]);
        if (auth()->attempt($formRequest)){
            $request->session()->regenerate();

            return redirect('/')->with('message','you are logged in');
        }
        return back()->withErrors(['email'=> 'invalid credentials'])->onlyInput();
    }
}
