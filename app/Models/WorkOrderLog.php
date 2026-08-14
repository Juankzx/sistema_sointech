<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImagesAttribute(): array
    {
        if (empty($this->image_path)) {
            return [];
        }

        $decoded = json_decode($this->image_path, true);
        if (is_array($decoded)) {
            return array_values($decoded);
        }

        return [$this->image_path];
    }
}
