<?php

namespace App\Exports;

use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SubmissionsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        $submission = Submission::first();

        $headings = [];

        if ($submission) {
            foreach ($submission->getAttributes() as $key => $value) {
                $headings[] = $key;
            }

            foreach ($submission->answers as $answer) {
                $headings[] = $answer->question->full_code;
            }
        }

        return $headings;
    }


    public function collection()
    {
        $submissions = Submission::with(['answers'])->get();

        $data = [];

        foreach ($submissions as $submission) {
            $row = [];

            foreach ($submission->answers as $answer) {
                $row[] = $answer->answer;
            }

            $data[] = $row;
        }

        return collect($data);
    }
}
