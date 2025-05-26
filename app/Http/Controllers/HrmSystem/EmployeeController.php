<?php

namespace App\Http\Controllers\HrmSystem;

use Auth;
use App\Models\Plan;
use App\Models\User;
use App\Models\Branch;
use App\Models\Utility;
use App\Models\Documents;
use App\Models\Employees;
use App\Models\Department;
use App\Helpers\MailHelper;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use App\Models\EmployeeDocument;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Node\Block\Document;
use App\Http\Requests\StoreEmployeeRequest;

class EmployeeController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if (!$user->can('manage employee')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $employeesQuery = Employees::with(['designation', 'branch', 'department']);
        if ($user->type === 'Employee') {
            $employees = $employeesQuery->where('user_id', $user->id)->get();
        } else {
            $employees = $employeesQuery->where('created_by', $user->creatorId())->get();
        }
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if($user->can('create employee'))
        {
            $company_settings = Utility::settings();
            $documents        = Documents::where('created_by', $user->creatorId())->get();
            $branches         = Branch::where('created_by', $user->creatorId())->get()->pluck('name', 'id');
            $departments      = Department::where('created_by',$user->creatorId())->get()->pluck('name', 'id');
            $designations     = Designation::where('created_by', $user->creatorId())->get()->pluck('name', 'id');
            $employees        = User::where('created_by', $user->creatorId())->get();
            $defaultBranchId  = $branches->keys()->first();
            // echo $defaultBranchId;die;
            $employeesId      = CustomHelper::employeeIdFormat($defaultBranchId) . $this->employeeNumber($defaultBranchId);
            // dd($employeesId);
            // print_r($employeesId);die;
            return view('employee.create', compact('employees', 'employeesId', 'departments', 'designations', 'documents', 'branches', 'company_settings'));
        }else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function employeeNumber($branch_id)
    {
        $latest = Employees::where('branch_id', $branch_id)
            ->orderByDesc('id')
            ->first();
            $nextNumber = $latest ? ((int) filter_var($latest->employee_id, FILTER_SANITIZE_NUMBER_INT) + 1) : 1;
            $number = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            // print_r($number);die;
            return $number;
    }

    public function getEmployeeId($branch_id)
    {
        $id = CustomHelper::employeeIdFormat($branch_id) . self::employeeNumber($branch_id);
        return response()->json(['employee_id' => $id]);
    }

    public function getDepartments(Request $request)
    {
        $branchId = $request->branch_id;
        $departments = Department::where('branch_id', $branchId)->pluck('name', 'id');
        return response()->json($departments);
    }

    public function getDesignations(Request $request)
    {
        $departmentId = $request->department_id;
        $designations = Designation::where('department_id', $departmentId)->pluck('name', 'id');
        return response()->json($designations);
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create employee')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'dob' => 'required',
                'phone' => 'required|unique:employees,phone',
                'address' => 'required',
                'email' => 'required|email|unique:employees',
                'password' => 'required',
                'branch_id' => 'required',
                'department_id' => 'required',
                'designation_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->errors()->first());
            }

            $objUser = User::find(\Auth::user()->creatorId());
            $total_employee = $objUser->countEmployees();
            $plan = Plan::find($objUser->plan);

            if ($total_employee >= $plan->max_users && $plan->max_users != -1) {
                return redirect()->back()->with('error', __('Your employee limit is over, Please upgrade plan.'));
            }

            $plainPassword = $request['password'];

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($plainPassword),
                'type' => 'employee',
                'lang' => 'en',
                'created_by' => \Auth::user()->creatorId(),
            ]);
            $user->assignRole('Employee');
            $document_implode = $request->document ? implode(',', array_keys($request->document)) : null;
            $employee = Employees::create([
                'user_id' => $user->id,
                'name' => $request['name'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'email' => $request['email'],
                'password' => Hash::make($plainPassword),
                // 'biometric_emp_id' => '-',
                'branch_id' => $request['branch_id'],
                'employee_id' => CustomHelper::employeeIdFormat($request['branch_id']).$this->employeeNumber($request['branch_id']),
                'department_id' => $request['department_id'],
                'designation_id' => $request['designation_id'],
                'company_doj' => $request['company_doj'],
                'documents' => $document_implode,
                'account_holder_name' => $request['account_holder_name'],
                'account_number' => $request['account_number'],
                'bank_name' => $request['bank_name'],
                'bank_ifsc_code' => $request['bank_ifsc_code'],
                'branch_location' => $request['branch_location'],
                'tax_payer_id' => $request['tax_payer_id'],
                'created_by' => \Auth::user()->creatorId(),
            ]);

            if ($request->hasFile('document')) {
                foreach ($request->document as $key => $documentFile) {
                    $filenameWithExt = $documentFile->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $documentFile->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $documentFile->storeAs('uploads/document', $fileNameToStore, 'public');
                    EmployeeDocument::create([
                        'employee_id' => $employee->id,
                        'document_id' => $key,
                        'document_value' => $fileNameToStore,
                        'created_by' => \Auth::user()->creatorId(),
                    ]);
                }
            }
            $setings = Utility::settings();
            if (!empty($setings['new_user']) && $setings['new_user'] == 1) {
                $userArr = [
                    'email' => $user->email,
                    'password' => $plainPassword,
                ];
                $resp = MailHelper::sendEmailTemplate('new_user', [$user->id => $user->email], $userArr);
                return redirect()->route('employee.index')->with(
                    'success',
                    __('Employee successfully created.') .
                    ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error']))
                        ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : '')
                );
            }
            return redirect()->route('employee.index')->with('success', __('Employee successfully created.'));
        }
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        if($user->can('view employee'))
        {
            try {
                $empId       = Crypt::decrypt($id);
                // print_r($empId);die;
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Employee Not Found.'));
            }
            $empId        = Crypt::decrypt($id);
            $documents    = Documents::where('created_by', $user->creatorId())->get();
            $branches     = Branch::where('created_by', $user->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', $user->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', $user->creatorId())->get()->pluck('name', 'id');
            $employee     = Employees::where('id',$empId)->first();
            return view('employee.show', compact('employee', 'branches', 'departments', 'designations', 'documents'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invalid Employee ID.'));
        }
        $user = auth()->user();
        // print_r($user);die;
        if ($user->can('edit employee')) {
            $employee = Employees::findOrFail($id);
            if (!$employee) {
                return redirect()->back()->with('error', __('Employee not found.'));
            }
            $creatorId     = $user->creatorId();
            $documents     = Documents::where('created_by', $creatorId)->get();
            $branches      = Branch::where('created_by', $creatorId)->get()->pluck('name', 'id');
            $departments   = Department::where('created_by', $creatorId)->get()->pluck('name', 'id');
            $designations  = Designation::where('created_by', $creatorId)->get()->pluck('name', 'id');
            $defaultBranchId  = $branches->keys()->first();
            $employeesId      = CustomHelper::employeeIdFormat($defaultBranchId) . $this->employeeNumber($defaultBranchId);
            $departmentData = Department::where('created_by', $creatorId)
                ->where('branch_id', $employee->branch_id)
                ->get()
                ->pluck('name', 'id');

            return view('employee.edit', compact(
                'employee',
                'employeesId',
                'branches',
                'departments',
                'designations',
                'documents',
                'departmentData'
            ));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if (!\Auth::user()->can('edit employee')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make($request->all(), [
            'name'    => 'required',
            'dob'     => 'required',
            'gender'  => 'required',
            'phone'   => 'required|numeric',
            'address' => 'required',
            // 'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }

        $employee = Employees::findOrFail($id);

        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $key => $file) {
                if (!empty($file)) {
                    $originalName     = $file->getClientOriginalName();
                    $filename         = pathinfo($originalName, PATHINFO_FILENAME);
                    $extension        = $file->getClientOriginalExtension();
                    $fileNameToStore  = $filename . '_' . time() . '.' . $extension;
                    $dir              = 'uploads/document/';

                    // Delete old file if exists
                    $oldDoc = EmployeeDocument::where('employee_id', $employee->employee_id)
                                              ->where('document_id', $key)
                                              ->first();
                    if ($oldDoc && File::exists(public_path($dir . $oldDoc->document_value))) {
                        File::delete(public_path($dir . $oldDoc->document_value));
                    }

                    // Upload new file
                    $upload = Utility::upload_coustom_file($request, 'document', $fileNameToStore, $dir, $key, []);
                    if ($upload['flag'] != 1) {
                        return redirect()->back()->with('error', __($upload['msg']));
                    }

                    // Save or update document record
                    $employee_document = $oldDoc ?? new EmployeeDocument();
                    $employee_document->employee_id    = $employee->id;
                    $employee_document->document_id    = $key;
                    $employee_document->document_value = $fileNameToStore;
                    $employee_document->save();
                }
            }
        }

        $employee->fill($request->all())->save();
        $user = User::find($employee->user_id);
        if ($user) {
            $user->name  = $employee->name;
            $user->email = $employee->email;
            $user->save();
        }

        // Redirect based on condition
        if ($request->salary) {
            return redirect()->route('setsalary.index')->with('success', 'Employee successfully updated.');
        }

        if (\Auth::user()->type != 'employee') {
            return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
        }

        return redirect()->route('employee.show', \Crypt::encrypt($employee->id))->with('success', 'Employee successfully updated.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if($user->can('delete employee'))
        {
            $employee      = Employees::findOrFail($id);
            $user          = User::where('id', '=', $employee->user_id)->first();
            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
            $employee->delete();
            $user->delete();
            $dir = storage_path('uploads/document/');
            foreach($emp_documents as $emp_document)
            {
                $emp_document->delete();
                if(!empty($emp_document->document_value))
                {
                    unlink($dir . $emp_document->document_value);
                }
            }
            return redirect()->route('employee.index')->with('success', 'Employee successfully deleted.');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function fileImport()
    {
        return view('employee.import');
    }

    public function fileImportModal()
    {
        return view('employee.import_modal');
    }
}
