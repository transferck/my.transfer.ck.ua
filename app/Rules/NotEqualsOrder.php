<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class NotEqualsOrder implements Rule
{
    private $notEquals;
    private $order;

    /**
     * Create a new rule instance.
     *
     * @param array|string $notEquals
     * @param Order $order
     */
    public function __construct($notEquals, Order $order = null)
    {
        $this->notEquals = $notEquals;
        $this->order = $order;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (count($this->notEquals) == 0) {
            return true;
        }

        if (!$this->isDirty($value)) {
            return true;
        }

        if (is_string($this->notEquals)) {
            return $value != $this->notEquals;
        }

        $inArray = in_array($value, $this->notEquals);

        return !$inArray;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':value not allowed.';
    }

    /**
     * Check is value in order dirty
     *
     * @param mixed $value
     * @return bool
     */
    private function isDirty($value): bool
    {
        if (!$this->order) {
            return false;
        }

        return $this->order->ticketfree_reason != $value;
    }
}
