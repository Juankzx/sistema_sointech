<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkOrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public WorkOrder $order;
    public string $newStatus;

    public function __construct(WorkOrder $order, string $newStatus)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
    }

    public function envelope(): Envelope
    {
        $code = substr($this->order->uuid, 0, 8);
        $settings = Setting::first();
        
        $subjectTemplate = $settings->email_ot_subject ?? '📌 Actualización de tu Orden de Trabajo #{codigo_ot} [{nuevo_estado}]';
        $clientName = $this->order->client ? $this->order->client->full_name : 'Cliente';
        $device = trim("{$this->order->device_brand} {$this->order->device_model}");
        $company = $settings->trade_name ?? 'Sointech';

        $subject = str_replace(
            ['{codigo_ot}', '{nuevo_estado}', '{nombre_cliente}', '{equipo}', '{nombre_empresa}'],
            [$code, $this->newStatus, $clientName, $device, $company],
            $subjectTemplate
        );

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $code = substr($this->order->uuid, 0, 8);
        $settings = Setting::first();
        $clientName = $this->order->client ? $this->order->client->full_name : 'Cliente';
        $device = trim("{$this->order->device_brand} {$this->order->device_model}");
        $company = $settings->trade_name ?? 'Sointech';
        $trackingUrl = route('work-orders.track', ['uuid' => $this->order->uuid]);

        $customBody = null;
        if (!empty($settings->email_ot_body)) {
            $customBody = str_replace(
                ['{codigo_ot}', '{nuevo_estado}', '{nombre_cliente}', '{equipo}', '{falla}', '{link_seguimiento}', '{nombre_empresa}'],
                [$code, $this->newStatus, $clientName, $device, $this->order->reported_issue, $trackingUrl, $company],
                $settings->email_ot_body
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
            view: 'emails.work-order-status-changed',
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
