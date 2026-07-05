<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $guarded = [];

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    protected static function booted()
    {
        static::saved(function ($client) {
            if (!empty($client->email)) {
                // Ensure User profile exists for this client email
                $existingUser = \App\Models\User::where('email', $client->email)->first();
                if (!$existingUser) {
                    $user = \App\Models\User::create([
                        'name' => $client->full_name,
                        'email' => $client->email,
                        'role' => 'cliente',
                        'client_id' => $client->id,
                        'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                    ]);

                    // Try to send password setup/reset email securely
                    try {
                        $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
                        $user->sendPasswordResetNotification($token);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning("No se pudo enviar correo de bienvenida al cliente: " . $e->getMessage());
                    }
                } else {
                    // Update client_id on the existing user if it's not set
                    if ($existingUser->role === 'cliente' && empty($existingUser->client_id)) {
                        $existingUser->update(['client_id' => $client->id]);
                    }
                }
            }
        });
    }
}
