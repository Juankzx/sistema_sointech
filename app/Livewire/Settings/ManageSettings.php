<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Setting;
use App\Models\DeviceCatalog;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ManageSettings extends Component
{
    use WithPagination, WithFileUploads;

    // General settings
    public $warranty_text;
    public $checklist_templates = [];
    public $selected_category = 'smartphone';
    public $new_checklist_item = '';

    // Catalog settings
    public $catalog_category = 'smartphone';
    public $new_brand = '';
    public $new_model = '';
    public $catalog_search = '';

    // Company & SII settings
    public $company_name;
    public $trade_name;
    public $company_rut;
    public $company_giro;
    public $company_activity_code;
    public $company_address;
    public $company_phone;
    public $sii_api_key;
    public $sii_environment = 'certificacion';
    
    // Personalization & Regional
    public $currency = 'CLP';
    public $tax_rate = 19;
    public $timezone = 'America/Santiago';
    public $support_email;
    public $support_whatsapp;
    public $social_instagram;
    public $social_facebook;
    
    // File uploads
    public $logo_path;
    public $new_logo;
    public $favicon_path;
    public $new_favicon;

    // SMTP & Email Notification Settings
    public $smtp_host;
    public $smtp_port = 587;
    public $smtp_username;
    public $smtp_password;
    public $smtp_encryption = 'tls';
    public $smtp_from_address;
    public $smtp_from_name;
    public $notify_on_ot_status = true;
    public $notify_on_low_stock = true;
    public $test_email_recipient = '';

    // Email Templates Settings
    public $email_ot_subject;
    public $email_ot_body;
    public $email_low_stock_subject;
    public $email_low_stock_body;

    // WhatsApp Meta Cloud API Settings
    public $whatsapp_enabled = false;
    public $whatsapp_phone_number_id = '';
    public $whatsapp_business_account_id = '';
    public $whatsapp_access_token = '';
    public $whatsapp_template_name = 'ot_status_update';
    public $test_whatsapp_recipient = '';

    public $activeTab = 'general';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $settings = Setting::firstOrCreate(['id' => 1]);
        if ($settings) {
            $this->warranty_text = $settings->warranty_text;
            $this->checklist_templates = $settings->checklist_templates ?? [];
            
            $this->company_name = $settings->company_name;
            $this->trade_name = $settings->trade_name;
            $this->company_rut = $settings->company_rut;
            $this->company_giro = $settings->company_giro;
            $this->company_activity_code = $settings->company_activity_code;
            $this->company_address = $settings->company_address;
            $this->company_phone = $settings->company_phone;
            $this->sii_api_key = $settings->sii_api_key;
            $this->sii_environment = $settings->sii_environment ?? 'certificacion';
            
            $this->currency = $settings->currency ?? 'CLP';
            $this->tax_rate = $settings->tax_rate ?? 19;
            $this->timezone = $settings->timezone ?? 'America/Santiago';
            $this->support_email = $settings->support_email;
            $this->support_whatsapp = $settings->support_whatsapp;
            $this->social_instagram = $settings->social_instagram;
            $this->social_facebook = $settings->social_facebook;
            
            $this->logo_path = $settings->logo_path;
            $this->favicon_path = $settings->favicon_path;

            // SMTP Settings
            $this->smtp_host = $settings->smtp_host;
            $this->smtp_port = $settings->smtp_port ?? 587;
            $this->smtp_username = $settings->smtp_username;
            $this->smtp_password = $settings->smtp_password;
            $this->smtp_encryption = $settings->smtp_encryption ?? 'tls';
            $this->smtp_from_address = $settings->smtp_from_address ?: $settings->support_email;
            $this->smtp_from_name = $settings->smtp_from_name ?: $settings->trade_name;
            $this->notify_on_ot_status = (bool)($settings->notify_on_ot_status ?? true);
            $this->notify_on_low_stock = (bool)($settings->notify_on_low_stock ?? true);
            $this->test_email_recipient = $settings->support_email ?: auth()->user()->email;

            // Email Templates
            $this->email_ot_subject = $settings->email_ot_subject ?: '📌 Actualización de tu Orden de Trabajo #{codigo_ot} [{nuevo_estado}]';
            $this->email_ot_body = $settings->email_ot_body ?: "Hola {nombre_cliente},\n\nTe informamos que tu orden de trabajo #{codigo_ot} para el equipo {equipo} ha cambiado al estado: {nuevo_estado}.\n\nPuedes consultar el avance detallado en tiempo real ingresando al enlace de seguimiento en vivo.";
            $this->email_low_stock_subject = $settings->email_low_stock_subject ?: '⚠️ Alerta de Inventario: Stock Bajo en [{producto}]';
            $this->email_low_stock_body = $settings->email_low_stock_body ?: "Estimado equipo,\n\nSe ha detectado que el producto/repuesto {producto} ha alcanzado su nivel crítico de inventario.\n\nStock actual: {stock_actual} unidades (Mínimo requerido: {stock_minimo} unidades).\n\nRecomendamos gestionar el reabastecimiento con los proveedores a la brevedad.";

            // WhatsApp Settings
            $this->whatsapp_enabled = (bool)($settings->whatsapp_enabled ?? false);
            $this->whatsapp_phone_number_id = $settings->whatsapp_phone_number_id ?? '';
            $this->whatsapp_business_account_id = $settings->whatsapp_business_account_id ?? '';
            $this->whatsapp_access_token = $settings->whatsapp_access_token ?? '';
            $this->whatsapp_template_name = $settings->whatsapp_template_name ?: 'ot_status_update';
            $this->test_whatsapp_recipient = $settings->support_whatsapp ?: '';
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updatedCatalogCategory()
    {
        $this->resetPage();
    }

    public function updatedCatalogSearch()
    {
        $this->resetPage();
    }

    public function saveWarranty()
    {
        $this->validate([
            'warranty_text' => 'required|string|min:10',
        ]);

        $settings = Setting::find(1);
        if ($settings) {
            $settings->update([
                'warranty_text' => $this->warranty_text,
            ]);
            session()->flash('message', 'Términos de garantía actualizados correctamente.');
        }
    }

    public function saveCompanySettings()
    {
        $this->validate([
            'company_name' => 'nullable|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'company_rut' => 'nullable|string|max:20',
            'company_giro' => 'nullable|string|max:255',
            'company_activity_code' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:50',
            'sii_api_key' => 'nullable|string|max:255',
            'sii_environment' => 'required|in:certificacion,produccion',
            
            'currency' => 'required|string|max:10',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'timezone' => 'required|string|max:50',
            
            'support_email' => 'nullable|email|max:255',
            'support_whatsapp' => 'nullable|string|max:50',
            'social_instagram' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            
            'new_logo' => 'nullable|image|max:2048', // max 2MB
            'new_favicon' => 'nullable|image|max:1024', // max 1MB
        ]);

        $settings = Setting::find(1);
        if ($settings) {
            
            if ($this->new_logo) {
                $this->logo_path = $this->new_logo->store('settings', 'public');
            }
            if ($this->new_favicon) {
                $this->favicon_path = $this->new_favicon->store('settings', 'public');
            }
            
            $settings->update([
                'company_name' => $this->company_name,
                'trade_name' => $this->trade_name,
                'company_rut' => $this->company_rut,
                'company_giro' => $this->company_giro,
                'company_activity_code' => $this->company_activity_code,
                'company_address' => $this->company_address,
                'company_phone' => $this->company_phone,
                'sii_api_key' => $this->sii_api_key,
                'sii_environment' => $this->sii_environment,
                
                'currency' => $this->currency,
                'tax_rate' => $this->tax_rate,
                'timezone' => $this->timezone,
                
                'support_email' => $this->support_email,
                'support_whatsapp' => $this->support_whatsapp,
                'social_instagram' => $this->social_instagram,
                'social_facebook' => $this->social_facebook,
                
                'logo_path' => $this->logo_path,
                'favicon_path' => $this->favicon_path,

                'whatsapp_enabled' => $this->whatsapp_enabled,
                'whatsapp_phone_number_id' => $this->whatsapp_phone_number_id,
                'whatsapp_business_account_id' => $this->whatsapp_business_account_id,
                'whatsapp_access_token' => $this->whatsapp_access_token,
                'whatsapp_template_name' => $this->whatsapp_template_name,
            ]);
            
            // Si guardamos, limpiamos las variables temporales de imagen para que no vuelva a intentar subirlas en otro render si no cambian
            $this->new_logo = null;
            $this->new_favicon = null;
            
            session()->flash('message', 'Configuración de Empresa y WhatsApp actualizada correctamente.');
            $this->redirect(route('settings.index'));
        }
    }

    public function sendTestWhatsApp()
    {
        $this->saveCompanySettings();

        if (empty($this->test_whatsapp_recipient)) {
            session()->flash('whatsapp_test_error', 'Ingresa un número de celular de prueba (ej: +56912345678).');
            return;
        }

        $result = \App\Services\WhatsAppService::sendTestMessage($this->test_whatsapp_recipient);

        if ($result['success']) {
            session()->flash('whatsapp_test_success', $result['message']);
        } else {
            session()->flash('whatsapp_test_error', $result['message']);
        }
    }

    public function saveSmtpSettings()
    {
        $this->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|numeric|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl,null',
            'smtp_from_address' => 'nullable|email|max:255',
            'smtp_from_name' => 'nullable|string|max:255',
            'notify_on_ot_status' => 'boolean',
            'notify_on_low_stock' => 'boolean',
        ]);

        $settings = Setting::find(1);
        if ($settings) {
            $settings->update([
                'smtp_host' => $this->smtp_host,
                'smtp_port' => $this->smtp_port ?: 587,
                'smtp_username' => $this->smtp_username,
                'smtp_password' => $this->smtp_password,
                'smtp_encryption' => $this->smtp_encryption ?: 'tls',
                'smtp_from_address' => $this->smtp_from_address,
                'smtp_from_name' => $this->smtp_from_name,
                'notify_on_ot_status' => $this->notify_on_ot_status,
                'notify_on_low_stock' => $this->notify_on_low_stock,
            ]);

            session()->flash('message', 'Configuración del Servidor SMTP y Notificaciones actualizada correctamente.');
        }
    }

    public function saveEmailTemplates()
    {
        $this->validate([
            'email_ot_subject' => 'required|string|max:255',
            'email_ot_body' => 'required|string|max:2000',
            'email_low_stock_subject' => 'required|string|max:255',
            'email_low_stock_body' => 'required|string|max:2000',
        ]);

        $settings = Setting::find(1);
        if ($settings) {
            $settings->update([
                'email_ot_subject' => $this->email_ot_subject,
                'email_ot_body' => $this->email_ot_body,
                'email_low_stock_subject' => $this->email_low_stock_subject,
                'email_low_stock_body' => $this->email_low_stock_body,
            ]);

            session()->flash('message', 'Plantillas de correo electrónico actualizadas correctamente.');
        }
    }

    public function resetEmailTemplate($type)
    {
        if ($type === 'ot') {
            $this->email_ot_subject = '📌 Actualización de tu Orden de Trabajo #{codigo_ot} [{nuevo_estado}]';
            $this->email_ot_body = "Hola {nombre_cliente},\n\nTe informamos que tu orden de trabajo #{codigo_ot} para el equipo {equipo} ha cambiado al estado: {nuevo_estado}.\n\nPuedes consultar el avance detallado en tiempo real ingresando al enlace de seguimiento en vivo.";
        } elseif ($type === 'low_stock') {
            $this->email_low_stock_subject = '⚠️ Alerta de Inventario: Stock Bajo en [{producto}]';
            $this->email_low_stock_body = "Estimado equipo,\n\nSe ha detectado que el producto/repuesto {producto} ha alcanzado su nivel crítico de inventario.\n\nStock actual: {stock_actual} unidades (Mínimo requerido: {stock_minimo} unidades).\n\nRecomendamos gestionar el reabastecimiento con los proveedores a la brevedad.";
        }

        $this->saveEmailTemplates();
        session()->flash('message', 'Plantilla restablecida a sus valores por defecto.');
    }

    public function sendTestEmail()
    {
        $this->validate([
            'test_email_recipient' => 'required|email',
        ], [
            'test_email_recipient.required' => 'Ingresa un correo electrónico para realizar la prueba.',
            'test_email_recipient.email' => 'El formato del correo de prueba no es válido.',
        ]);

        // Guardar configuración actual primero
        $this->saveSmtpSettings();

        // Configurar SMTP dinámico
        $configured = \App\Services\MailService::configureSmtp();

        if (!$configured) {
            session()->flash('error', '⚠️ No se puede realizar la prueba. Por favor completa los campos de Servidor SMTP (Host, Puerto, Usuario y Clave).');
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($this->test_email_recipient)
                ->send(new \App\Mail\TestMail($this->test_email_recipient));

            session()->flash('message', "✅ ¡Correo de prueba enviado exitosamente a {$this->test_email_recipient}! Revisa tu bandeja de entrada o spam.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al enviar correo de prueba SMTP: " . $e->getMessage());
            session()->flash('error', "❌ Falló el envío del correo de prueba: " . $e->getMessage());
        }
    }

    public function addChecklistItem()
    {
        $this->validate([
            'new_checklist_item' => 'required|string|min:2|max:100',
        ]);

        if (!isset($this->checklist_templates[$this->selected_category])) {
            $this->checklist_templates[$this->selected_category] = [];
        }

        // Evitar duplicados
        if (in_array($this->new_checklist_item, $this->checklist_templates[$this->selected_category])) {
            $this->addError('new_checklist_item', 'Este ítem ya existe en el checklist.');
            return;
        }

        $this->checklist_templates[$this->selected_category][] = trim($this->new_checklist_item);
        $this->new_checklist_item = '';
        $this->saveChecklists();
        session()->flash('message', 'Ítem agregado al checklist de ' . $this->selected_category . ' exitosamente.');
    }

    public function deleteChecklistItem($index)
    {
        if (isset($this->checklist_templates[$this->selected_category][$index])) {
            unset($this->checklist_templates[$this->selected_category][$index]);
            $this->checklist_templates[$this->selected_category] = array_values($this->checklist_templates[$this->selected_category]);
            $this->saveChecklists();
            session()->flash('message', 'Ítem eliminado del checklist de ' . $this->selected_category . '.');
        }
    }

    protected function saveChecklists()
    {
        $settings = Setting::find(1);
        if ($settings) {
            $settings->update([
                'checklist_templates' => $this->checklist_templates,
            ]);
        }
    }

    public function addDeviceToCatalog()
    {
        $this->validate([
            'new_brand' => 'required|string|min:2|max:50',
            'new_model' => 'required|string|min:2|max:50',
        ]);

        // Evitar duplicados
        $exists = DeviceCatalog::where('device_type', $this->catalog_category)
            ->where('brand', trim($this->new_brand))
            ->where('model', trim($this->new_model))
            ->exists();

        if ($exists) {
            session()->flash('error', 'Este equipo ya está registrado en el catálogo predictivo.');
            return;
        }

        DeviceCatalog::create([
            'device_type' => $this->catalog_category,
            'brand' => trim($this->new_brand),
            'model' => trim($this->new_model),
        ]);

        $this->new_brand = '';
        $this->new_model = '';
        session()->flash('message', 'Equipo agregado al catálogo predictivo correctamente.');
    }

    public function deleteDeviceFromCatalog($id)
    {
        $device = DeviceCatalog::find($id);
        if ($device) {
            $device->delete();
            session()->flash('message', 'Equipo eliminado del catálogo predictivo.');
        }
    }

    public function render()
    {
        // Paginación del catálogo de dispositivos filtrado
        $query = DeviceCatalog::where('device_type', $this->catalog_category);

        if ($this->catalog_search) {
            $query->where(function ($q) {
                $q->where('brand', 'like', '%' . $this->catalog_search . '%')
                  ->orWhere('model', 'like', '%' . $this->catalog_search . '%');
            });
        }

        $devices = $query->orderBy('brand')->orderBy('model')->paginate(10);

        $devices = $query->orderBy('brand')->orderBy('model')->paginate(10);

        return view('livewire.settings.manage-settings', [
            'devices' => $devices,
        ])->layout('layouts.app');
    }
}
