<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'options_name'];

    /**---------------------------------------------------------------------------------------------------------
     * Relationships
     **---------------------------------------------------------------------------------------------------------
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

//    public function orderInformation(): HasOne
//    {
//        return $this->hasOne(OrderProduct::class);
//    }

    public function orderInformation()
    {
        return $this->hasOne(OrderProduct::class);
    }
}
