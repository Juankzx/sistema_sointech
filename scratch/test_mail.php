<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    App\Services\MailService::configureSmtp();
    $wo = App\Models\WorkOrder::find(13);
    echo "Sending email for OT #{$wo->id} (Status: {$wo->status}) to client {$wo->client->email}...\n";
    Illuminate\Support\Facades\Mail::to($wo->client->email)
        ->send(new App\Mail\WorkOrderStatusChanged($wo, 'Entregado'));
    echo "RESULT: MAIL_SENT_SUCCESSFULLY\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\nTrace:\n" . $e->getTraceAsString() . "\n";
}
