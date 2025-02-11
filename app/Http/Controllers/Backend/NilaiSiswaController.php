<?php

namespace App\Http\Controllers\Backend;

use App\Models\NilaiSiswa;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\NilaiSiswaDetail;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiSiswaController extends Controller
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
            $data['data'] = NilaiSiswa::with('nilaiSiswaDetail')->orderBy('created_at', 'desc')->get();
        }else{
            $data['data'] = NilaiSiswa::with('nilaiSiswaDetail')->where('id_guru',$user->guru->first()->id)->orderBy('created_at', 'desc')->get();
        }

  

        return view('backend.pages.nilai.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['page_title'] = 'Tambah Nilai';
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

        $data['mapel'] = MataPelajaran::whereIn('id',$data['jadwal']->pluck('id_mapel'))->orderBy('nama_mapel', 'desc')->get();

        $id_mapel = $request->mapel;
        $mapel = MataPelajaran::find($id_mapel);
        if ($mapel != null) {
            $data['siswa'] = Siswa::where('id_kelas',$mapel->id_kelas)->orderBy('nama', 'asc')->get();
        }else{
            $data['siswa'] = [];
        }

        return view('backend.pages.nilai.create', $data);
    }

    public function mapel($id){
        $mapel = MataPelajaran::find($id);

        return $mapel->id_guru;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new NilaiSiswa();
            $data->id_mapel = $request->id_mapel;
            $data->id_guru = $this->mapel($request->id_mapel);
            $data->judul = $request->judul;
            $data->tanggal = $request->tanggal;
            if ($data->save()) {
                foreach ($request->id_siswa as $key => $value) {
                    $detail = new NilaiSiswaDetail();
                    $detail->id_nilai = $data->id;
                    $detail->id_siswa = $value;
                    $detail->bobot_1 = $request->bobot_1[$value];
                    $detail->bobot_2 = $request->bobot_2[$value];
                    $detail->bobot_3 = $request->bobot_3[$value];
                    $detail->bobot_4 = $request->bobot_4[$value];
                    $detail->persentase_bobot_1 = $request->persentase_bobot_1[$value];
                    $detail->persentase_bobot_2 = $request->persentase_bobot_2[$value];
                    $detail->persentase_bobot_3 = $request->persentase_bobot_3[$value];
                    $detail->persentase_bobot_4 = $request->persentase_bobot_4[$value];
                    $detail->persentase_total = $request->persentase_total[$value];
                    $detail->save();
                }
            }

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('nilai.siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('nilai.siswa');
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
        $data['page_title'] = 'Edit Nilai';
        $data['data'] = NilaiSiswa::with('nilaiSiswaDetail')->find($id);
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

        $id_mapel = $request->mapel;
        $data['id_mapel'] = $id_mapel != null ? $id_mapel : $data['data']->id_mapel;
        $data['mapel'] = MataPelajaran::whereIn('id',$data['jadwal']->pluck('id_mapel'))->orderBy('nama_mapel', 'desc')->get();

        $mapel = MataPelajaran::find($data['id_mapel']);
        if ($mapel != null) {
            $data['siswa'] = Siswa::where('id_kelas',$mapel->id_kelas)->orderBy('nama', 'asc')->get();
        }else{
            $data['siswa'] = [];
        }

        return view('backend.pages.nilai.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = NilaiSiswa::find($id);
            $data->id_mapel = $request->id_mapel;
            $data->id_guru = $this->mapel($request->id_mapel);
            $data->judul = $request->judul;
            $data->tanggal = $request->tanggal;
            if ($data->save()) {
                if ($request->id_siswa != null) {
                    $cekdata = NilaiSiswaDetail::where('id_nilai',$id)->get();
                    foreach ($cekdata as $key => $del) {
                        $del->delete();
                    }

                    foreach ($request->id_siswa as $key => $value) {
                        $detail = new NilaiSiswaDetail();
                        $detail->id_nilai = $data->id;
                        $detail->id_siswa = $value;
                        $detail->bobot_1 = $request->bobot_1[$value];
                        $detail->bobot_2 = $request->bobot_2[$value];
                        $detail->bobot_3 = $request->bobot_3[$value];
                        $detail->bobot_4 = $request->bobot_4[$value];
                        $detail->persentase_bobot_1 = $request->persentase_bobot_1[$value];
                        $detail->persentase_bobot_2 = $request->persentase_bobot_2[$value];
                        $detail->persentase_bobot_3 = $request->persentase_bobot_3[$value];
                        $detail->persentase_bobot_4 = $request->persentase_bobot_4[$value];
                        $detail->persentase_total = $request->persentase_total[$value];
                        $detail->save();
                    }
                }
            }

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('nilai.siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('nilai.siswa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = NilaiSiswa::find($id);
            if ($data != null) {
                $cekdata = NilaiSiswaDetail::where('id_nilai',$id)->get();
                foreach ($cekdata as $key => $del) {
                    $del->delete();
                }
            }
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('nilai.siswa');
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->route('nilai.siswa');
        }
    }
}
