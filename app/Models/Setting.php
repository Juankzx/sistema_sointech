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
        'sii_api_key', 'sii_environment', 'company_giro', 'company_activity_code',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption',
        'smtp_from_address', 'smtp_from_name', 'notify_on_ot_status', 'notify_on_low_stock',
        'email_ot_subject', 'email_ot_body', 'email_low_stock_subject', 'email_low_stock_body'
    ];

    protected $casts = [
        'checklist_template' => 'array',
        'checklist_templates' => 'array',
        'predictive_catalog' => 'array',
    ];
}
