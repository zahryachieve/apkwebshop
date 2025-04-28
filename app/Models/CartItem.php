<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_name', 'quantity', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
