<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function my_account() {
        $user = Auth::user();

        return view('admin_panel.my_account.index', compact('user'));
    }
    
    public function my_account_edit() {
        $user = Auth::user();

        return view('admin_panel.my_account.edit', compact('user'));
    }

    public function my_account_update(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            // 'mobile_number' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'confirmed'],
            'address' => ['required', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
        ]);

        $user = User::find(Auth::user()->id);

        if ($profile_image = $request->file('profile_image')) {
            $extension = $profile_image->getClientOriginalExtension();

            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
                $destination_path = 'images/users/';
                $profile_image_name = date('YmdHis') . "." . $profile_image->getClientOriginalExtension();
                $profile_image->move($destination_path, $profile_image_name);
                $profile_image_name = "$profile_image_name";
            }
            else {
                $profile_image_name = $user->profile_image;
            }
        }

        $user->update([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'position' => $request->position,
            // 'mobile_number' => $request->mobile_number,
            // 'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'address' => $request->address,
            'profile_image' => ($request->file('profile_image')) ? $profile_image_name : $user->profile_image
        ]);

        return redirect()->to('admin-panel/my-account')
            ->with('success', "Profile Update Successfully!!!");
    }

    public function change_theme_color(Request $request) {
        $request->validate([
            'theme_color' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find(Auth::user()->id);

        $user->update([
            'theme_color' => $request->theme_color
        ]);

        return back();
    }
}
