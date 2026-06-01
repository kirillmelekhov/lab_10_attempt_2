<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterClass extends Model
{
    use HasFactory;

    public const AVAILABLE_SLOTS = [
        '09:00:00' => '09:00 - 11:00',
        '11:00:00' => '11:00 - 13:00',
        '13:00:00' => '13:00 - 15:00',
        '15:00:00' => '15:00 - 17:00',
    ];

    protected $fillable = [
        'creative_type_id',
        'leader_id',
        'title',
        'description',
        'session_date',
        'slot_time',
        'max_participants',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'slot_time' => 'datetime:H:i:s',
            'price' => 'decimal:2',
        ];
    }

    public function creativeType(): BelongsTo
    {
        return $this->belongsTo(CreativeType::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(MasterClassRegistration::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'master_class_registrations')
            ->withTimestamps();
    }

    public function getSlotLabel(): string
    {
        $time = $this->slot_time instanceof Carbon
            ? $this->slot_time->format('H:i:s')
            : (string) $this->slot_time;

        return self::AVAILABLE_SLOTS[$time] ?? $time;
    }

    public function getFreePlaces(): int
    {
        $occupied = $this->registrations_count ?? $this->registrations()->count();

        return max(0, $this->max_participants - $occupied);
    }

    public function isFull(): bool
    {
        return $this->getFreePlaces() <= 0;
    }
}
