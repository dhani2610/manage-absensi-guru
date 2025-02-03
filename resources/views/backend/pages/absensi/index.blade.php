@extends('backend.layouts-new.app')

@section('title')
    Dashboard Page - Admin Panel
@endsection


@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    @php
        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
    @endphp
    @if ($userRole != 'superadmin')
        <form action="{{ route('absensi.store') }}">
            @csrf
            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div id="container">
                                @include('backend.layouts.partials.messages')
                                <div class=" d-flex align-items-center flex-column">
                                    <h6 id="date_day"></h6>
                                    <h4 class="font-weight-bold" id="clock"></h4>
                                    <div id="my_camera"></div>
                                    <div id="results"></div>
                                    <div class="d-flex mt-2 gap-2">
                                        <button id="take_in" type="button" class="btn btn-primary btn-block btn-sm">Take
                                            Foto</button>
                                        <button id="ulangi" type="button" class="btn btn-secondary btn-sm">Change
                                            Foto</button>
                                    </div>
                                    <input type="hidden" name="image" class="image-absen">

                                    <div class="user-info text-center mt-2">
                                        <h4 class="mb-2">{{ Auth::guard('admin')->user()->name }}</h4>
                                    </div>
                                    <div class="form-group mb-2 mt-2">
                                        <select name="id_jadwal" class="form-control" id="" required>
                                            <option value="" selected disabled>Pilih Absen Mata Pelajaran</option>
                                            @foreach ($jadwal as $item)
                                                <option value="{{ $item->id }}" data-jam-mulai="{{ $item->jam_mulai }}"
                                                    data-jam-akhir="{{ $item->jam_akhir }}">{{ $item->mapel->nama_mapel }} |
                                                    Kelas
                                                    {{ $item->mapel->kelas->nama_kelas ?? '-' }}
                                                    {{ $item->mapel->kelas->jenis_kelas ?? '-' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" id="submit"
                                        class="btn-attendance btn btn-primary btn-block d-none">Submit Absen</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif



    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div id="container">
                        <h5>Data Absensi</h5>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="table text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Guru</th>
                                        <th>Jadwal</th>
                                        <th>Jam Absen</th>
                                        <th>Tanggal</th>
                                        <th>Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($data) --}}
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->user->name ?? '' }}</td>
                                            <td style="text-align: left">{{ $item->jadwal->mapel->nama_mapel ?? '' }} <br>
                                                Kelas
                                                {{ $item->jadwal->mapel->kelas->nama_kelas . ' ' . $item->jadwal->mapel->kelas->jenis_kelas . ' (' . $item->jadwal->jam_mulai . ' s/d ' . $item->jadwal->jam_akhir . ')' }}
                                            </td>
                                            <td>{{ $item->waktu_absen }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>
                                                <a href="{{ asset('assets/img/absensi/' . $item->image) }}" download>
                                                    <img src="{{ asset('assets/img/absensi/' . $item->image) }}"
                                                        style="max-width: 200px" alt="">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


    <script>
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen select untuk mata pelajaran
            const selectMapel = document.querySelector('select[name="id_jadwal"]');
            const clockButton = document.getElementById("submit");
            const dateElement = document.getElementById("date_day");

            // Event saat pilihan mata pelajaran berubah
            selectMapel.addEventListener("change", function() {
                const selectedOption = selectMapel.options[selectMapel.selectedIndex];
                const jamMulai = selectedOption.getAttribute("data-jam-mulai");
                const jamAkhir = selectedOption.getAttribute("data-jam-akhir");

                // Pastikan jamMulai dan jamAkhir tidak kosong
                if (jamMulai && jamAkhir) {
                    const now = new Date();
                    const currentHour = now.getHours();
                    const currentMinute = now.getMinutes();

                    // Parsing jam mulai dan jam akhir dengan validasi format
                    const [startHour, startMinute] = jamMulai.split(":").map(Number);
                    const [endHour, endMinute] = jamAkhir.split(":").map(Number);

                    // Mengecek apakah waktu sekarang berada dalam periode yang ditentukan
                    if ((currentHour > startHour || (currentHour === startHour && currentMinute >=
                            startMinute)) &&
                        (currentHour < endHour || (currentHour === endHour && currentMinute <= endMinute))
                    ) {
                        clockButton.classList.remove("d-none");
                    } else {
                        clockButton.classList.add("d-none");
                        alert(`Anda hanya bisa Absen antara jam ${jamMulai} hingga ${jamAkhir}`);
                    }
                } else {
                    alert("Jam mulai dan jam akhir tidak tersedia.");
                }
            });
        });


        // CSRF TOKEN
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // take snapshot

        @if ($userRole != 'superadmin')
          $('#ulangi').hide();
          try {
              // Memeriksa izin akses webcam sebelum melanjutkan
              navigator.mediaDevices.getUserMedia({
                      video: true
                  })
                  .then(function(stream) {
                      // Jika izin diberikan, setup webcam
                      Webcam.set({
                          width: 300,
                          height: 260,
                          image_format: 'jpeg',
                          jpeg_quality: 90,
                      });
                      Webcam.attach('#my_camera');
                  })
                  .catch(function(error) {
                      if (error.name === "NotAllowedError" || error.name === "PermissionDeniedError") {
                          alert("Akses ke webcam ditolak. Pastikan Anda memberikan izin akses.");
                      } else {
                          alert("Terjadi kesalahan saat mengakses webcam: " + error.message);
                      }
                      console.error("Webcam error:", error);
                  });
          } catch (error) {
              console.error("Unexpected error:", error);
              alert("Terjadi kesalahan yang tidak terduga.");
          }

          $('form').on('submit', async function(e) {
              if ($('.image-absen').val() === '') {
                  alert('Take Foto terlebih dahulu!');
                  e.preventDefault(); // Cegah pengiriman form jika gambar tidak ada
              }
          });
        @endif



        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                console.log(data_uri);
                $(".image-absen").val(data_uri);
                document.getElementById('results').innerHTML = '<img class="img-fluid" src="' + data_uri + '"/>';
                $('#my_camera').hide();
                $('#ulangi').show();
            });
        }
        $('#ulangi').on('click', function(e) {
            $('#results').html('');
            $('#my_camera').show();
            $('#ulangi').hide();
            $('.image-absen').val('');
        })
        $('#take_in').on('click', function(e) {
            take_snapshot();
        })

        function showTime() {
            var a_p = "";
            var today = new Date();
            var week = new Array(
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu"
            );
            const monthNames = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            var day = week[today.getDay()];
            var date = today.getDate();
            var month = monthNames[today.getMonth()];
            var year = today.getUTCFullYear();
            var curr_hour = today.getHours();
            var curr_minute = today.getMinutes();
            var curr_second = today.getSeconds();
            if (curr_hour < 12) {
                a_p = "AM";
            } else {
                a_p = "PM";
            }
            if (curr_hour == 0) {
                curr_hour = 12;
            }
            if (curr_hour > 12) {
                curr_hour = curr_hour - 12;
            }
            curr_hour = checkTime(curr_hour);
            curr_minute = checkTime(curr_minute);
            curr_second = checkTime(curr_second);
            document.getElementById('date_day').innerHTML = day + ", " + date + " " + month + " " + year;
            document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        setInterval(showTime, 500);
        //-->
    </script>
@endsection
@push('dashboard')
