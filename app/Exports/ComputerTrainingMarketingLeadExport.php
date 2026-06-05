<?php

namespace App\Exports;

use App\Models\ComputerTrainingMarketingLead;
use Maatwebsite\Excel\Concerns\FromCollection;

class ComputerTrainingMarketingLeadExport implements FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping
{
    protected $companyId;

    public function __construct($companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = ComputerTrainingMarketingLead::query();
        if ($this->companyId) {
            $query->where('company_id', $this->companyId);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Interested Course',
            'Source',
            'Status',
            'Next Follow Up At',
            'Notes',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->name,
            $lead->phone,
            $lead->interested_course,
            $lead->source,
            $lead->status,
            $lead->next_follow_up_at ? $lead->next_follow_up_at->format('Y-m-d H:i:s') : '',
            $lead->notes,
        ];
    }
}
