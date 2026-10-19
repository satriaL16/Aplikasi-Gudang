<?php

use App\Http\Controllers\BarangExportController;
use App\Http\Controllers\KategoriExportController;
use App\Http\Controllers\UserExportController;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(Auth::check() ? 'dashboard' : 'login'));
Route::view('/login', 'auth.login')->middleware('guest')->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::middleware('can:access-barang-export')->group(function (): void {
        Route::get('/barang/export/pdf', [BarangExportController::class, 'pdf'])->name('barang.export.pdf');
        Route::get('/barang/export/excel', [BarangExportController::class, 'excel'])->name('barang.export.excel');
    });

    Route::get('/dashboard', function (Request $request) {
        if ($request->user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        abort_unless($request->user()->role === 'Super Admin', 403);

        return view('dashboard', [
            'totalBarang' => Barang::query()->count(),
            'totalUser' => User::query()->count(),
            'totalKategori' => Kategori::query()->count(),
        ]);
    })->name('dashboard');

    Route::middleware('can:access-superadmin')->group(function (): void {
        Route::get('/superadmin/user/export/pdf', [UserExportController::class, 'pdf'])->name('superadmin.user.export.pdf');
        Route::get('/superadmin/user/export/excel', [UserExportController::class, 'excel'])->name('superadmin.user.export.excel');
        Route::get('/superadmin/kategori/export/pdf', [KategoriExportController::class, 'pdf'])->name('superadmin.kategori.export.pdf');
        Route::get('/superadmin/kategori/export/excel', [KategoriExportController::class, 'excel'])->name('superadmin.kategori.export.excel');
        Route::view('/superadmin/user/index', 'superadmin.user.index')->name('superadmin.user.index');
        Route::view('/superadmin/kategori/index', 'superadmin.kategori.index')->name('superadmin.kategori.index');
        Route::view('/superadmin/barang/index', 'superadmin.barang.index')->name('superadmin.barang.index');
    });

    Route::middleware('can:access-admin')->group(function (): void {
        Route::get('/admin/dashboard', fn () => view('admin.dashboard', [
            'totalBarang' => Barang::query()->count(),
        ]))->name('admin.dashboard');
        Route::view('/admin/barang/index', 'admin.barang.index')->name('admin.barang.index');
    });
});
