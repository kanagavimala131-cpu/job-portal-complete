<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PUBLIC ROUTES
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
    
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        
        $user = DB::table('login_credentials')->where('email', $request->email)->first();
        
        if($user) {
            $token = bin2hex(random_bytes(32));
            
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);
            
            return back()->with('success', 'Password reset link sent to your email!');
        }
        
        return back()->withErrors(['email' => 'Email not found in our records']);
    })->name('password.email');
});

// ==========================================
// AJAX ROUTES
// ==========================================
Route::prefix('ajax')->group(function () {
    Route::post('/login', [AjaxController::class, 'login'])->name('ajax.login');
    Route::post('/check-email', [AjaxController::class, 'checkEmail'])->name('ajax.check-email');
    Route::post('/check-password', [AjaxController::class, 'checkPasswordStrength'])->name('ajax.check-password');
});

// ==========================================
// PROTECTED ROUTES
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/shortlisted', [PageController::class, 'shortlisted'])->name('shortlisted');
    Route::get('/applied', [PageController::class, 'applied'])->name('applied');
    Route::get('/alerts', [PageController::class, 'alerts'])->name('alerts');
    Route::get('/cv', [PageController::class, 'cv'])->name('cv');
    Route::get('/change-password', [PageController::class, 'changePassword'])->name('change-password');
    
    Route::post('/password/update', [PageController::class, 'updatePassword'])->name('password.update');
    
    Route::post('/shortlist/add', [PageController::class, 'addToShortlist'])->name('shortlist.add');
    Route::delete('/shortlist/{id}', [PageController::class, 'removeFromShortlist'])->name('shortlist.remove');
    
    Route::post('/apply', [PageController::class, 'applyJob'])->name('job.apply');
    Route::delete('/application/{id}', [PageController::class, 'withdrawApplication'])->name('application.withdraw');
    
    Route::post('/alert/create', [PageController::class, 'createAlert'])->name('alert.create');
    Route::delete('/alert/{id}', [PageController::class, 'deleteAlert'])->name('alert.delete');
    Route::patch('/alert/{id}/toggle', [PageController::class, 'toggleAlert'])->name('alert.toggle');
    
    Route::post('/cv/upload', [PageController::class, 'uploadCV'])->name('cv.upload');
    Route::post('/cover-letter/upload', [PageController::class, 'uploadCoverLetter'])->name('coverletter.upload');
    Route::get('/cv/{id}/download', [PageController::class, 'downloadCV'])->name('cv.download');
    Route::delete('/cv/{id}', [PageController::class, 'deleteCV'])->name('cv.delete');
    Route::delete('/cover-letter/{id}', [PageController::class, 'deleteCoverLetter'])->name('coverletter.delete');
});

Route::fallback(function () {
    return redirect()->route('login');
});