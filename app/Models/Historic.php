<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Historic extends Model
{
    use HasFactory;
    
    protected $table ='historics';

    protected $fillable = ['type', 'amount', 'total_before', 'total_after','date'];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function type($type = null)
    {
        $types = [
            'C' => 'Credit',
            'D' => 'Debit',
            'R' => 'Refund',
        ];

        if (!$type)
            return $types;
        
        return $types[$type];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
