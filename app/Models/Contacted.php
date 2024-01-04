<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacted extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'contacteds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const CONTACT_TYPE_RADIO = [
        'Call'    => 'Call',
        'Text'    => 'Text',
        'Email'   => 'Email',
        'Address' => 'Address',
    ];

    protected $fillable = [
        'user_started_id',
        'user_ended_id',
        'contact_type',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user_started()
    {
        return $this->belongsTo(User::class, 'user_started_id');
    }

    public function user_ended()
    {
        return $this->belongsTo(User::class, 'user_ended_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
