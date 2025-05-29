<?php

declare(strict_types=1);

namespace Wave;

use Illuminate\Database\Eloquent\Model;

class ProfileKeyValue extends Model
{
    public $timestamps = false;

    protected $table = 'profile_key_values';

    protected $fillable = [
        'type',
        'keyvalue_id',
        'keyvalue_type',
        'key',
        'value',
    ];

    public function profileKeyValue()
    {
        return $this->morphTo();
    }
}
