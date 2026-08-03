<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPassword extends Component
{
    public string $email = '';

    protected array $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected array $messages = [
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El formato del correo electrónico no es válido.',
        'email.exists' => 'No encontramos ningún usuario registrado con este correo electrónico.',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $throttleKey = 'forgot-password|' . request()->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $this->addError('email', "⚠️ Has realizado demasiadas solicitudes de recuperación. Por seguridad, intentalo de nuevo en {$seconds} segundos.");
            return;
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 300);

        try {
            $status = Password::broker()->sendResetLink(
                ['email' => $this->email]
            );

            if ($status === Password::RESET_LINK_SENT) {
                session()->flash('status', '¡Te hemos enviado un correo con el enlace para configurar/restablecer tu contraseña!');
                $this->email = '';
            } else {
                $this->addError('email', 'No pudimos enviar el correo de restablecimiento. Por favor verifica tus credenciales.');
            }
        } catch (\Exception $e) {
            Log::error("Error enviando correo de restablecimiento: " . $e->getMessage());
            
            // In a local environment, SMTP might not be configured.
            // We give a friendly, detailed advice so the user is not blocked.
            $this->addError('email', 'El servidor de correo no está disponible en este momento. Si estás en un entorno local (XAMPP), puedes configurar tu contraseña directamente a través del módulo de "Usuarios" del administrador o contactar a soporte.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.public');
    }
}
