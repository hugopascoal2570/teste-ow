<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model{
    use HasFactory;
    
    public $timestamps = false;

    public function deposit(float $value)
    {
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.', '');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'C',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if ($deposit && $historic) {

        return response()->json([200]);
    } 
}

    public function debit(float $value){
    $totalBefore = $this->amount ? $this->amount : 0;
    $this->amount -= number_format($value, 2, '.', '');
    $deposit = $this->save();

    $historic = auth()->user()->historics()->create([
        'type'          => 'D',
        'amount'        => $value,
        'total_before'  => $totalBefore,
        'total_after'   => $this->amount,
        'date'          => date('Ymd'),
    ]);

    if ($deposit && $historic) {

    return response()->json([200]);
    } 
}
}