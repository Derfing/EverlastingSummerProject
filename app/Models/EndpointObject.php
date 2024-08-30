<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EndpointObject extends Model
{
    protected $table = 'endpoints_objects';

    public $timestamps = false;

    protected $fillable = ['name', 'data'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getDataByName($name)
    {
        $object = self::where('name', $name)->first();
        return $object ? json_decode($object->data, true) : null;
    }
}
