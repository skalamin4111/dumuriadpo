<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ComputerTrainingCourse;

$courses = [
    'Basic Computer',
    'Office Application',
    'Graphic Design',
    'Web Development',
    'Freelancing',
    'Digital Marketing',
    'Diploma in Software Application',
];

// Assuming company_id = 1 for demo purposes as used previously, or loop through all companies
$companyId = \App\Models\Company::first()->id ?? 1;

foreach ($courses as $courseName) {
    ComputerTrainingCourse::firstOrCreate([
        'company_id' => $companyId,
        'name' => $courseName
    ]);
}

echo "Courses seeded successfully.";
