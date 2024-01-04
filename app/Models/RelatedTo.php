<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedTo extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'related_tos';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'initial_contact_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function initial_contact()
    {
        return $this->belongsTo(User::class, 'initial_contact_id');
    }

    public function related_tos()
    {
        return $this->belongsToMany(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
