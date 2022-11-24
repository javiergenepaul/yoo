<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'driver_id',
        'vehicle_id',
        'completed_dateime',
        'order_status_id',
        'total_mileage',
        'instruction',
        'payment_method_id',
        'total_amount',
        'total_paid',
        'holiday',
        'high_demand',
        'area_id',
    ];

    public function dropoffLocations()
    {
        return $this->hasMany(DropoffLocation::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function pickupInfo()
    {
        return $this->hasOne(PickupInfo::class);
    }

    public function pickupItemImages()
    {
        return $this->hasMany(PickupItemImage::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driverOrderConfirm()
    {
        return $this->hasOne(DriverOrderConfirm::class);
    }

    public function arrivedPickUpItemImage()
    {
        return $this->hasOne(ArrivedPickUpItemImage::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function orderCoordinates()
    {
        return $this->hasMany(OrderCoordinates::class);
    }

    public function itemOrders()
    {
        return $this->hasMany(ItemOrder::class);
    }
}
