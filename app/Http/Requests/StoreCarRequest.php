<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id' => 'required',
            'model_id' => 'required',
            'year' => 'required|integer|min:1900|max:'.date('Y'),
            'car_type_id' => 'required|exists:car_types,id',
            'price' => 'required|integer|min:10',
            'vin' => 'nullable|string|size:17',
            'mileage' => 'required|integer|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|min:7|max:20',
            'features' => 'array',
            'features.*' => 'string',
            'description' => 'nullable|string|max:3000',
            'published_at' => 'nullable|date',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9024',
        ];
    }

    public function messages()
    {
        return [
        //    'required' => 'This field is required',
        ];
    }

    public function attributes()
    {
        return [
            'maker_id' => 'maker',
            'model_id' => 'model',
            'car_type_id' => 'car type',
            'fuel_type_id' => 'fuel type',
            'city_id' => 'city',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'vin' => mb_strtoupper($this->vin)
        ]);
    }

}
