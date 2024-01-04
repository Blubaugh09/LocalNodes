<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'smss';

    protected $dates = [
        'date_to_send',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'message',
        'date_to_send',
        'time_to_send',
        'created_at',
        'sent_to_men',
        'sent_to_woman',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateToSendAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateToSendAttribute($value)
    {
        $this->attributes['date_to_send'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function send_to_roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
