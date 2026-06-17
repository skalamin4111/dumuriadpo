<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$companyId = \App\Models\Company::first()->id;

$sBatches = ['S-2', 'S-3', 'S-4', 'S-9', 'S-10', 'S-11', 'S-12'];
$rBatches = ['R-2', 'R-3', 'R-4', 'R-9', 'R-10', 'R-11', 'R-12'];

foreach ($sBatches as $name) {
    \App\Models\ComputerTrainingBatch::firstOrCreate([
        'company_id' => $companyId,
        'name' => $name,
    ], [
        'type' => 'S',
        'capacity' => 15,
        'status' => 'active'
    ]);
}

foreach ($rBatches as $name) {
    \App\Models\ComputerTrainingBatch::firstOrCreate([
        'company_id' => $companyId,
        'name' => $name,
    ], [
        'type' => 'R',
        'capacity' => 15,
        'status' => 'active'
    ]);
}
echo "Batches seeded.\n";
