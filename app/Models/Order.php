<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use DB;
use Carbon\Carbon;

class Order extends Authenticatable
{
    use HasRoleAndPermission;
    use Notifiable;
    use SoftDeletes;

    const PERIOD_BONUSES = [
        'discounthalf',
        'cardgold'
    ];

    const TRANSFER_AUTO_PRICES = [
        'Б' => [
            1 => 1900, // Mazda, Opel (3 places)
            2 => 2000, // Audi, Kia, Toyota (3 places)
            3 => 2500, // Minibus (8 places)
        ],
        'Ж' => [
            4 => 2100, // Mazda, Opel (3 places)
            5 => 2300, // Audi, Kia, Toyota (3 places)
            6 => 2800, // Minibus (8 places)
        ]
    ];

    const TRANSFER_AUTO_HUMANS = [
        'Б' => [
            1 => 4, // Mazda, Opel (3 places)
            2 => 4, // Audi, Kia, Toyota (3 places)
            3 => 8, // Minibus (8 places)
        ],
        'Ж' => [
            4 => 4, // Mazda, Opel (3 places)
            5 => 4, // Audi, Kia, Toyota (3 places)
            6 => 8, // Minibus (8 places)
        ]
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fio',
        'phone',
        'type',
        'airport',
        'terminal',
        'datetime',
        'registration',
        'flight',
        'address',
        'tickets',
        'transfer',
        'info',
        'status_order',
		'status_pay',
		'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Build Social Relationships.
     *
     * @var array
     */
    public function social()
    {
        return $this->hasMany('App\Models\Social');
    }

    /**
     * User Profile Relationships.
     *
     * @var array
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    // User Profile Setup - SHould move these to a trait or interface...

    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profile')->withTimestamps();
    }

    public function hasProfile($name)
    {
        foreach ($this->profiles as $profile) {
            if ($profile->name == $name) {
                return true;
            }
        }

        return false;
    }

    public function assignProfile($profile)
    {
        return $this->profiles()->attach($profile);
    }

    public function removeProfile($profile)
    {
        return $this->profiles()->detach($profile);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public static function orders_week($status)
    {
        return Order::select([DB::raw('count(id) as `count`'), DB::raw('DATE(created_at) as day')])
            ->groupBy('day')
            ->where('user_id', '=', auth()->user()->id)
            ->where('status_order', '=', $status)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();
    }

    public static function orders_month($status)
    {
        return Order::select([DB::raw('count(id) as `count`'), DB::raw('DATE(created_at) as day')])
            ->groupBy('day')
            ->where('status_order', '=', $status)
            ->where('user_id', '=', auth()->user()->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();
    }

    public static function orders_year($status)
    {
        return Order::select([DB::raw('count(id) as `count`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') month"),])
            ->groupBy('month')
            ->where('status_order', '=', $status)
            ->where('user_id', '=', auth()->user()->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();
    }
}
