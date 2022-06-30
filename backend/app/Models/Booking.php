<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'room_id',
        'user_id',
        'from_date',
        'to_date',
    ];

    protected $with = [
        'room',
        'user'
    ];

    /**
     * The attributes that should be cast as Carbon.
     *
     * @var array
     */
    protected $dates = [
        'from_date',
        'to_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActiveBooking($query, string $id)
    {
        return $query->where('id', '!=', $id);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
