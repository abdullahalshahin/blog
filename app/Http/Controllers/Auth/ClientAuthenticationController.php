<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientAuthenticationController extends Controller
{
    public function login() {
        return view('auth.client_login');
    }

    public function login_store(Request $request) {
        $credentials = $request->only('email', 'password');

        $client = Client::query()
            ->where('email', $request->email)
            ->first();

        if ($client && $client->status != "Active") {
            return abort(403, 'Access Denied');
        }

        if (Auth::guard('client')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::CLIENT_HOME);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registration() {
        $genders = Client::$genders;
        
        return view('auth.client_registration', compact('genders'));
    }

    public function registration_store(Request $request) {
        $validate_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:' . implode(',', Client::$genders)],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address' => ['required', 'string', 'max:500']
        ]);

        DB::beginTransaction();

        try {
            Client::create([
                'name' => $validate_data['name'],
                'date_of_birth' => $validate_data['date_of_birth'],
                'gender' => $validate_data['gender'],
                'email' => $validate_data['email'],
                'password' => bcrypt($validate_data['password']),
                'address' => $validate_data['address'],
                'status' => "Active"
            ]);
            
            DB::commit();

            return redirect()->to('client-panel/login')
                ->with('success', 'Registration completed successfully!');
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred during registration: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function log_out(Request $request) {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
