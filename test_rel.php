<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ComputerTrainingCourse;
use App\Models\ComputerTrainingStudent;

ComputerTrainingCourse::resolveRelationUsing('students', function ($courseModel) {
    return $courseModel->hasMany(ComputerTrainingStudent::class, 'course', 'name');
});

$c = ComputerTrainingCourse::first();
echo "Course: " . $c->name . "\n";
echo "Students count: " . $c->students()->count() . "\n";
