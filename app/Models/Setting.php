<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'legal_terms', 'checklist_template', 'predictive_catalog', 'checklist_templates', 'warranty_text', 'warranty_months',
        'company_name', 'trade_name', 'company_rut', 'company_address', 
        'company_phone', 'currency', 'tax_rate', 'timezone',
        'support_email', 'support_whatsapp', 'social_instagram', 'social_facebook',
        'logo_path', 'favicon_path',
        'sii_api_key', 'sii_environment', 'company_giro', 'company_activity_code'
    ];

    protected $casts = [
        'checklist_template' => 'array',
        'checklist_templates' => 'array',
        'predictive_catalog' => 'array',
    ];
}
