<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $recipientEmail;

    public function __construct(string $recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;
    }

    public function envelope(): Envelope
    {
        $settings = Setting::first();
        $company = $settings->trade_name ?? 'Sointech';

        return new Envelope(
            subject: "✅ Verificación Exitosa de Servidor de Correo - {$company}",
        );
    }

    public function content(): Content
    {
        $settings = Setting::first();
        $company = $settings->trade_name ?? 'Sointech';

        $logoPath = null;
        if ($settings && $settings->logo_path && file_exists(storage_path('app/public/' . $settings->logo_path))) {
            $logoPath = storage_path('app/public/' . $settings->logo_path);
        } elseif (file_exists(public_path('images/logo-dark.png'))) {
            $logoPath = public_path('images/logo-dark.png');
        }

        $logoUrl = null;
        if ($settings && $settings->logo_path) {
            $logoUrl = asset('storage/' . $settings->logo_path);
        } else {
            $logoUrl = asset('images/logo-dark.png');
        }

        return new Content(
            view: 'emails.test-mail',
            with: [
                'settings' => $settings,
                'logoPath' => $logoPath,
                'logoUrl'  => $logoUrl,
                'company'  => $company,
            ]
        );
    }
}
