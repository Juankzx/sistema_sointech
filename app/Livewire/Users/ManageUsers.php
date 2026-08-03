<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends Component
{
    public string $search = '';
    
    // Modal states and form fields
    public bool $showModal = false;
    public ?int $editingUserId = null;
    
    // Reset Password Modal
    public bool $showResetModal = false;
    public ?int $resetUserId = null;
    public string $resetUserEmail = '';
    public string $resetUserName = '';
    public string $newPassword = '';
    
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'tecnico';
    public ?int $client_id = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->editingUserId,
            'password' => $this->editingUserId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,tecnico,recepcionista,cliente',
            'client_id' => 'required_if:role,cliente|nullable|exists:clients,id',
        ];
    }

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['editingUserId', 'name', 'email', 'password', 'role', 'client_id']);
        $this->showModal = true;
    }

    public function openResetPasswordModal(User $user)
    {
        $this->resetErrorBag();
        $this->resetUserId = $user->id;
        $this->resetUserEmail = $user->email;
        $this->resetUserName = $user->name;
        $this->newPassword = '';
        $this->showResetModal = true;
    }

    public function generateRandomPassword()
    {
        $this->newPassword = \Illuminate\Support\Str::random(10);
    }

    public function saveNewPassword()
    {
        $this->validate([
            'newPassword' => 'required|string|min:6',
        ], [
            'newPassword.required' => 'La nueva contraseña es obligatoria.',
            'newPassword.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::findOrFail($this->resetUserId);
        $user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        session()->flash('message', "🔑 Contraseña actualizada exitosamente para el usuario '{$user->name}'. Nueva clave: {$this->newPassword}");
        $this->showResetModal = false;
    }

    public function sendPasswordResetLink(User $user)
    {
        try {
            \App\Services\MailService::configureSmtp();
            $status = \Illuminate\Support\Facades\Password::broker()->sendResetLink(['email' => $user->email]);

            if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
                session()->flash('message', "✉️ Se ha enviado exitosamente el enlace de restablecimiento al correo: {$user->email}");
            } else {
                session()->flash('error', "⚠️ No se pudo enviar el enlace al correo {$user->email}. Verifica que el usuario exista o la configuración SMTP.");
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error enviando enlace de reset a {$user->email}: " . $e->getMessage());
            session()->flash('error', "❌ Error enviando correo: " . $e->getMessage());
        }
    }

    public function editUser(User $user)
    {
        $this->resetErrorBag();
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Don't show password
        $this->role = $user->role;
        $this->client_id = $user->client_id;
        $this->showModal = true;
    }

    public function saveUser()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'client_id' => $this->role === 'cliente' ? $this->client_id : null,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingUserId) {
            User::findOrFail($this->editingUserId)->update($data);
            session()->flash('message', "El usuario '{$this->name}' se ha actualizado exitosamente.");
        } else {
            User::create($data);
            session()->flash('message', "El usuario '{$this->name}' se ha creado exitosamente.");
        }

        $this->showModal = false;
    }

    public function render()
    {
        $query = User::with('client')->orderBy('name', 'asc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->get();
        $clients = Client::orderBy('full_name')->get();

        return view('livewire.users.manage-users', [
            'users' => $users,
            'clients' => $clients,
        ])->layout('layouts.app');
    }
}
