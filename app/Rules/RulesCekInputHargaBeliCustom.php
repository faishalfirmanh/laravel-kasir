<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class RulesCekInputHargaBeliCustom implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_prd)
    {
        $this->id_prd = $id_prd;
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
        $product = Product::find($this->id_prd);
        if ($product != NULL) {
            if ( (int) $product->harga_beli > 0) {
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return 'Gagal, harga beli pada master product, harus diset 0';  
    }
}
