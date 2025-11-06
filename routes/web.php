<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackOfficeController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

Route::middleware('auth')->group(function () {
    Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/carrinho/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    // Checkout (fake, but realistic)
    Route::get('/carrinho/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');
    Route::post('/carrinho/checkout', [CarrinhoController::class, 'placeOrder'])->name('carrinho.checkout.place');
    // Multibanco instructions page (requires signed URL so the page can't be accessed by guessing the id)
    Route::get('/carrinho/multibanco/{order}', [CarrinhoController::class, 'multibancoInstructions'])
        ->middleware('signed')
        ->name('carrinho.multibanco');
});

Route::get('/profile', function () {
    return view('profile.edit');
})->middleware('auth')->name('profile.edit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token, 'request' => request()]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/backoffice', [BackOfficeController::class, 'index'])->name('backoffice');
    Route::get('/backoffice/create', [BackOfficeController::class, 'create'])->name('backoffice.create');
    Route::post('/backoffice/store', [BackOfficeController::class, 'store'])->name('backoffice.store');
    Route::delete('/produtos/{produto}', [BackOfficeController::class, 'destroy'])->name('produtos.destroy');
});

// Orders (history)
Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth')->name('orders.index');
