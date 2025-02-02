<?php

namespace App\Http\Controllers\Backend;

use App\Models\Kelas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
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
        $data['page_title'] = 'Kelas';
        $data['data'] = Kelas::orderBy('nama_kelas', 'desc')->get();

        return view('backend.pages.kelas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Kelas';

        return view('backend.pages.kelas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkKelas = Kelas::where('nama_kelas',$request->nama_kelas)->where('jenis_kelas',$request->jenis_kelas)->first();
            if ($checkKelas != null) {
                session()->flash('failed', 'Kelas tersebut sudah tersedia!');
                return redirect()->route('kelas');
            }
            $data = new Kelas();
            $data->nama_kelas = $request->nama_kelas;
            $data->jenis_kelas = $request->jenis_kelas;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('kelas');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('kelas');
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
        $data['page_title'] = 'Edit Kelas';
        $data['data'] = Kelas::find($id);

        return view('backend.pages.kelas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $checkKelas = Kelas::whereNotIn('id',[$id])->where('nama_kelas',$request->nama_kelas)->where('jenis_kelas',$request->jenis_kelas)->first();
            if ($checkKelas != null) {
                session()->flash('failed', 'Kelas tersebut sudah tersedia!');
                return redirect()->route('kelas');
            }

            $data = Kelas::find($id);
            $data->nama_kelas = $request->nama_kelas;
            $data->jenis_kelas = $request->jenis_kelas;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('kelas');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('kelas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Kelas::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('kelas');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('kelas');
        }
    }
}
