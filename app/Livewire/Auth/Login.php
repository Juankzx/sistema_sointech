<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|string',
    ];

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
    }

    public function login()
    {
        $this->validate();

        $ipThrottleKey = 'login-ip|' . request()->ip();
        $emailThrottleKey = 'login-email|' . strtolower($this->email) . '|' . request()->ip();

        // 1. Bloqueo global por IP (máximo 15 intentos fallidos por minuto desde la misma IP)
        if (RateLimiter::tooManyAttempts($ipThrottleKey, 15)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);
            \Illuminate\Support\Facades\Log::warning("⚠️ Posible ataque de fuerza bruta bloqueado desde la IP " . request()->ip());
            throw ValidationException::withMessages([
                'email' => "⚠️ Por motivos de seguridad, los accesos desde tu dirección IP se han pausado temporalmente. Reintenta en {$seconds} segundos.",
            ]);
        }

        // 2. Bloqueo específico por correo/cuenta (máximo 5 intentos por cuenta/IP)
        if (RateLimiter::tooManyAttempts($emailThrottleKey, 5)) {
            $seconds = RateLimiter::availableIn($emailThrottleKey);
            throw ValidationException::withMessages([
                'email' => "⚠️ Demasiados intentos fallidos. Por seguridad, la cuenta ha sido protegida. Intenta nuevamente en {$seconds} segundos.",
            ]);
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($emailThrottleKey, 60);
            RateLimiter::hit($ipThrottleKey, 60);

            throw ValidationException::withMessages([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }

        RateLimiter::clear($emailThrottleKey);
        RateLimiter::clear($ipThrottleKey);
        session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.public');
    }
}
