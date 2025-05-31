<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblCart extends Model
{
    use HasFactory;
    public $timestamps = true;
    //
    protected $table = 'tbl_carts';
    protected $fillable = [
        'idUser',
        'product_id',
        'qty',
        'price',
        'status',
    ];

    public function product()
    {
        // return $this->belongsTo(Product::class, 'product_id');
         return $this->hasOne(Product::class, 'id', 'product_id');
    }
}