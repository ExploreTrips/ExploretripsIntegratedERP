<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',

            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'phone' => 'nullable|string|max:10',
            'address' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:8',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certificate' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:2048',

            'employee_id' => 'required|string|max:255|unique:employees,employee_id',
            'company_doj' => 'required|date',
            // 'documents' => 'nullable|string',

            // Bank details (optional)
            'account_holder_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_ifsc_code' => 'nullable|string|max:20',
            'branch_location' => 'nullable|string|max:255',
            'tax_payer_id' => 'nullable|string|max:20',
            'salary_type' => 'nullable|integer',
            'salary' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
        ];
    }
}
