<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyAccountController extends Controller
{
    public function my_account() {
        $client = Auth::user();

        return view('client_panel.my_account.index', compact('client'));
    }

    public function my_account_edit() {
        $client = Auth::user();
        $genders = Client::$genders;

        return view('client_panel.my_account.edit', compact('client', 'genders'));
    }

    public function my_account_update(Request $request) {
        $client = Client::find(Auth::user()->id);

        $validate_data = $request->validate([
            'name' => ["required", "string", "max:255"],
            'date_of_birth' => ["required", "date"],
            'gender' => ["required", "in:" . implode(',', Client::$genders)],
            'address' => ["nullable", "string"],
            'bio' => ["nullable", "string"],
            'facebook_profile_url' => ["nullable", "string"],
            'you_tube_profile_url' => ["nullable", "string"],
            'instagram_profile_url' => ["nullable", "string"],
            'twitter_profile_url' => ["nullable", "string"],
            'linkedin_profile_url' => ["nullable", "string"],
            'profile_image' => ["nullable", "image", "mimes:jpeg,png,gif", "max:2048"]
        ]);

        DB::beginTransaction();
    
        try {
            if ($profile_image = $request->file('profile_image')) {
                $destination_path = 'images/clients/';
                $profile_image_name = date('YmdHis') . '.' . $profile_image->getClientOriginalExtension();
                $profile_image->move($destination_path, $profile_image_name);

                if ($client->profile_image && file_exists($destination_path . $client->profile_image)) {
                    unlink($destination_path . $client->profile_image);
                }
                
                $profile_image_text = $profile_image_name;
            }

            $client->update([
                'name' => $validate_data['name'],
                'date_of_birth' => $validate_data['date_of_birth'],
                'gender' => $validate_data['gender'],
                'address' => $validate_data['address'],
                'bio' => $validate_data['bio'],
                'facebook_profile_url' => $validate_data['facebook_profile_url'],
                'you_tube_profile_url' => $validate_data['you_tube_profile_url'],
                'instagram_profile_url' => $validate_data['instagram_profile_url'],
                'twitter_profile_url' => $validate_data['twitter_profile_url'],
                'linkedin_profile_url' => $validate_data['linkedin_profile_url'],
                'profile_image' => ($request->file('profile_image')) ? $profile_image_text : $client->profile_image
            ]);

            DB::commit();

            return redirect()->to('client-panel/my-account')
                ->with('success', "Profile Update Successfully!!!");
        }
        catch (\Exception $e) {
            DB::rollback();
    
            return back()
                ->with('error', 'An error occurred while updating the record. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function change_theme_color(Request $request) {
        $request->validate([
            'theme_color' => ['required', 'string', 'max:255'],
        ]);

        $client = Client::find(Auth::user()->id);

        DB::beginTransaction();
    
        try {
            $client->update([
                'theme_color' => $request->theme_color
            ]);

            DB::commit();

            return back();
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while updating the record. ' . $e->getMessage())
                ->withInput();
        }
    }
}
