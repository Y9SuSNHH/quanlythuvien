<?php

namespace App\Models;

use App\Constants\OrderStatusConstant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Collection $products
 */
final class Order extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'orders';

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_user_id',
        'confirmable_type',
        'confirmable_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'status_name',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function confirmable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function createdUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function getStatusNameAttribute(): string
    {
        return OrderStatusConstant::getLangByValue($this->status);
    }

    public function canDelete(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->status === OrderStatusConstant::NEW,
        )->shouldCache();
    }

    public function canCompleted(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->status === OrderStatusConstant::SHIPPED,
        )->shouldCache();
    }

    public function canShipped(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->status === OrderStatusConstant::NEW,
        )->shouldCache();
    }
}
