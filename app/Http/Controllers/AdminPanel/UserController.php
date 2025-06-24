<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::query()
            ->where('id', '!=', 1)
            ->latest()
            ->get();

        return view('admin_panel.users.index', compact('users'));
    }

    private function data(User $user) {
        return [
            'user' => $user
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin_panel.users.create', $this->data(new User()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validate_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'string', 'max:255'],
            'gender' => ["required", "in:" . implode(',', User::$genders)],
            'position' => ['nullable', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed','min:6'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'input_status' => ["required", "in:" . implode(',', User::$status)],
        ]);

        DB::beginTransaction();

        try {
            $profile_image_name = null;

            if ($profile_image = $request->file('profile_image')) {
                $destination_path = 'images/users/';
                $profile_image_name = date('YmdHis') . '.' . $profile_image->getClientOriginalExtension();
                $profile_image->move($destination_path, $profile_image_name);
            }

            $user = User::create([
                'name' => $validate_data['name'],
                'date_of_birth' => $validate_data['date_of_birth'],
                'gender' => $validate_data['gender'],
                'position' => $validate_data['position'],
                'mobile_number' => $validate_data['mobile_number'],
                'email' => $validate_data['email'],
                'password' => Hash::make($validate_data['password']),
                'address' => $validate_data['address'],
                'profile_image' => ($request->file('profile_image')) ? $profile_image_name : null,
                'status' => $validate_data['input_status']
            ]);

            DB::commit();

            return redirect()->to('admin-panel/users')
                ->with('success', 'Created Successfully.');
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while updating the product. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        if ($user->id != 1) {
            return view('admin_panel.users.show', $this->data($user));
        }
        else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        if ($user->id != 1) {
            return view('admin_panel.users.edit', $this->data($user));
        }
        else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        if ($user->id != 1) {
            $validate_data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'date_of_birth' => ['nullable', 'string', 'max:255'],
                'gender' => ["required", "in:" . implode(',', User::$genders)],
                'position' => ['nullable', 'string', 'max:255'],
                'mobile_number' => ['required', 'string', 'max:255', 'unique:users,mobile_number,'.$user->id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
                // 'password' => ['required', 'confirmed', 'min:6'],
                'address' => ['nullable', 'string', 'max:255'],
                'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
                'input_status' => ["required", "in:" . implode(',', User::$status)],
            ]);
    
            DB::beginTransaction();
    
            try {
                $profile_image_name = null;

                if ($profile_image = $request->file('profile_image')) {
                    if ($user->profile_image && file_exists('images/users/' . $user->profile_image)) {
                        unlink('images/users/' . $user->profile_image);
                    }

                    $destination_path = 'images/users/';
                    $profile_image_name = date('YmdHis') . '.' . $profile_image->getClientOriginalExtension();
                    $profile_image->move($destination_path, $profile_image_name);
                }
                else {
                    $profile_image_name = $user->profile_image;
                }
                
                $user->update([
                    'name' => $validate_data['name'],
                    'date_of_birth' => $validate_data['date_of_birth'],
                    'gender' => $validate_data['gender'],
                    'position' => $validate_data['position'],
                    'mobile_number' => $validate_data['mobile_number'],
                    'email' => $validate_data['email'],
                    // 'password' => Hash::make($validate_data['password']),
                    'address' => $validate_data['address'],
                    'profile_image' => $profile_image_name,
                    'status' => $validate_data['input_status']
                ]);

                DB::commit();
    
                return redirect()->to('admin-panel/users')
                    ->with('success', 'Updated Successfully.');
            }
            catch (\Exception $e) {
                DB::rollback();
    
                return back()
                    ->with('error', 'An error occurred while updating the product. ' . $e->getMessage())
                    ->withInput();
            }
        }
        else {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        if ($user->id != 1) {
            DB::beginTransaction();

            try {
                $user->delete();

                DB::commit();

                return redirect()->to('admin-panel/users')
                    ->with('success', 'Deleted Successfully.');
            } 
            catch (\Exception $e) {
                DB::rollback();

                return back()
                    ->with('error', 'An error occurred while deleting the record. ' . $e->getMessage());
            }
        }
        else {
            return abort(404);
        }
    }
}
