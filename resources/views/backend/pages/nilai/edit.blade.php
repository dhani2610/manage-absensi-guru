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
        <form action="" method="get" class="form-jadwal">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="mt-2" for="jenis">Mata Pelajaran</label>
                                <select name="mapel" class="form-control" id="" required
                                    onchange="$('.form-jadwal').submit()">
                                    <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                    @foreach ($mapel as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $id_mapel == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_mapel }} |
                                            Kelas
                                            {{ $item->kelas->nama_kelas ?? '-' }}
                                            {{ $item->kelas->jenis_kelas ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($id_mapel != null)
            @if (!empty($siswa))
                <div class="row">
                    <form action="{{ route('nilai.siswa.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title text-center">Tambah</h4>
                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="id_mapel" value="{{ $id_mapel }}">
                                            <div class="form-group col-md-12">
                                                <label class="mt-2" for="jenis">Judul</label>
                                                <input type="text" class="form-control" value="{{ $data->judul }}" name="judul"
                                                    placeholder="Judul Nilai.." required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="mt-2" for="jenis">Tanggal</label>
                                                <input type="date" class="form-control" value="{{ $data->tanggal }}" name="tanggal" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <h4 class="header-title text-center">Daftar Siswa</h4>
                                        <hr>

                                        @include('backend.layouts.partials.messages')
                                        <table id="dataTable" class="table text-center">
                                            <thead class="bg-light text-capitalize">
                                                <tr>
                                                    <th>No</th>
                                                    <th>NISN</th>
                                                    <th style="width: 50%">Nama Siswa</th>
                                                    <th>Kelas</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($siswa as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->nisn }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>Kelas {{ $item->kelas->nama_kelas ?? '-' }}
                                                            {{ $item->kelas->jenis_kelas ?? '' }}</td>
                                                        <td>
                                                            @php
                                                                $detail = $data->nilaiSiswaDetail->where('id_siswa',$item->id)->first();
                                                            @endphp
                                                            <input type="hidden" name="id_siswa[]"
                                                                value="{{ $item->id }}">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">Aspek 1 (10%)</label>
                                                                        <input type="number"
                                                                            id="bobot-1-{{ $item->id }}"
                                                                            name="bobot_1[{{ $item->id }}]"
                                                                            value="{{ $detail->bobot_1 ?? '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">%</label>
                                                                        <input type="text"
                                                                            id="persentase-bobot-1-{{ $item->id }}"
                                                                            name="persentase_bobot_1[{{ $item->id }}]"
                                                                            value="{{ $detail->persentase_bobot_1 ?? '' }}"
                                                                            class="form-control mb-2" readonly>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">Aspek 2 (30%)</label>
                                                                        <input type="number"
                                                                            id="bobot-2-{{ $item->id }}"
                                                                            name="bobot_2[{{ $item->id }}]"
                                                                            value="{{ $detail->bobot_2 ?? '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">%</label>
                                                                        <input type="text"
                                                                            id="persentase-bobot-2-{{ $item->id }}"
                                                                            name="persentase_bobot_2[{{ $item->id }}]"
                                                                            value="{{ $detail->persentase_bobot_2 ?? '' }}"
                                                                            class="form-control mb-2" readonly>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">Aspek 3 (10%)</label>
                                                                        <input type="number"
                                                                            id="bobot-3-{{ $item->id }}"
                                                                            name="bobot_3[{{ $item->id }}]"
                                                                            value="{{ $detail->bobot_3 ?? '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">%</label>
                                                                        <input type="text"
                                                                            id="persentase-bobot-3-{{ $item->id }}"
                                                                            name="persentase_bobot_3[{{ $item->id }}]"
                                                                            value="{{ $detail->persentase_bobot_3 ?? '' }}"
                                                                            class="form-control mb-2" readonly>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">Aspek 4 (50%)</label>
                                                                        <input type="number"
                                                                            id="bobot-4-{{ $item->id }}"
                                                                            name="bobot_4[{{ $item->id }}]"
                                                                            value="{{ $detail->bobot_4 ?? '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="forn-group">
                                                                        <label for="">%</label>
                                                                        <input type="text"
                                                                            id="persentase-bobot-4-{{ $item->id }}"
                                                                            name="persentase_bobot_4[{{ $item->id }}]"
                                                                            value="{{ $detail->persentase_bobot_4 ?? '' }}"
                                                                            class="form-control mb-2" readonly>
                                                                    </div>
                                                                </div>

                                                                <div class="forn-group">
                                                                    <label for="">Total (%)</label>
                                                                    <input type="text"
                                                                        id="persentase-total-{{ $item->id }}"
                                                                        name="persentase_total[{{ $item->id }}]"
                                                                        value="{{ $detail->persentase_total ?? '' }}"
                                                                        class="form-control mb-2" readonly>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <button class="btn btn-primary mt-4 mb-4" style="float: right" type="submit">Simpan
                                        Data</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <center>
                    <h5 class="mt-4">Tidak ada data siswa!</h5>
                </center>
            @endif
        @else
            <center>
                <h5 class="mt-4">Pilih Jadwal Pelajaran terlebih dahulu!</h5>
            </center>
        @endif

    </div>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const siswaInputs = document.querySelectorAll('input[id^="bobot-"]');

            siswaInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const idParts = this.id.split('-');
                    const aspek = idParts[1]; // 1, 2, 3, atau 4
                    const siswaId = idParts[2]; // ID siswa

                    let bobotValue = parseInt(this.value) || 0;

                    // Validasi: nilai harus antara 0 dan 100
                    if (bobotValue < 0) {
                        bobotValue = 0;
                    } else if (bobotValue > 100) {
                        bobotValue = 100;
                    }
                    this.value = bobotValue; // Set ulang jika melebihi batas

                    // Bobot persentase untuk tiap aspek
                    const bobotPersen = {
                        1: 10,
                        2: 30,
                        3: 10,
                        4: 50
                    };
                    const persentase = Math.floor((bobotValue / 100) * bobotPersen[aspek]);

                    // Set nilai persentase aspek tanpa desimal
                    document.getElementById(`persentase-bobot-${aspek}-${siswaId}`).value =
                        persentase;

                    // Hitung total persentase
                    hitungTotalPersentase(siswaId);
                });
            });

            function hitungTotalPersentase(siswaId) {
                let total = 0;

                for (let i = 1; i <= 4; i++) {
                    const persentaseInput = document.getElementById(`persentase-bobot-${i}-${siswaId}`);
                    if (persentaseInput) {
                        const nilaiPersen = parseInt(persentaseInput.value) || 0;
                        total += nilaiPersen;
                    }
                }

                document.getElementById(`persentase-total-${siswaId}`).value = total;
            }
        });
    </script>
@endsection
