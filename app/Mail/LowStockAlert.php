<?php

namespace App\Mail;

use App\Models\Inventory;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Inventory $item;

    public function __construct(Inventory $item)
    {
        $this->item = $item;
    }

    public function envelope(): Envelope
    {
        $settings = Setting::first();
        $subjectTemplate = $settings->email_low_stock_subject ?? '⚠️ Alerta de Inventario: Stock Bajo en [{producto}]';
        $company = $settings->trade_name ?? 'Sointech';

        $subject = str_replace(
            ['{producto}', '{stock_actual}', '{stock_minimo}', '{nombre_empresa}'],
            [$this->item->name, $this->item->stock, $this->item->min_stock, $company],
            $subjectTemplate
        );

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $settings = Setting::first();
        $company = $settings->trade_name ?? 'Sointech';

        $customBody = null;
        if (!empty($settings->email_low_stock_body)) {
            $customBody = str_replace(
                ['{producto}', '{stock_actual}', '{stock_minimo}', '{nombre_empresa}'],
                [$this->item->name, $this->item->stock, $this->item->min_stock, $company],
                $settings->email_low_stock_body
            );
        }

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
            view: 'emails.low-stock-alert',
            with: [
                'customBody' => $customBody,
                'settings'   => $settings,
                'logoPath'   => $logoPath,
                'logoUrl'    => $logoUrl,
                'company'    => $company,
            ]
        );
    }
}
