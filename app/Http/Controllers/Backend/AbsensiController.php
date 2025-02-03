<?php

namespace App\Http\Controllers\Backend;

use App\Models\Absensi;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
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
        $user = $this->user; 
    
        if ($user->can('absensi.all.data')) {
            $data['data'] = Absensi::with('user','jadwal')->orderBy('created_at', 'desc')->get();
        } else {
            $data['data'] = Absensi::with('user','jadwal')->whereHas('user', function ($query) use ($user) {
                    $user->where('id', $user->id);
            })->orderBy('created_at', 'desc')->get();
        }

        $sudahAbsen = Absensi::where('id_user',$user->id)->where('tanggal',date('Y-m-d'))->get()->pluck('id_jadwal');

        $hari_ini = Carbon::now()->locale('id')->isoFormat('dddd'); // Mendapatkan nama hari dalam bahasa Indonesia
        if ($user->can('jadwal.all.data')) {
            $data['jadwal'] = Jadwal::whereNotIn('id',$sudahAbsen)->where('hari', $hari_ini)->orderBy('created_at', 'desc')->get();
        } else {
            $data['jadwal'] = Jadwal::whereNotIn('id',$sudahAbsen)->whereHas('mapel', function ($query) use ($user) {
                $query->whereHas('guru', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                });
            })->where('hari', $hari_ini)->orderBy('created_at', 'desc')->get();
        }

        return view('backend.pages.absensi.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = $this->user; 

            $checkAbsenJadwal = Absensi::where('id_jadwal',$request->id_jadwal)->where('id_user',$user->id)->where('tanggal',date('Y-m-d'))->first();
            if ($checkAbsenJadwal != null) {
                session()->flash('failed', 'Anda sudah absen mata pelajaran tersebut!');
                return redirect()->route('kelas');
            }
            $checkJadwal = Jadwal::find($request->id_jadwal);

            $base64data = $request->input('image');
            // Menghapus header data base64
            $base64data = preg_replace('#^data:image/\w+;base64,#i', '', $base64data);

            // Decode base64 menjadi binary data
            $image = base64_decode($base64data);

            // Pastikan decoding berhasil
            if ($image === false) {
                return redirect()->back()->with('error', 'Failed to decode base64 image.');
            }

            $imageName = $user->id.'-'.time() . '.jpg';
            $destinationPath = public_path('assets/img/absensi/');
            file_put_contents($destinationPath . $imageName, $image);

            $data = new Absensi();
            $data->image = $imageName;
            $data->id_user = $user->id;
            $data->id_jadwal = $request->id_jadwal;
            $data->periode_waktu_mulai_absensi = $checkJadwal->jam_mulai;
            $data->periode_waktu_akhir_absensi = $checkJadwal->jam_akhir;
            $data->waktu_absen = date('H:i:s');
            $data->tanggal = date('Y-m-d');
            $data->save();
            session()->flash('success', 'Berhasil melakukan absen!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
