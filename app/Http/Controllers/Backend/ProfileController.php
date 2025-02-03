<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        $data['page_title'] = 'My Profile';
        $data['user'] = Admin::find($this->user->id);

        return view('backend.pages.profile.index', $data);
    }
   
    public function changePassword()
    {

        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        $data['page_title'] = 'My Profile';
        $data['user'] = Admin::find($this->user->id);

        return view('backend.pages.profile.change-password', $data);
    }

    public function update(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        try {
            // Update the user's password
            $user = $this->user;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->username = $request->username;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = '-' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/foto_user/');
                $image->move($destinationPath, $name);
                $user->foto = $name;
            }
            $user->save();

            session()->flash('success', 'Berhasil update profile!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function changePasswordProses(Request $request)
    {
        // Validate the request
        $request->validate([
            'newPassword' => 'required|string|min:8|regex:/[A-Z]/|regex:/[@$!%*?&]/',
            'confirmPassword' => 'required|string|same:newPassword',
        ]);

        // Check if the user has the right to view profiles
        if (is_null($this->user) || !$this->user->can('profile.view')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Update the user's password
            $user = $this->user;
            $user->password = bcrypt($request->input('newPassword'));
            $user->save();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Failed to update password.']);
        }
    }
}