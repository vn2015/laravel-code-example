<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\EntityTableNameTrait;

/**
 * App\Models\AbuseType
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AbuseType extends Model
{
    use EntityTableNameTrait;

    const POST_TYPE = 1;
    const COMMENT_TYPE = 2;

    protected $guarded = [
        'id'
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='abuse_types';
}