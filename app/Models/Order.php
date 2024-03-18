<?php

namespace App\Models;

use App\Constants\OrderStatusConstant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property Collection $products
 * @property int $status
 * @property Carbon $updated_at
 * @property int $no_rent_date
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
        'rent_no_date',
        'note',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'status'       => 'integer',
        'rent_no_date' => 'integer',
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

    public function status(): Attribute
    {
        $attributes = $this->attributes;
        $status = $attributes['status'] ?? OrderStatusConstant::NEW;

        if ($status === OrderStatusConstant::SHIPPED && $attributes['updated_at']) {
            $reitToDate = Carbon::make($attributes['updated_at'])->addDays($attributes['rent_no_date'] ?? 0)->toDateString();

            $now = now()->toDateString();

            if ($reitToDate > $now) {
                $status = OrderStatusConstant::OVER_RENT;
            }
        }

        return Attribute::make(
            get: fn() => $status,
        )->shouldCache();
    }

    public function statusName(): Attribute
    {
        return Attribute::make(
            get: fn() => OrderStatusConstant::getLangByValue($this->status),
        )->shouldCache();
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

    public function productOrdered(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->status === OrderStatusConstant::NEW,
        )->shouldCache();
    }

    public function outOfRent(): Attribute
    {
        $outOfRent = $this->orders->filter(function (Order $order) {
            if ($order->status !== OrderStatusConstant::SHIPPED) {
                return false;
            }
            $reitToDate = $order->updated_at->addDays($order->no_rent_date)->toDateString();

            $now = now()->toDateString();

            return $now > $reitToDate;
        });

        return Attribute::make(
            get: fn() => $outOfRent,
        )->shouldCache();
    }
}
