<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Logic to register a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        auth()->login($user);
        return redirect()->route('products.index');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try{

            // Logic to log in a user
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
               
            if(auth()->user()->is_admin){
        return response()->json(['success' => true, 'redirect' => '/admin/products']);

                //return redirect('/admin/products')->with('success', 'Admin dashboard');
            }
            
    
        return response()->json(['success' => true, 'redirect' => '/products']);
           
           return redirect()->route('products.index');
           
        }
        return response()->json(['success' => false, 'message' => 'Invalid credentials.']);


        // return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
    catch(\Exception $e){
        return response()->json(['success' => false, 'message' => 'An error occurred while logging in.']);
    };
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
