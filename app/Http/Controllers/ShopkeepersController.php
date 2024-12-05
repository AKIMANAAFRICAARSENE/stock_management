<?php

namespace App\Http\Controllers;

use App\Models\Shopkeepers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Log;

class ShopkeepersController extends Controller
{
    public function register()
    {
        return view("auth.register");
    }

    public function login()
    {
        return view("auth.login");
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                "UserName" => ["required", "string", "min:3", "max:50", "unique:shopkeepers,UserName"],
                "Password" => ["required", "string", "min:5", "max:50"],
                "Cpass" => ["required", "string", "same:Password"]
            ], [
                'UserName.unique' => 'This username is already taken.',
                'Cpass.same' => 'The confirmation password does not match.',
            ]);

            // Create the user
            $user = Shopkeepers::create([
                "UserName" => $validatedData['UserName'],
                "Password" => FacadesHash::make($validatedData['Password']),
            ]);

            if (!$user) {
                Log::error('Failed to create user in database');
                return back()->with("fail", "Failed to create account. Please try again.");
            }

            return redirect()->route('login')->with("success", "Account created successfully! Please login.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->with("fail", "Registration failed. Please try again later.")->withInput();
        }
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            "UserName" => ["required", "string"],
            "Password" => ["required", "string", "min:5", "max:50"]
        ]);

        $user = Shopkeepers::where("UserName", "=", $request->UserName)->first();
        if ($user) {
            if (FacadesHash::check($request->Password, $user->Password)) {
                $request->session()->put("loginId", $user->ShopkeeperId);
                return redirect("/")->with("success", "Login successful");
            } else {
                return back()->with("fail", "Incorrect password");
            }
        } else {
            return back()->with("fail", "Username not found");
        }
    }

    public function logOut(Request $request)
    {
        $request->session()->forget("loginId");
        return redirect("login")->with("success", "Logged out successfully!");
    }

    public function show(Shopkeepers $shopkeepers)
    {
        //
    }

    public function edit(Shopkeepers $shopkeepers)
    {
        //
    }

    public function update(Request $request, Shopkeepers $shopkeepers)
    {
        //
    }

    public function destroy(Shopkeepers $shopkeepers)
    {
        //
    }
}
