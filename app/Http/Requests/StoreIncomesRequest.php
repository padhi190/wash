<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_id' => 'required',
            'vehicle_id' => 'required',
            'entry_date' => 'required',
            'income_category_id' => 'required',
            
            'amount' => 'required|numeric',
            
            'payment_type_id' => 'required',
            'nobon' => 'unique_with:incomes,branch_id',
            
        ];
    }
}
