<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\BranchEmployee;
use App\Models\BranchManager;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use App\Traits\Upload;

class BranchController extends Controller
{
	use Upload;

	public function branchList(Request $request)
	{

		$search = $request->all();
		$data['allBranches'] = Branch::when(isset($search['name']), function ($query) use ($search) {
				return $query->whereRaw("branch_name REGEXP '[[:<:]]{$search['name']}[[:>:]]'");
			})
			->when(isset($search['phone']), function ($q) use ($search) {
				return $q->where('phone', $search['phone']);
			})
			->when(isset($search['email']), function ($q2) use ($search) {
				return $q2->where('email', $search['email']);
			})
			->when(isset($search['status']) && $search['status'] == 'active', function ($q3) use ($search) {
				return $q3->where('status', 1);
			})
			->when(isset($search['status']) && $search['status'] == 'deactive', function ($q4) use ($search) {
				return $q4->where('status', 0);
			})
			->when(isset($search['branch_type']) && $search['branch_type'] == 'head_office', function ($q5) use ($search) {
				return $q5->where('branch_type', $search['branch_type']);
			})
			->when(isset($search['branch_type']) && $search['branch_type'] == 'main_branch', function ($q6) use ($search) {
				return $q6->where('branch_type', $search['branch_type']);
			})
			->when(isset($search['branch_type']) && $search['branch_type'] == 'sub_branch', function ($q7) use ($search) {
				return $q7->where('branch_type', $search['branch_type']);
			})
			->paginate(config('basic.paginate'));

		return view('admin.branch.index', $data);
	}

	public function createBranch()
	{
		return view('admin.branch.create');
	}

