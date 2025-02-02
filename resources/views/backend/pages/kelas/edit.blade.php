@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important;
        }

        label {
            float: left;
            color: black;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
    </style>

    <div class="main-content-inner">
        <div class="row">
            <form action="{{ route('kelas.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Edit</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Nama Kelas</label>
                                        <select name="nama_kelas" class="form-control" id="">
                                            <option value="" selected disabled>Pilih Kelas</option>
                                            @php
                                                $rangeKelas = range(1,6);
                                            @endphp
                                            @foreach ($rangeKelas as $item)
                                                <option value="{{ $item }}" {{ $item == $data->nama_kelas ? 'selected' : '' }} >Kelas {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Jenis Kelas</label>
                                        <select name="jenis_kelas" class="form-control" id="jenis_kelas">
                                            <option value="" selected disabled>Pilih Jenis Kelas</option>
                                            @php
                                                $jenisKelas = ['A', 'B', 'C', 'D', 'E'];
                                            @endphp
                                            @foreach ($jenisKelas as $item)
                                                <option value="{{ $item }}" {{ $item == $data->jenis_kelas ? 'selected' : '' }} >{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary mt-4" type="submit">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
