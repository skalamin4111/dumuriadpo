<?php

namespace App\Imports;

use App\Models\ComputerTrainingMarketingLead;
use Maatwebsite\Excel\Concerns\ToModel;

class ComputerTrainingMarketingLeadImport implements ToModel, \Maatwebsite\Excel\Concerns\WithHeadingRow
{
    protected $companyId;

    public function __construct($companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $keys = array_keys($row);
        
        $nameKey = collect($keys)->first(fn($key) => in_array($key, ['student_name', 'name', 'full_name', 'student', 'lead_name']));
        $phoneKey = collect($keys)->first(fn($key) => in_array($key, ['mobile_number', 'phone', 'mobile', 'contact', 'phone_number']));
        $courseKey = collect($keys)->first(fn($key) => in_array($key, ['interested_course', 'course', 'program']));
        $sourceKey = collect($keys)->first(fn($key) => in_array($key, ['school_name', 'source', 'school']));
        $notesKey = collect($keys)->first(fn($key) => in_array($key, ['comments', 'notes', 'remark', 'remarks']));
        $statusKey = collect($keys)->first(fn($key) => in_array($key, ['status', 'state']));

        // If we can't find a column for the name at all, throw an error so the user knows
        if (!$nameKey) {
            throw new \Exception('Could not find a valid "Name" column. Please ensure your Excel file has a column header like "Name" or "Student Name". Found columns: ' . implode(', ', $keys));
        }

        $name = $row[$nameKey];
        
        // Skip empty rows silently
        if (empty($name)) {
            return null;
        }

        $notes = [];
        if ($notesKey && !empty($row[$notesKey])) {
            $notes[] = $row[$notesKey];
        }
        if (in_array('fathers_name', $keys) && !empty($row['fathers_name'])) {
            $notes[] = "Father: " . $row['fathers_name'];
        }
        if (in_array('officer', $keys) && !empty($row['officer'])) {
            $notes[] = "Officer: " . $row['officer'];
        }

        return new ComputerTrainingMarketingLead([
            'company_id'        => $this->companyId,
            'name'              => $name,
            'phone'             => $phoneKey ? $row[$phoneKey] : null,
            'interested_course' => $courseKey ? $row[$courseKey] : null,
            'source'            => $sourceKey ? $row[$sourceKey] : null,
            'status'            => $statusKey && !empty($row[$statusKey]) ? strtolower($row[$statusKey]) : 'new',
            'next_follow_up_at' => !empty($row['next_follow_up_at']) ? \Carbon\Carbon::parse($row['next_follow_up_at']) : null,
            'notes'             => !empty($notes) ? implode("\n", $notes) : null,
        ]);
    }
}
