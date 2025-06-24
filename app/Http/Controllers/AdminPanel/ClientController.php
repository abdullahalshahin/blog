<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $clients = Client::query()
            ->latest()
            ->get();

        return view('admin_panel.clients.index', compact('clients'));
    }

    private function data(Client $client) {
        $genders = Client::$genders;
        $status = Client::$status;

        return [
            'client' => $client,
            'genders' => $genders,
            'status' => $status
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin_panel.clients.create', $this->data(new Client()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validate_data = $request->validate([
            'name' => ["required", "string", "max:255"],
            'date_of_birth' => ["required", "date"],
            'gender' => ["required", "in:" . implode(',', Client::$genders)],
            'email' => ["required", "email", "max:255", "unique:clients,email"],
            'password' => ["required", "string", "min:6", "confirmed"],
            'address' => ["nullable", "string"],
            'bio' => ["nullable", "string"],
            'facebook_profile_url' => ["nullable", "string"],
            'you_tube_profile_url' => ["nullable", "string"],
            'instagram_profile_url' => ["nullable", "string"],
            'twitter_profile_url' => ["nullable", "string"],
            'linkedin_profile_url' => ["nullable", "string"],
            'profile_image' => ["nullable", "image", "mimes:jpeg,png,gif", "max:2048"],
            'input_status' => ["required", "in:" . implode(',', Client::$status)],
        ]);

        DB::beginTransaction();

        try {
            $profile_image_name = null;
            if ($profile_image = $request->file('profile_image')) {
                $destination_path = 'images/clients/';
                $profile_image_name = date('YmdHis') . '.' . $profile_image->getClientOriginalExtension();
                $profile_image->move($destination_path, $profile_image_name);
            }

            Client::create([
                'name' => $validate_data['name'],
                'date_of_birth' => $validate_data['date_of_birth'],
                'gender' => $validate_data['gender'],
                'email' => $validate_data['email'],
                'password' => bcrypt($validate_data['password']),
                'address' => $validate_data['address'],
                'bio' => $validate_data['bio'],
                'facebook_profile_url' => $validate_data['facebook_profile_url'],
                'you_tube_profile_url' => $validate_data['you_tube_profile_url'],
                'instagram_profile_url' => $validate_data['instagram_profile_url'],
                'twitter_profile_url' => $validate_data['twitter_profile_url'],
                'linkedin_profile_url' => $validate_data['linkedin_profile_url'],
                'profile_image' => $profile_image_name,
                'status' => $validate_data['input_status'],
            ]);

            DB::commit();

            return redirect()->to('admin-panel/clients')
                ->with('success', 'Created Successfully.');
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while createing the data. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client) {
        return view('admin_panel.clients.show', $this->data($client));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) {
        return view('admin_panel.clients.edit', $this->data($client));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client) {
        $validate_data = $request->validate([
            'name' => ["required", "string", "max:255"],
            'date_of_birth' => ["required", "date"],
            'gender' => ["required", "in:" . implode(',', Client::$genders)],
            'email' => ["required", "string", "max:255", "unique:clients,email," . $client->id],
            // 'password' => ["required", "string", "min:6", "confirmed"],
            'address' => ["nullable", "string"],
            'bio' => ["nullable", "string"],
            'facebook_profile_url' => ["nullable", "string"],
            'you_tube_profile_url' => ["nullable", "string"],
            'instagram_profile_url' => ["nullable", "string"],
            'twitter_profile_url' => ["nullable", "string"],
            'linkedin_profile_url' => ["nullable", "string"],
            'profile_image' => ["nullable", "image", "mimes:jpeg,png,gif", "max:2048"],
            'input_status' => ["required", "in:" . implode(',', Client::$status)],
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
            }

            $client->update([
                'name' => $validate_data['name'],
                'date_of_birth' => $validate_data['date_of_birth'],
                'gender' => $validate_data['gender'],
                'email' => $validate_data['email'],
                // 'password' => bcrypt($validate_data['password']),
                'address' => $validate_data['address'],
                'bio' => $validate_data['bio'],
                'facebook_profile_url' => $validate_data['facebook_profile_url'],
                'you_tube_profile_url' => $validate_data['you_tube_profile_url'],
                'instagram_profile_url' => $validate_data['instagram_profile_url'],
                'twitter_profile_url' => $validate_data['twitter_profile_url'],
                'linkedin_profile_url' => $validate_data['linkedin_profile_url'],
                'profile_image' => ($request->file('profile_image')) ? $profile_image_name : $client->profile_image,
                'status' => $validate_data['input_status']
            ]);

            DB::commit();
    
            return redirect()->to('admin-panel/clients')
                ->with('success', 'Updated Successfully.');
        } 
        catch (\Exception $e) {
            DB::rollback();
    
            return back()
                ->with('error', 'An error occurred while updating the record. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client) {
        DB::beginTransaction();

        try {
            $client->delete();

            DB::commit();

            return redirect()->to('admin-panel/clients')
                ->with('success', 'Deleted Successfully.');
        } 
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while deleting the record. ' . $e->getMessage());
        }
    }
}
