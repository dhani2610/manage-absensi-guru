<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jadwal;
use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
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
        $data['page_title'] = 'Jadwal';
        $user = $this->user; 
    
        if ($user->can('jadwal.all.data')) {
            $data['data'] = Jadwal::orderBy('created_at', 'desc')->get();
        } else {
            $data['data'] = Jadwal::whereHas('mapel', function ($query) use ($user) {
                $query->whereHas('guru', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                });
            })->orderBy('created_at', 'desc')->get();
        }
    
        return view('backend.pages.jadwal.index', $data);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Jadwal';
        $data['mapel'] = MataPelajaran::orderBy('nama_mapel', 'desc')->get();

        return view('backend.pages.jadwal.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Jadwal();
            $data->id_mapel = $request->id_mapel;
            $data->jam_mulai = $request->jam_mulai;
            $data->jam_akhir = $request->jam_akhir;
            $data->hari = $request->hari;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('jadwal');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('jadwal');
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
        $data['page_title'] = 'Edit Jadwal';
        $data['data'] = Jadwal::find($id);
        $data['mapel'] = MataPelajaran::orderBy('nama_mapel', 'desc')->get();

        return view('backend.pages.jadwal.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Jadwal::find($id);
            $data->id_mapel = $request->id_mapel;
            $data->jam_mulai = $request->jam_mulai;
            $data->jam_akhir = $request->jam_akhir;
            $data->hari = $request->hari;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('jadwal');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('jadwal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Jadwal::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('jadwal');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('jadwal');
        }
    }
}
