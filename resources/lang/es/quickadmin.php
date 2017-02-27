<?php

return [
	'create' => 'Crear',
	'save' => 'Guardar',
	'edit' => 'Editar',
	'view' => 'Ver',
	'update' => 'Actualizar',
	'list' => 'Listar',
	'no_entries_in_table' => 'Sin valores en la tabla',
	'custom_controller_index' => 'Índice del controlador personalizado (index).',
	'logout' => 'Salir',
	'add_new' => 'Agregar',
	'are_you_sure' => 'Estás seguro?',
	'back_to_list' => 'Regresar a la lista?',
	'dashboard' => 'Tablero',
	'delete' => 'Eliminar',
	'quickadmin_title' => 'Wash Inc',
		'user-management' => [		'title' => 'Manajemen User',		'created_at' => 'Time',		'fields' => [		],	],
		'roles' => [		'title' => 'Wewenang',		'created_at' => 'Time',		'fields' => [			'title' => 'Judul',		],	],
		'users' => [		'title' => 'Pengguna',		'created_at' => 'Time',		'fields' => [			'name' => 'Nama',			'email' => 'Email',			'password' => 'Password',			'role' => 'Wewenang',			'remember-token' => 'Ingat token',			'branch' => 'Branch',		],	],
		'settings' => [		'title' => 'Settings',		'created_at' => 'Time',		'fields' => [		],	],
		'expense-category' => [		'title' => 'Expense Categories',		'created_at' => 'Time',		'fields' => [			'name' => 'Name',		],	],
		'income-category' => [		'title' => 'Income categories',		'created_at' => 'Time',		'fields' => [			'name' => 'Name',			'price' => 'Harga',		],	],
		'income' => [		'title' => 'Income',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'vehicle' => 'Kendaraan',			'entry-date' => 'Tanggal',			'income-category' => 'Kategori',			'product' => 'Produk (opsional)',			'qty' => 'Qty',			'amount' => 'Harga',			'discount' => 'Discount',			'payment-type' => 'Cara Pembayaran',			'note' => 'Note',		],	],
		'expense' => [		'title' => 'Expenses',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'expense-category' => 'Kategori',			'employee' => 'Karyawan',			'entry-date' => 'Tanggal',			'amount' => 'Jumlah',			'from' => 'Dari',			'note' => 'Note',		],	],
		'monthly-report' => [		'title' => 'Monthly report',		'created_at' => 'Time',		'fields' => [		],	],
		'branch' => [		'title' => 'Cabang',		'created_at' => 'Time',		'fields' => [			'branch-name' => 'Nama Cabang',			'address' => 'Alamat',			'city' => 'Kota',			'phone' => 'Phone',		],	],
		'customer' => [		'title' => 'Customer',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'name' => 'Nama',			'sex' => 'Jenis Kelamin',			'phone' => 'Phone',			'join-date' => 'Tanggal',			'note' => 'Note',		],	],
		'vehicle' => [		'title' => 'Kendaraan',		'created_at' => 'Time',		'fields' => [			'license-plate' => 'Plat No.',			'customer' => 'Customer',			'type' => 'Type',			'brand' => 'Brand',			'model' => 'Model',			'color' => 'Warna',			'size' => 'Size',			'note' => 'Note',		],	],
		'task-calendar' => [		'title' => 'Calendar',		'created_at' => 'Time',		'fields' => [		],	],
		'account' => [		'title' => 'Account',		'created_at' => 'Time',		'fields' => [			'name' => 'Nama',			'account-no' => 'No. rek',			'holder-name' => 'Atas Nama',			'branch' => 'Cabang Account',		],	],
		'transfer' => [		'title' => 'Transfer',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'tanggal' => 'Tanggal',			'dari' => 'Dari',			'ke' => 'Ke',			'jumlah' => 'Jumlah',			'note' => 'Note',		],	],
		'task-calendar' => [		'title' => 'Calendar',		'created_at' => 'Time',		'fields' => [		],	],
		'task-management' => [		'title' => 'Task Management',		'created_at' => 'Time',		'fields' => [		],	],
		'task-statuses' => [		'title' => 'Statuses',		'created_at' => 'Time',		'fields' => [			'name' => 'Name',		],	],
		'task-tags' => [		'title' => 'Tags',		'created_at' => 'Time',		'fields' => [			'name' => 'Name',		],	],
		'tasks' => [		'title' => 'Salon',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'kendaraan' => 'Kendaraan',			'description' => 'Deskripsi Pekerjaan',			'status' => 'Status',			'tag' => 'Tags',			'due-date' => 'Tanggal Masuk',			'approval-date' => 'Tanggal Keluar',		],	],
		'task-calendar' => [		'title' => 'Calendar',		'created_at' => 'Time',		'fields' => [		],	],
		'employees' => [		'title' => 'Daftar Karyawan',		'created_at' => 'Time',		'fields' => [			'name' => 'Nama',			'gender' => 'Jenis Kelamin',			'join-date' => 'Tanggal Bergabung',			'posisi' => 'Posisi',			'status' => 'Aktif?',			'branch' => 'Cabang',		],	],
		'product-management' => [		'title' => 'Product Management',		'created_at' => 'Time',		'fields' => [		],	],
		'categories' => [		'title' => 'Categories',		'created_at' => 'Time',		'fields' => [			'name' => 'Category name',			'description' => 'Description',			'photo' => 'Photo (max 8Mb)',		],	],
		'tags' => [		'title' => 'Tags',		'created_at' => 'Time',		'fields' => [			'name' => 'Name',		],	],
		'products' => [		'title' => 'Products',		'created_at' => 'Time',		'fields' => [			'name' => 'Product name',			'description' => 'Description',			'price' => 'Price',			'category' => 'Category',			'tag' => 'Tag',			'photo1' => 'Photo 1',			'photo2' => 'Photo 2',			'photo3' => 'Photo 3',		],	],
		'absensi' => [		'title' => 'Absensi',		'created_at' => 'Time',		'fields' => [			'branch' => 'Cabang',			'tanggal' => 'Tanggal',			'karyawan' => 'Karyawan',			'note' => 'Note',		],	],
		'user-actions' => [		'title' => 'Tindakan Pengguna',		'created_at' => 'Time',		'fields' => [			'user' => 'Pengguna',			'action' => 'Tindakan',			'action-model' => 'Model tindakan',			'action-id' => 'id tindakan',		],	],
];