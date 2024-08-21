<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false; // no such fields

    protected $casts = [
      'name' => OrderStatusEnum::class
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    //SCOPES
    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::InProcess->value);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Paid->value);
    }

    public function scopeShiped(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Shipped->value);
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Delivered->value);
    }

    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Cancelled->value);
    }
}

/*OrderStatus::where('name', OrderStatusEnum::Paid->value)->get();
OrderStatus::paid()->get();*/
