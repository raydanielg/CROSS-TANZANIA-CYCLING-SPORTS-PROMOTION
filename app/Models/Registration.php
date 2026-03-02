<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'participant_id',
        'bib_number',
        'status',
        'confirmed_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
