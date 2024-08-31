<?php

namespace App\Models;

use App\Helpers\FakerHelper;
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

    public function getTransformedData($depth = 0)
    {
        $objectData = json_decode($this->data, true);
        $result = [];

        foreach ($objectData as $objectType => $objectValues) {
            foreach ($objectValues as $objectId => $objectValue) {
                if ($objectType === 'value') {
                    $result[$objectValue[0]] = $objectValue[1]; // Используем ассоциативный массив вместо индексного
                }
                elseif ($objectType === 'pattern') {
                    $result[$objectValue[0]] = FakerHelper::processPattern($objectValue[1]); // Тоже ассоциативный массив
                }
                elseif ($objectType === 'object') {
                    if ($depth < 10) $nestedObject = self::find($objectValue[1])->getTransformedData($depth + 1);
                    else $nestedObject = 'RecursiveObject';
                    $result[$objectValue[0]] = $nestedObject; // И здесь ассоциативный массив
                }
            }
        }

        return $result;
    }
}
