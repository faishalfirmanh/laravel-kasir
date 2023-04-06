<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;
class RulesCekPriceLessThan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    
    protected $id_product;
    public function __construct($id_product)
    {
        $this->id_product = $id_product;

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
        $product = Product::find($this->id_product);
        if ($product != NULL) {
           $beli = (int) $product->harga_beli;
           if ($value < $beli) {
            
                return false;
           }else{
           
                return true;
           }
        }else{
           
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Price sell less than price buy';
    }
}
