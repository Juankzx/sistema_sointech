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
            ]);
            
            // Si guardamos, limpiamos las variables temporales de imagen para que no vuelva a intentar subirlas en otro render si no cambian
            $this->new_logo = null;
            $this->new_favicon = null;
            
            session()->flash('message', 'Configuración de Empresa actualizada correctamente.');
            $this->redirect(route('settings.index'));
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

        return view('livewire.settings.manage-settings', [
            'devices' => $devices,
        ])->layout('layouts.app');
    }
}
