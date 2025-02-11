<?php

namespace App\Http\Controllers\Backend;

use App\Models\Catatan;
use App\Http\Controllers\Controller;
use App\Models\CatatanDetail;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
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
        $user = $this->user; 
    
        if ($user->can('jadwal.all.data')) {
            $data['data'] = Catatan::with('catatanDetail')->orderBy('tanggal', 'desc')->get();
        }else{
            $data['data'] = Catatan::with('catatanDetail')->where('id_guru',$user->guru->first()->id)->orderBy('tanggal', 'desc')->get();
        }

  

        return view('backend.pages.catatan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['page_title'] = 'Tambah Catatan';
        $user = $this->user; 
    
        if ($user->can('jadwal.all.data')) {
            $data['jadwal'] = Jadwal::orderBy('created_at', 'desc')->get();
        } else {
            $data['jadwal'] = Jadwal::whereHas('mapel', function ($query) use ($user) {
                $query->whereHas('guru', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                });
            })->orderBy('created_at', 'desc')->get();
        }

        $id_jadwal = $request->jadwal;
        if ($id_jadwal) {
            $mapel = Jadwal::with('mapel')
                                ->where('id', $id_jadwal)
                                ->first()
                                ->mapel ?? null;
        } else {
            $mapel = null; // Atau bisa diisi dengan data default
        }
        if ($mapel != null) {
            $data['siswa'] = Siswa::where('id_kelas',$mapel->id_kelas)->orderBy('nama', 'asc')->get();
        }else{
            $data['siswa'] = [];
        }

        return view('backend.pages.catatan.create', $data);
    }

    public function mapel($id){
        $id_jadwal = $id;
        if ($id_jadwal) {
            $mapel = Jadwal::with('mapel')
                                ->where('id', $id_jadwal)
                                ->first()
                                ->mapel ?? null;
        } else {
            $mapel = null; 
        }
        return $mapel->id_guru;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Catatan();
            $data->id_jadwal = $request->id_jadwal;
            $data->id_guru = $this->mapel($request->id_jadwal);
            $data->judul = $request->judul;
            $data->tanggal = $request->tanggal;
            if ($data->save()) {
                foreach ($request->id_siswa as $key => $value) {
                    $detail = new CatatanDetail();
                    $detail->id_catatan = $data->id;
                    $detail->id_siswa = $value;
                    $detail->catatan = $request->catatan[$value];
                    $detail->save();
                }
            }

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('catatan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('catatan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Catatan $Catatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $data['page_title'] = 'Edit Catatan';
        $data['data'] = Catatan::with('catatanDetail')->find($id);
        $user = $this->user; 
    
        if ($user->can('jadwal.all.data')) {
            $data['jadwal'] = Jadwal::orderBy('created_at', 'desc')->get();
        } else {
            $data['jadwal'] = Jadwal::whereHas('mapel', function ($query) use ($user) {
                $query->whereHas('guru', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                });
            })->orderBy('created_at', 'desc')->get();
        }

        $id_jadwal = $request->jadwal;
        $data['id_jadwal'] = $id_jadwal != null ? $id_jadwal : $data['data']->id_jadwal;

        if ($data['id_jadwal']) {
            $mapel = Jadwal::with('mapel')
                                ->where('id', $data['id_jadwal'])
                                ->first()
                                ->mapel ?? null;
        } else {
            $mapel = null;
        }

        if ($mapel != null) {
            $data['siswa'] = Siswa::where('id_kelas',$mapel->id_kelas)->orderBy('nama', 'asc')->get();
        }else{
            $data['siswa'] = [];
        }

        return view('backend.pages.catatan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Catatan::find($id);
            $data->id_jadwal = $request->id_jadwal;
            $data->judul = $request->judul;
            $data->tanggal = $request->tanggal;
            if ($data->save()) {
                if ($request->id_siswa != null) {
                    $cekdata = CatatanDetail::where('id_catatan',$id)->get();
                    foreach ($cekdata as $key => $del) {
                        $del->delete();
                    }

                    foreach ($request->id_siswa as $key => $value) {
                        $detail = new CatatanDetail();
                        $detail->id_catatan = $data->id;
                        $detail->id_siswa = $value;
                        $detail->catatan = $request->catatan[$value];
                        $detail->save();
                    }
                }
            }

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('catatan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('catatan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Catatan::find($id);
            if ($data != null) {
                $cekdata = CatatanDetail::where('id_catatan',$id)->get();
                foreach ($cekdata as $key => $del) {
                    $del->delete();
                }
            }
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('catatan');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('catatan');
        }
    }
}
