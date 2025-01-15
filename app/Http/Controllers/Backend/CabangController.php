<?php

namespace App\Http\Controllers\Backend;

use App\Models\Cabang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangController extends Controller
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
        $data['page_title'] = 'Cabang';

        $data['data'] = Cabang::orderBy('created_at', 'desc')->get();

        return view('backend.pages.cabang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Data Cabang';
        return view('backend.pages.cabang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new Cabang();
            $data->cabang = $request->cabang;
            $data->deskripsi = $request->deskripsi;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('cabang');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('cabang');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $cabang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['page_title'] = 'Tambah Data Cabang';
        $data['cabang'] = Cabang::find($id);

        return view('backend.pages.cabang.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Cabang::find($id);
            $data->cabang = $request->cabang;
            $data->deskripsi = $request->deskripsi;
            $data->save();

            session()->flash('success', 'Data Berhasil Disimpan!');
            return redirect()->route('cabang');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('cabang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Cabang::find($id);
            $data->delete();

            session()->flash('success', 'Data Berhasil Dihapus!');
            return redirect()->route('cabang');
        } catch (\Throwable $th) {

            session()->flash('failed', $th->getMessage());
            return redirect()->route('cabang');
        }
    }
}
