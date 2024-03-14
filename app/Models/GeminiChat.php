<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class GeminiChat extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function setPartsAttribute($value): void
    {
        if (!is_array($value)) {
            $value = [];
        }
        $this->attributes['parts'] = json_encode($value);
    }

    public function getPartsAttribute()
    {
        return json_decode($this->attributes['parts'] ?? '', true) ?? [];
    }
}
