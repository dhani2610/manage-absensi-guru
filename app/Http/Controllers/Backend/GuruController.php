<?php

namespace App\Http\Controllers\Backend;

use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'Guru';
        $data['data'] = Guru::orderBy('nama', 'desc')->get();

        return view('backend.pages.guru.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Guru';

        return view('backend.pages.guru.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Guru();
            $data->nama = $request->nama;
            $data->nidn = $request->nidn;
            $data->kode_guru = $request->kode_guru;

            $newuser = new Admin();
            $newuser->name = $request->nama;
            $newuser->email = $request->email;
            $newuser->username = $request->username;
            $newuser->password = Hash::make($request->password);
            $newuser->save();
            $newuser->assignRole('Guru');

            $data->id_user = $newuser->id;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('guru');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('guru');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Guru';
        $data['data'] = Guru::find($id);

        return view('backend.pages.guru.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Guru::find($id);
            $data->nama = $request->nama;
            $data->nidn = $request->nidn;
            $data->kode_guru = $request->kode_guru;

            $updateuser = Admin::find($data->id_user);
            if (!empty($updateuser)) {
                $updateuser->name = $request->nama;
                $updateuser->email = $request->email;
                $updateuser->username = $request->username;
                if ($request->password != null) {
                    $updateuser->password = Hash::make($request->password);
                }
                $updateuser->save();
            }

            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('guru');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('guru');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Guru::find($id);
            if (!empty($data)) {
                $user = Admin::find($data->id_user);
                $user->delete();
            }
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('guru');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('guru');
        }
    }
}
