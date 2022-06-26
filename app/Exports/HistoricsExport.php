<?php

namespace App\Exports;

use App\Models\Historic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoricsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return auth()->user()->historics()->get();
    }

    public function headings():array {
        return [
            'id do histórico',
            'id do usuário',
            'tipo de operação',
            'valor da operação',
            'total antes da operação',
            'total depois da operação',
            'data',
            'criado em:',
            'atualiza em:'
        ];
    }
}
