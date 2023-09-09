<?php

$arr = [
	'Manage_Branch' => [
		[
			'label' => "Branch List",
			'permission' => [
				'view' => ['branchList', 'showBranchProfile'],
				'add' => ['createBranch', 'branchStore'],
				'edit' => ['branchEdit'],
				'delete' => [],
			],
		],
		[
			'label' => "Branch Manager",
			'permission' => [
				'view' => [],
				'add' => [],
				'edit' => [],
				'delete' => [],
			],
		],
		[
			'label' => "Employee List",
			'permission' => [
				'view' => ['branchEmployeeList'],
				'add' => [],
				'edit' => [],
				'delete' => [],
			],
		],
	],

	'Manage_Department' => [
		[
			'label' => "Department List",
			'permission' => [
				'view' => ['departmentList'],
				'add' => [],
				'edit' => [],
				'delete' => [],
			],
		],
	],
];

return $arr;
