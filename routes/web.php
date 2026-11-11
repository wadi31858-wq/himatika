<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
Route::get('/sejarah', [ProfileController::class, 'sejarah'])->name('sejarah');
Route::get('/sambutan', [ProfileController::class, 'sambutan'])->name('sambutan');
Route::get('/visi-misi', [VisionMissionController::class, 'index'])->name('visi-misi');
Route::get('/struktur-organisasi', [OrganizationController::class, 'index'])->name('struktur-organisasi');
Route::get('/struktur-organisasi/{id}', [OrganizationController::class, 'show'])->name('struktur-organisasi.show');
Route::get('/pengurus', [MemberController::class, 'index'])->name('pengurus');
Route::get('/program-kerja', [ProgramController::class, 'index'])->name('program-kerja');
Route::get('/kegiatan', [ActivityController::class, 'index'])->name('kegiatan');
Route::get('/kegiatan/{slug}', [ActivityController::class, 'show'])->name('kegiatan.show');
Route::get('/berita', [NewsController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/prestasi', [AchievementController::class, 'index'])->name('prestasi');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
Route::get('/galeri/{id}', [GalleryController::class, 'show'])->name('galeri.show');
Route::get('/download', [DownloadController::class, 'index'])->name('download');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');

Route::get('/pendaftaran', [\App\Http\Controllers\RegistrationController::class, 'index'])->name('pendaftaran.index');
Route::post('/pendaftaran', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/cek', [\App\Http\Controllers\RegistrationController::class, 'cek'])->name('pendaftaran.cek');

Route::get('/aspirasi', [\App\Http\Controllers\AspirationController::class, 'index'])->name('aspirasi.index');
Route::post('/aspirasi', [\App\Http\Controllers\AspirationController::class, 'store'])->name('aspirasi.store');
Route::get('/aspirasi/cek', [\App\Http\Controllers\AspirationController::class, 'cek'])->name('aspirasi.cek');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/beranda', [\App\Http\Controllers\Admin\AdminHomeController::class, 'edit'])->name('beranda.edit');
    Route::put('/beranda', [\App\Http\Controllers\Admin\AdminHomeController::class, 'update'])->name('beranda.update');

    Route::get('/pengaturan', [\App\Http\Controllers\Admin\AdminSettingController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [\App\Http\Controllers\Admin\AdminSettingController::class, 'update'])->name('pengaturan.update');

    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);

    Route::get('/logs', [\App\Http\Controllers\Admin\AdminLogController::class, 'index'])->name('logs.index');

    Route::get('/profil', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profil.update');

    Route::get('/visi-misi', [\App\Http\Controllers\Admin\AdminVisionMissionController::class, 'edit'])->name('visi-misi.edit');
    Route::put('/visi-misi', [\App\Http\Controllers\Admin\AdminVisionMissionController::class, 'update'])->name('visi-misi.update');

    Route::resource('struktur-organisasi', \App\Http\Controllers\Admin\AdminOrganizationController::class)->except(['show'])->parameters(['struktur-organisasi' => 'struktur']);
    Route::resource('pengurus', \App\Http\Controllers\Admin\AdminMemberController::class)->except(['show'])->parameters(['pengurus' => 'penguru']);
    Route::resource('program-kerja', \App\Http\Controllers\Admin\AdminProgramController::class)->except(['show'])->parameters(['program-kerja' => 'program']);
    Route::resource('kegiatan', \App\Http\Controllers\Admin\AdminActivityController::class)->except(['show'])->parameters(['kegiatan' => 'kegiatan']);
    Route::resource('berita', \App\Http\Controllers\Admin\AdminNewsController::class)->except(['show'])->parameters(['berita' => 'berita']);
    Route::resource('agenda', \App\Http\Controllers\Admin\AdminAgendaController::class)->except(['show']);
    Route::resource('prestasi', \App\Http\Controllers\Admin\AdminAchievementController::class)->except(['show'])->parameters(['prestasi' => 'prestasi']);
    Route::resource('galeri', \App\Http\Controllers\Admin\AdminGalleryController::class)->except(['show'])->parameters(['galeri' => 'galeri']);
    Route::resource('download', \App\Http\Controllers\Admin\AdminDownloadController::class)->except(['show']);

    Route::get('/pesan', [\App\Http\Controllers\Admin\AdminMessageController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [\App\Http\Controllers\Admin\AdminMessageController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [\App\Http\Controllers\Admin\AdminMessageController::class, 'destroy'])->name('pesan.destroy');

    Route::get('/pendaftaran', [\App\Http\Controllers\Admin\AdminRegistrationController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\AdminRegistrationController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\AdminRegistrationController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\AdminRegistrationController::class, 'destroy'])->name('pendaftaran.destroy');

    Route::get('/aspirasi', [\App\Http\Controllers\Admin\AdminAspirationController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{aspirasi}', [\App\Http\Controllers\Admin\AdminAspirationController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{aspirasi}', [\App\Http\Controllers\Admin\AdminAspirationController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{aspirasi}', [\App\Http\Controllers\Admin\AdminAspirationController::class, 'destroy'])->name('aspirasi.destroy');
});
