<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Intern;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class InternAttendanceExport implements FromQuery, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Attendance::query()
                    ->select('attendances.*', 'interns.name as intern_name')
                    ->join('interns', 'attendances.intern_id', '=', 'interns.id');

        // Filter by intern_id if provided
        if (isset($filters['intern_id']) && $filters['intern_id'] != '') {
            $query->where('intern_id', $filters['intern_id']);
        }
        // Filter by division if provided and intern_id is not set
        elseif (isset($filters['division']) && $filters['division'] != '') {
            $internIds = Intern::where('division_id', $filters['division'])->pluck('id');
            $query->whereIn('intern_id', $internIds);
        }
        // Filter by month if provided
        if (isset($filters['month']) && $filters['month'] != '') {
            $query->whereMonth('date', $filters['month']);
        }

        // dd($query->get());
        return $query->get(); // Use get() to retrieve results for DataTables processing    
    }

    public function headings(): array
    {
        return [
            'Intern Name',
            'Date',
            'Check In',
            'Check Out',
            'Work Hours',
            'Work Location',
            'Status',
        ];
    }
}
