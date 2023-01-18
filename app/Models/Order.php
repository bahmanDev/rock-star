<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'status', 'user_id'];

    protected $casts = [
        'status' => OrderStatus::class
    ];


    /**---------------------------------------------------------------------------------------------------------
     * Relationships
     **---------------------------------------------------------------------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['qty', 'option_id', 'price'])->using(OrderProduct::class);
    }

    public function orderInformation(): HasMany
    {
        return $this->hasMany(OrderProduct::class)->with(['product', 'option']);
    }
}
