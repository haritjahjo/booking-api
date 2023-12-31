<?php

namespace App\Rules;

use Closure;
use App\Models\Booking;
use App\Models\Apartment;
use Illuminate\Contracts\Validation\ValidationRule;

class ApartmentAvailableRule implements ValidationRule
{
    protected array $data = [];
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $apartment = Apartment::find($value);
        if (!$apartment) {
            $fail('Sorry, this apartment is not found');
        }
        if ($apartment->capacity_adults < $this->data['guests_adults']
          || $apartment->capacity_children < $this->data['guests_children']) {
            $fail('Sorry, this apartment does not fit all your guests');
        }
        if (Booking::where('apartment_id', $value)
            ->validForRange([$this->data['start_date'], $this->data['end_date']])
            ->exists()) {
            $fail('Sorry, this apartment is not available for those dates');
        }
    }

    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }
}
