<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * Configura el driver de correo dinámicamente usando los datos SMTP guardados en la BD.
     *
     * @return bool Retorna true si hay un servidor SMTP configurado.
     */
    public static function configureSmtp(): bool
    {
        try {
            $settings = Setting::find(1);

            if ($settings && !empty($settings->smtp_host)) {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', trim($settings->smtp_host));
                Config::set('mail.mailers.smtp.port', (int)($settings->smtp_port ?? 587));
                Config::set('mail.mailers.smtp.username', trim($settings->smtp_username));
                Config::set('mail.mailers.smtp.password', trim($settings->smtp_password));
                Config::set('mail.mailers.smtp.encryption', strtolower(trim($settings->smtp_encryption ?: 'tls')));

                $fromAddress = $settings->smtp_from_address ?: ($settings->support_email ?: 'contacto@sointech.cl');
                $fromName = $settings->smtp_from_name ?: ($settings->trade_name ?: ($settings->company_name ?: 'Soin Technology'));

                Config::set('mail.from.address', $fromAddress);
                Config::set('mail.from.name', $fromName);

                return true;
            }
        } catch (\Exception $e) {
            Log::error("Error al cargar configuración SMTP desde la BD: " . $e->getMessage());
        }

        return false;
    }
}
