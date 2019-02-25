<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\EntityTableNameTrait;

/**
 * App\Models\Abuse
 * @mixin \Abuse
 * @property int $id
 * @property int $creator_user_id
 * @property int $respondent_user_id
 * @property int $abuse_type_id
 * @property int $abuse_status_id
 * @property string $description
 * @property int $doc_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $respondent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AbuseType[] $abuse_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AbuseStatus[] $abuse_status
 * @mixin \Eloquent
 */
class Abuse extends Model
{
    use EntityTableNameTrait;

    /**
     * Guarded fields
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='abuses';

    /**
     * Relation to Creator user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'creator_user_id');
    }

    /**
     * Relation to Respondent user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function respondent()
    {
        return $this->hasOne('App\Models\User', 'respondent_user_id');
    }

    /**
     * Relation to Abuse type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function abuse_type()
    {
        return $this->hasOne('App\Models\AbuseType');
    }

    /**
     * Relation to Abuse status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function abuse_status()
    {
        return $this->hasOne('App\Models\AbuseStatus');
    }

    /**
     * Relation to Post comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function abuse_post()
    {
        return $this->hasOne('App\Models\Post','doc_id');
    }

    /**
     * Relation to Post comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function abuse_post_comment()
    {
        return $this->hasOne('App\Models\PostComment','doc_id');
    }
}