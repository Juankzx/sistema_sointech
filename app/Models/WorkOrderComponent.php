<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderComponent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'components' => 'array',
        'remarks' => 'string',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
?>
