<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Client;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $token;
    public ?Client $client;

    public function __construct(User $user, string $token, ?Client $client = null)
    {
        $this->user = $user;
        $this->token = $token;
        $this->client = $client;
    }

    public function envelope(): Envelope
    {
        $settings = Setting::first();
        $company = $settings->trade_name ?? 'Sointech';

        return new Envelope(
            subject: "✨ ¡Bienvenido a {$company}! Configura tu contraseña para acceder a tu Portal de Cliente",
        );
    }

    public function content(): Content
    {
        $settings = Setting::first();
        $company = $settings->trade_name ?? 'Sointech';
        $setupUrl = route('password.reset', ['token' => $this->token, 'email' => $this->user->email]);

        $logoUrl = null;
        if ($settings && $settings->logo_path) {
            $logoUrl = asset('storage/' . $settings->logo_path);
        } else {
            $logoUrl = asset('images/logo-dark.png');
        }

        return new Content(
            view: 'emails.client-welcome',
            with: [
                'user' => $this->user,
                'client' => $this->client,
                'setupUrl' => $setupUrl,
                'company' => $company,
                'settings' => $settings,
                'logoUrl' => $logoUrl,
            ]
        );
    }
}
