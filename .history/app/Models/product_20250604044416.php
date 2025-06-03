<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_brand',
        'gender',
        'price',
        'description',
        'primary_color',
        'jenis_pakaian',
        'discount',
        'quantity',
        'quantity_out',
        'foto',
        'is_active',
    ];
    // public function product()
    // {
    //     return $this->hasOne(tblCart::class,'product_id','id');
    // }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
}