	public function branchStore(Request $request)
	{

		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));
		$branchType = ['head_office', 'main_branch', 'sub_branch'];

		$rules = [
			'branch_type' => ['required', Rule::in($branchType)],
			'branch_name' => ['required', 'max:60', 'string'],
			'email' => ['email', 'nullable', 'max:100'],
			'phone' => ['numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'details' => ['required', 'max:2000'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_type.required' => 'Branch type field is required',
			'branch_name.required' => 'Branch name field is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}


		$branch = new Branch();

		$branch->branch_type = $request->branch_type;
		$branch->branch_name = $request->branch_name;
		$branch->email = $request->email;
		$branch->phone = $request->phone;
		$branch->address = $request->address;
		$branch->details = $request->details;
		$branch->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branch.path'));
				if ($image) {
					$branch->image = $image['path'] ?? null;
					$branch->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branch->save();
		return back()->with('success', 'Branch Created Successfully!');
	}

	public function branchEdit($id)
	{
		$data['singleBranchInfo'] = Branch::findOrFail($id);
		return view('admin.branch.edit', $data);
	}

	public function branchUpdate(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));
		$branchType = ['head_office', 'main_branch', 'sub_branch'];

		$rules = [
			'branch_type' => ['required', Rule::in($branchType)],
			'branch_name' => ['required', 'max:60', 'string'],
			'email' => ['email', 'nullable', 'max:100'],
			'phone' => ['numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'details' => ['required', 'max:2000'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_type.required' => 'Branch type field is required',
			'branch_name.required' => 'Branch name field is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$branch = Branch::findOrFail($id);

		$branch->branch_type = $request->branch_type;
		$branch->branch_name = $request->branch_name;
		$branch->email = $request->email;
		$branch->phone = $request->phone;
		$branch->address = $request->address;
		$branch->details = $request->details;
		$branch->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branch.path'));
				if ($image) {
					$branch->image = $image['path'] ?? null;
					$branch->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branch->save();
		return back()->with('success', 'Branch Updated Successfully!');
	}

	public function showBranchProfile($id)
	{
		$data['branchInfo'] = Branch::findOrFail($id);
		return view('admin.branch.profile', $data);
	}


	public function branchManagerList(Request $request){

		$search = $request->all();

		$data['allBranchManagers'] = BranchManager::with('branch', 'admin')
			->when(isset($search['manager']), function ($query) use ($search){
				return $query->whereHas('admin', function ($q) use ($search) {
					$q->whereRaw("name REGEXP '[[:<:]]{$search['manager']}[[:>:]]'");
				});
			})
			->when(isset($search['branch']), function ($query) use ($search){
				return $query->whereHas('branch', function ($q) use ($search) {
					$q->whereRaw("branch_name REGEXP '[[:<:]]{$search['branch']}[[:>:]]'");
				});
			})
			->when(isset($search['phone']), function ($q) use ($search) {
				return $q->where('phone', $search['phone']);
			})
			->when(isset($search['email']), function ($q2) use ($search) {
				return $q2->where('email', $search['email']);
			})
			->when(isset($search['status']) && $search['status'] == 'active', function ($q3) use ($search) {
				return $q3->where('status', 1);
			})
			->when(isset($search['status']) && $search['status'] == 'deactive', function ($q4) use ($search) {
				return $q4->where('status', 0);
			})
			->paginate(config('basic.paginate'));
		return view('admin.branchManager.index', $data);
	}

	public function createBranchManager(){
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['allRoles']  = Role::where('status', 1)->get();
		return view('admin.branchManager.create', $data);
	}

	public function branchManagerStore(Request $request){

		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'branch_id' => ['required', 'exists:branches,id'],
			'role_id' => ['required', 'exists:roles,id'],
			'branch_manager_id' => ['required', 'exists:admins,id'],
			'email' => ['required', 'email'],
			'phone' => ['required', 'numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'national_id' => ['nullable', 'max:100'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_id.required' => 'Please select a branch',
			'role_id.required' => 'Please select a role',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$branchManager = new BranchManager();

		$branchManager->branch_id = $request->branch_id;
		$branchManager->role_id = $request->role_id;
		$branchManager->admin_id = $request->branch_manager_id;
		$branchManager->email = $request->email;
		$branchManager->phone = $request->phone;
		$branchManager->address = $request->address;
		$branchManager->national_id = $request->national_id;
		$branchManager->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branchManager.path'));
				if ($image) {
					$branchManager->image = $image['path'] ?? null;
					$branchManager->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branchManager->save();
		return back()->with('success', 'Branch Manager Created Successfully!');
	}

	public function branchManagerEdit($id){
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['allRoles']  = Role::where('status', 1)->get();
		$data['singleBranchManagerInfo'] = BranchManager::with('branch', 'admin')->findOrFail($id);
		$data['allManagers'] = Admin::where('role_id', $data['singleBranchManagerInfo']->role_id)->get();

		return view('admin.branchManager.edit', $data);
	}

	public function branchManagerUpdate(Request $request, $id){

		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'branch_id' => ['required', 'exists:branches,id'],
			'role_id' => ['required', 'exists:roles,id'],
			'branch_manager_id' => ['required', 'exists:admins,id'],
			'email' => ['required', 'email'],
			'phone' => ['required', 'numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'national_id' => ['nullable', 'max:100'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_id.required' => 'Please select a branch',
			'role_id.required' => 'Please select a role',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$branchManager = BranchManager::findOrFail($id);

		$branchManager->branch_id = $request->branch_id;
		$branchManager->role_id = $request->role_id;
		$branchManager->admin_id = $request->branch_manager_id;
		$branchManager->email = $request->email;
		$branchManager->phone = $request->phone;
		$branchManager->address = $request->address;
		$branchManager->national_id = $request->national_id;
		$branchManager->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branchManager.path'));
				if ($image) {
					$branchManager->image = $image['path'] ?? null;
					$branchManager->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branchManager->save();
		return back()->with('success', 'Branch Manager Updated Successfully!');
	}

	public function branchEmployeeList(Request $request){

		$search = $request->all();

		$data['allBranchEmployees'] = BranchEmployee::with('branch', 'admin', 'department')
			->when(isset($search['branch']), function ($query) use ($search){
				return $query->whereHas('branch', function ($q) use ($search) {
					$q->whereRaw("branch_name REGEXP '[[:<:]]{$search['branch']}[[:>:]]'");
				});
			})
			->when(isset($search['department']), function ($query) use ($search){
				return $query->whereHas('department', function ($q) use ($search) {
					$q->whereRaw("name REGEXP '[[:<:]]{$search['department']}[[:>:]]'");
				});
			})
			->when(isset($search['phone']), function ($q) use ($search) {
				return $q->where('phone', $search['phone']);
			})
			->when(isset($search['email']), function ($q2) use ($search) {
				return $q2->where('email', $search['email']);
			})
			->when(isset($search['status']) && $search['status'] == 'active', function ($q3) use ($search) {
				return $q3->where('status', 1);
			})
			->when(isset($search['status']) && $search['status'] == 'deactive', function ($q4) use ($search) {
				return $q4->where('status', 0);
			})
			->paginate(config('basic.paginate'));

		return view('admin.branchEmployee.index', $data);
	}

	public function createEmployee(){
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['allRoles']  = Role::where('status', 1)->get();
		$data['allDepartments']  = Department::where('status', 1)->get();
		return view('admin.branchEmployee.create', $data);
	}


	public function branchEmployeeStore(Request $request){

		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'branch_id' => ['required', 'exists:branches,id'],
			'role_id' => ['required', 'exists:roles,id'],
			'branch_employee_id' => ['required', 'exists:admins,id'],
			'department_id' => ['required', 'exists:departments,id'],
			'email' => ['required', 'email', 'nullable'],
			'phone' => ['required', 'numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'national_id' => ['nullable', 'max:100'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_id.required' => 'Please select a branch',
			'role_id.required' => 'Please select a role',
			'branch_employee_id.required' => 'Please select a employee',
			'department_id.required' => 'Please select a department',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$branchEmployee = new BranchEmployee();

		$branchEmployee->branch_id = $request->branch_id;
		$branchEmployee->role_id = $request->role_id;
		$branchEmployee->admin_id = $request->branch_employee_id;
		$branchEmployee->department_id = $request->department_id;
		$branchEmployee->email = $request->email;
		$branchEmployee->phone = $request->phone;
		$branchEmployee->address = $request->address;
		$branchEmployee->national_id = $request->national_id;
		$branchEmployee->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branchEmployee.path'));
				if ($image) {
					$branchEmployee->image = $image['path'] ?? null;
					$branchEmployee->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branchEmployee->save();
		return back()->with('success', 'Branch Employee Created Successfully!');
	}


	public function branchEmployeeEdit($id){
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['allRoles']  = Role::where('status', 1)->get();
		$data['allDepartments']  = Department::where('status', 1)->get();
		$data['singleBranchEmployeeInfo'] = BranchEmployee::with('branch', 'admin', 'department')->where('status', 1)->findOrFail($id);
		$data['allEmployees'] = Admin::where('role_id', $data['singleBranchEmployeeInfo']->role_id)->where('status', 1)->get();

		return view('admin.branchEmployee.edit', $data);
	}


	public function branchEmployeeUpdate(Request $request, $id){
		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'branch_id' => ['required', 'exists:branches,id'],
			'role_id' => ['required', 'exists:roles,id'],
			'branch_employee_id' => ['required', 'exists:admins,id'],
			'department_id' => ['required', 'exists:departments,id'],
			'email' => ['required', 'email', 'nullable'],
			'phone' => ['required', 'numeric', 'nullable'],
			'address' => ['required', 'max:2000'],
			'national_id' => ['nullable', 'max:100'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'branch_id.required' => 'Please select a branch',
			'role_id.required' => 'Please select a role',
			'branch_employee_id.required' => 'Please select a employee',
			'department_id.required' => 'Please select a department',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'address.required' => 'Address field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$branchEmployee = BranchEmployee::findOrFail($id);

		$branchEmployee->branch_id = $request->branch_id;
		$branchEmployee->role_id = $request->role_id;
		$branchEmployee->admin_id = $request->branch_employee_id;
		$branchEmployee->department_id = $request->department_id;
		$branchEmployee->email = $request->email;
		$branchEmployee->phone = $request->phone;
		$branchEmployee->address = $request->address;
		$branchEmployee->national_id = $request->national_id;
		$branchEmployee->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.branchEmployee.path'));
				if ($image) {
					$branchEmployee->image = $image['path'] ?? null;
					$branchEmployee->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$branchEmployee->save();
		return back()->with('success', 'Branch Employee Updated Successfully!');
	}

	public function branchStaffList($id){
		$data['branchStaffList'] = BranchEmployee::with('branch', 'admin', 'department')
		->where('branch_id', $id)
		->get();
		return view('admin.branchEmployee.staffList', $data);
	}















	public function getRoleUser(Request $request){
		$results = Admin::where('status', 1)->where('role_id', $request->id)->get();
		return response($results);
	}

	public function getRoleUserInfo(Request $request){
		$results = Admin::where('status', 1)->where('id', $request->id)->first();
		return response($results);
	}
}