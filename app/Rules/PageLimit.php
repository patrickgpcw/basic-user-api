<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PageLimit implements Rule
{
    private $quantity;
    private $totalItems;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($quantity, $totalItems)
    {
        $this->quantity = $quantity;
        $this->totalItems = $totalItems;

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
        return $value <= ceil($this->totalItems / $this->quantity);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.page_limit');
    }
}
