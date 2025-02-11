<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/register', 'BerandaController@register')->name('admin-register');
Route::post('/admin/register/store', 'BerandaController@registerStore')->name('admin-register-store');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');


    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', 'Backend\KelasController@index')->name('kelas');
        Route::get('create', 'Backend\KelasController@create')->name('kelas.create');
        Route::post('store', 'Backend\KelasController@store')->name('kelas.store');
        Route::get('edit/{id}', 'Backend\KelasController@edit')->name('kelas.edit');
        Route::post('update/{id}', 'Backend\KelasController@update')->name('kelas.update');
        Route::get('destroy/{id}', 'Backend\KelasController@destroy')->name('kelas.destroy');
    });

    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', 'Backend\SiswaController@index')->name('siswa');
        Route::get('create', 'Backend\SiswaController@create')->name('siswa.create');
        Route::post('store', 'Backend\SiswaController@store')->name('siswa.store');
        Route::get('edit/{id}', 'Backend\SiswaController@edit')->name('siswa.edit');
        Route::post('update/{id}', 'Backend\SiswaController@update')->name('siswa.update');
        Route::get('destroy/{id}', 'Backend\SiswaController@destroy')->name('siswa.destroy');
    });
    Route::group(['prefix' => 'guru'], function () {
        Route::get('/', 'Backend\GuruController@index')->name('guru');
        Route::get('create', 'Backend\GuruController@create')->name('guru.create');
        Route::post('store', 'Backend\GuruController@store')->name('guru.store');
        Route::get('edit/{id}', 'Backend\GuruController@edit')->name('guru.edit');
        Route::post('update/{id}', 'Backend\GuruController@update')->name('guru.update');
        Route::get('destroy/{id}', 'Backend\GuruController@destroy')->name('guru.destroy');
    });
    
    Route::group(['prefix' => 'mata-pelajaran'], function () {
        Route::get('/', 'Backend\MataPelajaranController@index')->name('mata.pelajaran');
        Route::get('create', 'Backend\MataPelajaranController@create')->name('mata.pelajaran.create');
        Route::post('store', 'Backend\MataPelajaranController@store')->name('mata.pelajaran.store');
        Route::get('edit/{id}', 'Backend\MataPelajaranController@edit')->name('mata.pelajaran.edit');
        Route::post('update/{id}', 'Backend\MataPelajaranController@update')->name('mata.pelajaran.update');
        Route::get('destroy/{id}', 'Backend\MataPelajaranController@destroy')->name('mata.pelajaran.destroy');
    });

    Route::group(['prefix' => 'jadwal'], function () {
        Route::get('/', 'Backend\JadwalController@index')->name('jadwal');
        Route::get('create', 'Backend\JadwalController@create')->name('jadwal.create');
        Route::post('store', 'Backend\JadwalController@store')->name('jadwal.store');
        Route::get('edit/{id}', 'Backend\JadwalController@edit')->name('jadwal.edit');
        Route::post('update/{id}', 'Backend\JadwalController@update')->name('jadwal.update');
        Route::get('destroy/{id}', 'Backend\JadwalController@destroy')->name('jadwal.destroy');
    });

    Route::group(['prefix' => 'catatan'], function () {
        Route::get('/', 'Backend\CatatanController@index')->name('catatan');
        Route::get('create', 'Backend\CatatanController@create')->name('catatan.create');
        Route::post('store', 'Backend\CatatanController@store')->name('catatan.store');
        Route::get('edit/{id}', 'Backend\CatatanController@edit')->name('catatan.edit');
        Route::post('update/{id}', 'Backend\CatatanController@update')->name('catatan.update');
        Route::get('destroy/{id}', 'Backend\CatatanController@destroy')->name('catatan.destroy');
    });

    Route::group(['prefix' => 'nilai-siswa'], function () {
        Route::get('/', 'Backend\NilaiSiswaController@index')->name('nilai.siswa');
        Route::get('create', 'Backend\NilaiSiswaController@create')->name('nilai.siswa.create');
        Route::post('store', 'Backend\NilaiSiswaController@store')->name('nilai.siswa.store');
        Route::get('edit/{id}', 'Backend\NilaiSiswaController@edit')->name('nilai.siswa.edit');
        Route::post('update/{id}', 'Backend\NilaiSiswaController@update')->name('nilai.siswa.update');
        Route::get('destroy/{id}', 'Backend\NilaiSiswaController@destroy')->name('nilai.siswa.destroy');
    });

    Route::group(['prefix' => 'absensi'], function () {
        Route::get('/', 'Backend\AbsensiController@index')->name('absensi');
        Route::get('/store', 'Backend\AbsensiController@store')->name('absensi.store');
    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Backend\ProfileController@index')->name('profile');
        Route::post('/profile/update', 'Backend\ProfileController@update')->name('profile.update');
        Route::get('/change-password', 'Backend\ProfileController@changePassword')->name('profile.change-password');
        Route::post('/proses-change-password', 'Backend\ProfileController@changePasswordProses')->name('profile.proses-change-password');
    });

});
