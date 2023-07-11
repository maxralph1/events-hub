<?php

namespace App\Models;

use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'event_hall_id',
        'host_id',
        'user_id',
        'title',
        'slug',
        'description',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'age_limit',
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function event_hall(): BelongsTo
    {
        return $this->belongsTo(EventHall::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public static function booted()
    {
        parent::booted();

        self::observe(EventObserver::class);
    }

    public function oldEvent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['start_date'] < now()->toDateString()
        );
    }

    public function newEvent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['start_date'] > now()->toDateString()
        );
    }
}
