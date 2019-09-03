<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotEquals implements Rule
{
    private $notEquals;

    /**
     * Create a new rule instance.
     *
     * @param array|string $notEqualsArr
     */
    public function __construct($notEquals)
    {
        $this->notEquals = $notEquals;
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
}
