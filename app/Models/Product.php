<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['name', 'slug', 'description', 'price', 'code', 'barcode', 'active'];

    protected $dates = ['deleted_at'];

    /**
     * @param $query
     */
    public function scopeFilterActive($query)
    {
        $query->where('active', request('active') ?? 1);
    }

    /**
     * @param $query
     */
    public function scopeFilterPrice($query)
    {
        $priceMin = request('price_min') ?? $this->min('price');
        $priceMax = request('price_max') ?? $this->max('price');

        $query->whereBetween('price', [(int)$priceMin, (int)$priceMax]);
    }

    /**
     * @param $query
     */
    public function scopeSort($query)
    {
        $fields = ['id', 'name', 'price', 'created_at'];
        $directions = ['asc', 'desc', ''];

        if (in_array(request('sort_by'), $fields) && in_array(strtolower(request('order_by')), $directions)) {
            $query->orderBy(request('sort_by'), request('order_by') ?? 'asc');
        }
    }
}
