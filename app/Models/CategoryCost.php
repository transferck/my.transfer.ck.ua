<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryCost extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_costs';

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
        'name', 
        'position',
		'img', 
		'group',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    public static $GROUPS = [
        'default', 'support_repair', 'others'
    ];

    public static $GROUPS_LABELS = [
        '' => 'Не выбрано',
        'default' => 'Без заголовка',
        'support_repair' => 'Обслуживание и ремонт',
        'others' => 'Прочее',
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
                //'name'   => 'required|min:3|max:50|unique:categorycosts,name'.($id ? ",$id" : ''),
				'name' => 'required',
				//'img' => 'required',
				'position' => 'required',
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

    public function costsByCar(Car $car)
    {
        $sum = 0;
        $costs = Cost::query()
            ->where('category_consumption', $this->id)
            ->where('car_id', $car->id)
            ->get();

        if ($costs->isEmpty()) {
            return (object) compact('costs', 'sum');
        }

        foreach ($costs as $cost) {
            $sum += $cost->purchase_cost + $cost->work_price;
        }

        return (object) compact('costs', 'sum');
    }

    public static function getInGroups()
    {
        $results = [];
        foreach (self::$GROUPS as $group) {
            $results[$group] = self::query()
                ->where('group', $group)
                ->orderBy('position', 'DESC')
                ->get();
        }

        return $results;
    }
}
