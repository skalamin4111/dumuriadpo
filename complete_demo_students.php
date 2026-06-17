<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ComputerTrainingStudent;

$students = ComputerTrainingStudent::all();

$bengaliNames = [
    'Rahim Uddin' => 'রহিম উদ্দিন',
    'Karim Mia' => 'করিম মিয়া',
    'Abdul Kuddus' => 'আব্দুল কুদ্দুস',
    'Fatema Begum' => 'ফাতেমা বেগম',
    'Ayesha Siddika' => 'আয়েশা সিদ্দিকা',
    'Shamim Hossain' => 'শামীম হোসেন',
    'Rafiqul Islam' => 'রফিকুল ইসলাম',
    'Nazmul Hasan' => 'নাজমুল হাসান',
    'Sumi Akter' => 'সুমি আক্তার',
    'Tania Sultana' => 'তানিয়া সুলতানা',
    'Arifur Rahman' => 'আরিফুর রহমান',
    'Mehedi Hasan' => 'মেহেদী হাসান',
    'Jahirul Islam' => 'জহিরুল ইসলাম',
    'Ruma Khatun' => 'রুমা খাতুন',
    'Farhana Yasmin' => 'ফারহানা ইয়াসমিন',
    'Sakib Al Hasan' => 'সাকিব আল হাসান',
    'Tamim Iqbal' => 'তামিম ইকবাল',
    'Mushfiqur Rahim' => 'মুশফিকুর রহিম',
    'Mashrafe Mortaza' => 'মাশরাফি মর্তুজা',
    'Mahmudullah Riyad' => 'মাহমুদউল্লাহ রিয়াদ',
    'Nusrat Jahan' => 'নুসরাত জাহান',
    'Sabina Yasmin' => 'সাবিনা ইয়াসমিন',
    'Kazi Nazrul Islam' => 'কাজী নজরুল ইসলাম',
    'Jasim Uddin' => 'জসীম উদ্দীন',
    'Begum Rokeya' => 'বেগম রোকেয়া'
];

$fathers = ['Anwar Hossain', 'Jalil Mia', 'Habibullah', 'Abdur Rahman', 'Mofizur Rahman'];
$mothers = ['Salma Begum', 'Firoza Khatun', 'Hasina Banu', 'Rehena Parvin', 'Momotaz Begum'];
$districts = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal'];
$religions = ['Islam', 'Hindu', 'Christian', 'Other'];
$maritalStatuses = ['Married', 'Unmarried'];

$updated = 0;

foreach ($students as $student) {
    // Determine gender roughly based on name (if it ends with a,i etc it's likely female)
    $isFemale = preg_match('/(a|i|u|n)$/i', explode(' ', $student->name)[0]);
    $gender = $isFemale ? 'Female' : 'Male';
    
    // Guardian
    $guardianName = $fathers[array_rand($fathers)];
    $guardianPhone = '01' . rand(7, 9) . rand(10000000, 99999999);
    
    // Education
    $passingYear = rand(2015, 2023);
    $education = [
        [
            'exam_name' => 'SSC',
            'group' => ['Science', 'Arts', 'Commerce'][rand(0, 2)],
            'institute' => 'Govt. High School',
            'passing_year' => (string)$passingYear,
            'board' => ['Dhaka', 'Rajshahi', 'Sylhet', 'Comilla'][rand(0, 3)],
            'grade' => rand(3, 4) . '.' . rand(0, 99),
        ],
        [
            'exam_name' => 'HSC',
            'group' => ['Science', 'Arts', 'Commerce'][rand(0, 2)],
            'institute' => 'City College',
            'passing_year' => (string)($passingYear + 2),
            'board' => ['Dhaka', 'Rajshahi', 'Sylhet', 'Comilla'][rand(0, 3)],
            'grade' => rand(3, 4) . '.' . rand(0, 99),
        ]
    ];
    
    // Only add education randomly
    $eduList = rand(0, 10) > 2 ? $education : [];

    $student->update([
        'name_bn' => $bengaliNames[$student->name] ?? null,
        'father_name' => $fathers[array_rand($fathers)],
        'mother_name' => $mothers[array_rand($mothers)],
        'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(1, 365))->toDateString(),
        'nid_or_birth_reg' => (string)rand(1000000000, 9999999999),
        'nationality' => 'Bangladeshi',
        'gender' => $gender,
        'marital_status' => $maritalStatuses[array_rand($maritalStatuses)],
        'religion' => $religions[array_rand($religions)],
        'email' => strtolower(str_replace(' ', '.', $student->name)) . rand(10, 99) . '@example.com',
        'duration' => ['3 Months', '6 Months', '1 Year'][rand(0, 2)],
        'guardian_name' => $guardianName,
        'guardian_phone' => $guardianPhone,
        'address' => 'House #' . rand(1, 100) . ', Road #' . rand(1, 20) . ', ' . $districts[array_rand($districts)] . ', Bangladesh',
        'educational_qualifications' => $eduList,
        'notes' => 'Generated demo profile for testing purposes.',
    ]);
    
    $updated++;
}

echo "Successfully updated $updated student profiles with complete demo data.\n";
