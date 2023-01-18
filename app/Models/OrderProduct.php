<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $table = 'order_product';

    /**---------------------------------------------------------------------------------------------------------
     * Relationships
     **---------------------------------------------------------------------------------------------------------
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
