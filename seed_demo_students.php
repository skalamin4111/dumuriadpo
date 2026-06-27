<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ComputerTrainingStudent;
use App\Models\ComputerTrainingBatch;
use App\Models\Company;

$company = Company::first();

if (!$company) {
    echo "No company found. Creating a dummy company...\n";
    $company = Company::create(['name' => 'Demo Company']);
}

$batches = ComputerTrainingBatch::where('company_id', $company->id)->get();
$courses = [
    'Basic Computer',
    'Office Application',
    'Graphic Design',
    'Web Development',
    'Freelancing',
    'Digital Marketing',
];

$names = [
    'Rahim Uddin', 'Karim Mia', 'Abdul Kuddus', 'Fatema Begum', 'Ayesha Siddika',
    'Shamim Hossain', 'Rafiqul Islam', 'Nazmul Hasan', 'Sumi Akter', 'Tania Sultana',
    'Arifur Rahman', 'Mehedi Hasan', 'Jahirul Islam', 'Ruma Khatun', 'Farhana Yasmin',
    'Sakib Al Hasan', 'Tamim Iqbal', 'Mushfiqur Rahim', 'Mashrafe Mortaza', 'Mahmudullah Riyad',
    'Nusrat Jahan', 'Sabina Yasmin', 'Kazi Nazrul Islam', 'Jasim Uddin', 'Begum Rokeya'
];

$added = 0;
foreach ($names as $i => $name) {
    $batch = $batches->count() > 0 ? $batches->random() : null;
    $course = $courses[array_rand($courses)];
    
    ComputerTrainingStudent::create([
        'company_id' => $company->id,
        'student_id' => 'STU-' . date('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
        'name' => $name,
        'phone' => '01' . rand(7, 9) . rand(10000000, 99999999),
        'course' => 'Diploma in Software Application',
        'status' => 'admitted',
        'batch_id' => $batch ? $batch->id : null,
        'admission_date' => now()->subDays(rand(1, 30)),
        'address' => 'Dhaka, Bangladesh',
    ]);
    $added++;
}

echo "Successfully added $added demo students.\n";
