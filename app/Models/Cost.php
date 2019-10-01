<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'costs';

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
        'car_id', 
		//'side_number',
        'category_consumption',
        //'subcategory_consumption',
        'purchase_cost',
        'count',
        'work_price',
        'mileage',
        //'consumption_title',
		'notes',
        'created_at',
        'updated_at',
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
                //'notes'  => 'max:500',
				'car_id' => 'required',
                //'side_number' => 'required',
				'category_consumption' => 'required',
				//'subcategory_consumption' => 'required',
				'purchase_cost' => 'required',
				'count' => 'required',
				'work_price' => 'required',
				'mileage' => 'required',
				//'consumption_title' => 'required',
				'notes' => 'required',
				//'status' => 'required',
            ],
            $merge);
    }

    /**
     * Build Theme Relationships.
     *
     * @var array
     */
    public function car()
    {
        return $this->hasMany('App\Models\Car');
    }
}
