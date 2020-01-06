<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
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
		'registration_number',
		'side_number', 
		'purchase_date',
		'purchase_price',
		'mileage', 
		'release_date', 
		'condition', 
		'color',
		'img', 
		'notes', 
		'car_status',
		'status',
        'taggable_id',
        'taggable_type',
        'image',
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
				'manufacturer'  => 'required',
				'registration_number'  => 'required',
				'side_number'  => 'required',
				'purchase_date'  => 'required',
				'mileage'  => 'required',
				'release_date'  => 'required',
				'condition'  => 'required',
				'color' => 'required', 	
				//'img' => 'required', 			
                'notes'  => 'max:500',
                'status' => 'required',
            ],
            $merge);
    }

    /**
     * Build Theme Relationships.
     *
     * @var array
     * @return Relation
     */
    public function profile()
    {
        return $this->hasMany('App\Models\Profile');
    }

    /**
     * Build Theme Relationships.
     *
     * @var array
     * @return Relation
     */
    public function costs()
    {
        return $this->hasMany('App\Models\Cost');
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

    public function getAllCostsSum()
    {
        return Cost::query()
            ->where('car_id', $this->id)
            ->sum(\DB::raw('purchase_cost + work_price'));
    }

    public function getCostsSum()
    {
        return Cost::query()
            ->where('car_id', $this->id)
            ->where('category_consumption', '!=', 9)
            ->where('category_consumption', '!=', 10)
            ->sum(\DB::raw('purchase_cost + work_price'));
    }

    public function getLastDistance()
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

    public function getImage()
    {
        if ($this->image) {
            return '/' . $this->image;
        }

        return '/images/icons/cars/1.jpg';
    }
}
