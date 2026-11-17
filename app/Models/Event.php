<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karya()
    {
        return $this->hasMany(Karya::class, 'event_id');
    }
}
