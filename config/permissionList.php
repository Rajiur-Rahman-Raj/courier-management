<?php

$arr = [
	"Manage_Branch" => [
		"Branch_List" => [
			'label' => "Branch List",
			'permission' => [
				'view' => ['branchList', 'showBranchProfile'],
				'add' => ['createBranch', 'branchStore'],
				'edit' => ['branchEdit'],
				'delete' => [],
			],
		],
		"Branch_Manager" => [
			'label' => "Branch Manager",
			'permission' => [
				'view' => [],
				'add' => [],
				'edit' => [],
				'delete' => [],
			],
		],
		"Employee_List" => [
			'label' => "Employee List",
			'permission' => [
				'view' => ['branchEmployeeList'],
				'add' => ['createEmployee'],
				'edit' => ['branchEmployeeEdit'],
				'delete' => [],
			],
		],
	],

	'Manage_Department' => [
		"Department_List" => [
			'label' => "Department List",
			'permission' => [
				'view' => ['departmentList'],
				'add' => ['createDepartment', 'departmentStore'],
				'edit' => ['departmentEdit'],
				'delete' => [],
			],
		],
	],
];

return $arr;
