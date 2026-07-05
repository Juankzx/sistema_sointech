<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderImage extends Model
{
    /** @use HasFactory<\Database\Factories\WorkOrderImageFactory> */
    use HasFactory;

    protected $guarded = [];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
