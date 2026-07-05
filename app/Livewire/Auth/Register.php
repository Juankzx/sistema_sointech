<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'tecnico';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|string|in:admin,tecnico,recepcionista',
    ];

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        Auth::login($user);

        session()->flash('message', 'Cuenta creada exitosamente. ¡Bienvenido!');
        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.public');
    }
}
