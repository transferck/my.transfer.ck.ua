<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cars';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
		'manufacturer', 
		//'model', 
		'registration_number', 
		'side_number', 
		'purchase_date', 
		'mileage', 
		'release_date', 
		'condition', 
		'color', 
		'notes', 
		'status',
        'taggable_id',
        'taggable_type',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return array
     */
    public static function rules($id = 0, $merge = [])
    {
        return array_merge(
            [
                //'name'   => 'required|min:3|max:50|unique:themes,name'.($id ? ",$id" : ''),
                //'link'   => 'required|min:3|max:255|unique:themes,link'.($id ? ",$id" : ''),
				'manufacturer'  => 'required',
				//'model'  => 'required',
				'registration_number'  => 'required',
				'side_number'  => 'required',
				'purchase_date'  => 'required',
				'mileage'  => 'required',
				'release_date'  => 'required',
				'condition'  => 'required',
				'color' => 'required', 			
                'notes'  => 'max:500',
                'status' => 'required',
            ],
            $merge);
    }

    /**
     * Build Theme Relationships.
     *
     * @var array
     */
    public function profile()
    {
        return $this->hasMany('App\Models\Profile');
    }

    public function getLastCostMileage()
    {
        $cost = Cost::query()
            ->where('car_id', $this->id)
            ->whereNotNull('mileage')
            ->where('mileage', '!=', 0)
            ->where('mileage', '!=', '')
            ->orderBy('updated_at', 'DESC')
            ->first();

        if (!$cost) {
            return 0;
        }

        return $cost->mileage;
    }
}
