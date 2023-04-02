<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'name',
        'type',
        'data',
    ];

    public const NOTIFICATION_TYPES = [
        1 => 'telegram',
    ];
}
