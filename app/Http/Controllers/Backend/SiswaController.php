<?php

namespace App\Http\Controllers\Backend;

use App\Models\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
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
        $data['page_title'] = 'Siswa';
        $data['data'] = Siswa::with('kelas')->orderBy('nama', 'desc')->get();

        return view('backend.pages.siswa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Siswa';
        $data['kelas'] = Kelas::orderBy('nama_kelas', 'desc')->get();

        return view('backend.pages.siswa.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Siswa();
            $data->nama = $request->nama;
            $data->nisn = $request->nisn;
            $data->id_kelas = $request->id_kelas;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('siswa');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Siswa';
        $data['data'] = Siswa::find($id);
        $data['kelas'] = Kelas::orderBy('nama_kelas', 'desc')->get();

        return view('backend.pages.siswa.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Siswa::find($id);
            $data->nama = $request->nama;
            $data->nisn = $request->nisn;
            $data->id_kelas = $request->id_kelas;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('siswa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Siswa::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('siswa');
        }
    }
}
