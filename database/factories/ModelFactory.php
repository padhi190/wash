<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'role_id' => 1,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {

    return [
    	'branch_id' => App\Branch::all()->random()->id,
        'name' => $faker->name,
        'sex' => $faker->randomElement($array=array('Laki-laki','Perempuan')),
        'phone' => $faker->phoneNumber,
        'join_date' => $faker->date($format = 'd-m-Y', $max = 'now'),
        'note' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'email' => $faker->safeEmail
    ];
});

$factory->define(App\Vehicle::class, function (Faker\Generator $faker) {

    return [
    	'customer_id' => App\Customer::all()->random()->id,
        'type' => $faker->randomElement($array = array('mobil', 'motor')),
        'brand' => $faker->randomElement($array = array('Toyota', 'Suzuki', 'Honda', 'Mitsubishi', 'BMW')),
        'model' => $faker->randomElement($array = array('Innova', 'Altis', 'Yaris', 'Ertiga', '520', 'CR-V', 'HR-V', 'Brio')),
        'color' => $faker->randomElement($array = array('Hitam', 'Putih', 'Silver', 'Merah', 'Biru')),
        'license_plate' => 'D '. $faker->numberBetween($min = 1, $max = 2000 ) . ' ' . $faker->stateAbbr,
        'note' => $faker->sentence($nbWords = 3, $variableNbWords = true)
    ];
});

$factory->define(App\Income::class, function (Faker\Generator $faker) {

    return [
    	'branch_id' => App\Branch::all()->random()->id,
    	'vehicle_id' => App\Vehicle::all()->random()->id,
    	'entry_date' => $faker->dateTimeBetween($startDate='-1 months', $endDate='+1 months')->format('d-m-Y H:i'),
    	'income_category_id' => App\IncomeCategory::all()->random()->id,
    	'qty' => 1,
    	'amount' => $faker->randomElement($array = array(4000, 40000, 45000, 50000, 700000, 900000, 1000000)),
        'wax_amount' => $faker->randomElement($array = array(0, 60000)),
        'fnb_amount' => $faker->randomElement($array = array(0, 3000, 6000, 8000, 12000)),
    	'payment_type_id' => App\Account::all()->random()->id
    ];
});

$factory->define(App\Expense::class, function (Faker\Generator $faker) {

    return [
    	'branch_id' => App\Branch::all()->random()->id,
    	'expense_category_id' => App\ExpenseCategory::all()->random()->id,
    	'entry_date' => $faker->dateTimeBetween($startDate='-1 months', $endDate='+1 months')->format('d-m-Y'),
    	'amount' => $faker->randomElement($array = array(50000, 60000, 100000, 200000)),
    	'from_id' => App\Account::all()->random()->id
    ];
});

$factory->define(App\Transfer::class, function (Faker\Generator $faker) {

    return [
    	'branch_id' => App\Branch::all()->random()->id,
    	'tanggal' => $faker->dateTimeBetween($startDate='-1 months', $endDate='+1 months')->format('d-m-Y H:i'),
    	'jumlah' => $faker->randomElement($array = array(500000, 1000000, 2000000)),
    	'dari_id' => App\Account::all()->random()->id,
    	'ke_id' => App\Account::all()->random()->id,
    	'note' => $faker->sentence($nbWords = 3, $variableNbWords = true)
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {

    return [
    	'branch_id' => App\Branch::all()->random()->id,
    	'due_date' => $faker->dateTimeBetween($startDate='-1 months', $endDate='+1 months')->format('d-m-Y'),
    	'approval_date' => '',
    	'kendaraan_id' => App\Vehicle::all()->random()->id,
    	'status_id' => App\TaskStatus::all()->random()->id,
    	'description' => $faker->sentence($nbWords = 3, $variableNbWords = true)
    	 // 'branch_id' => 1, 'kendaraan_id' => 2, 'description' => null, 'status_id' => 2, 'due_date' => '23-02-2017', 'approval_date' => ''
    ];
});