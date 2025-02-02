<?php

namespace App\Http\Controllers\Backend;

use App\Models\MataPelajaran;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataPelajaranController extends Controller
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
        $data['page_title'] = 'Mata Pelajaran';
        $data['data'] = MataPelajaran::orderBy('nama_mapel', 'desc')->get();

        return view('backend.pages.mata-pelajaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Mata Pelajaran';
        $data['guru'] = Guru::orderBy('nama', 'desc')->get();
        $data['kelas'] = Kelas::orderBy('nama_kelas', 'desc')->get();

        return view('backend.pages.mata-pelajaran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new MataPelajaran();
            $data->nama_mapel = $request->nama_mapel;
            $data->kode_mapel = $request->kode_mapel;
            $data->id_kelas = $request->id_kelas;
            $data->id_guru = $request->id_guru;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('mata.pelajaran');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('mata.pelajaran');
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
        $data['page_title'] = 'Edit Mata Pelajaran';
        $data['data'] = MataPelajaran::find($id);
        $data['guru'] = Guru::orderBy('nama', 'desc')->get();
        $data['kelas'] = Kelas::orderBy('nama_kelas', 'desc')->get();
        
        return view('backend.pages.mata-pelajaran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = MataPelajaran::find($id);
            $data->nama_mapel = $request->nama_mapel;
            $data->kode_mapel = $request->kode_mapel;
            $data->id_kelas = $request->id_kelas;
            $data->id_guru = $request->id_guru;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('mata.pelajaran');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('mata.pelajaran');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = MataPelajaran::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('mata.pelajaran');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('mata.pelajaran');
        }
    }
}
