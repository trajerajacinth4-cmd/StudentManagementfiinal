<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'action',
        'description',
        'ip_address',
    ];

    /**
     * Helper to quickly log an activity.
     */
    public static function log(string $action, string $description): self
    {
        $userName = Auth::check() ? Auth::user()->name : 'System / Guest';
        $ip = request()->ip();

        return self::create([
            'user_name'   => $userName,
            'action'      => strtoupper($action),
            'description' => $description,
            'ip_address'  => $ip,
        ]);
    }
}
