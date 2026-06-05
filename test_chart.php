<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = App\Models\Proposal::select('id', 'submission_date', 'alsintan_id', 'program_id')
    ->whereNotNull('submission_date')
    ->get()
    ->map(function($item) {
        return [
            'date' => $item->submission_date->format('Y-m-d'),
            'type' => $item->alsintan_id ? 'alsintan' : 'program'
        ];
    });

echo "COUNT: " . count($data) . "\n";
echo "DATA: " . json_encode($data) . "\n";
