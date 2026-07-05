<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected array $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ];

    protected array $messages = [
        'token.required' => 'El token es obligatorio.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El formato del correo electrónico no es válido.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'password.confirmed' => 'La confirmación de la contraseña no coincide.',
    ];

    public function mount(string $token)
    {
        $this->token = $token;
        // Pre-fill email from URL if provided by Laravel reset link
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate();

        try {
            $status = Password::broker()->reset(
                [
                    'token' => $this->token,
                    'email' => $this->email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                ],
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->save();

                    Auth::login($user);
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                session()->flash('message', '¡Tu contraseña ha sido configurada y guardada exitosamente! Ya has iniciado sesión en el sistema.');
                return redirect()->to('/');
            } else {
                $this->addError('email', __($status));
            }
        } catch (\Exception $e) {
            Log::error("Error en restablecimiento de contraseña: " . $e->getMessage());
            $this->addError('email', 'Ocurrió un error inesperado al procesar tu solicitud. Por favor inténtalo de nuevo.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.public');
    }
}
