<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\EntityTableNameTrait;

/**
 * App\Models\AbuseStatus
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AbuseStatus extends Model
{
    use EntityTableNameTrait;

    protected $guarded = [
        'id'
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='abuse_statuses';
}