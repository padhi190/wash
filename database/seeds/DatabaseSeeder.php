<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(BranchSeed::class);
        $this->call(EmployeeSeed::class);
        $this->call(AbsensiSeed::class);
        $this->call(AccountSeed::class);
        $this->call(CategorySeed::class);
        $this->call(CustomerSeed::class);
        $this->call(ExpenseCategorySeed::class);
        $this->call(ExpenseSeed::class);
        $this->call(IncomeCategorySeed::class);
        $this->call(ProductSeed::class);
        $this->call(VehicleSeed::class);
        $this->call(IncomeSeed::class);
        $this->call(RoleSeed::class);
        $this->call(TaskStatusSeed::class);
        $this->call(TaskSeed::class);
        $this->call(TransferSeed::class);
        $this->call(UserSeed::class);
        $this->call(ProductSeedPivot::class);

    }
}
