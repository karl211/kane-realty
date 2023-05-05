<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Expense::create([
            'particular_id' => $new_particular->id,
            'date' => ($particular->date) ? $particular->date : null,
            'receipt_no' => ($particular->receipt_no) ? $particular->receipt_no : null,
            'agents_commission_san_vicente' => ($particular->agents_commission_san_vicente) ? $particular->agents_commission_san_vicente : null,
            'agents_commission_tiniwisan' => ($particular->agents_commission_tiniwisan) ? $particular->agents_commission_tiniwisan : null,
            'salary' => ($particular->salary) ? $particular->salary : null,
            'office_rental_expense' => ($particular->office_rental_expense) ? $particular->office_rental_expense : null,
            'utility_expense' => ($particular->utility_expense) ? $particular->utility_expense : null,
            'fuel_gasoline' => ($particular->fuel_gasoline) ? $particular->fuel_gasoline : null,
            'office_materials' => ($particular->office_materials) ? $particular->office_materials : null,
            'repair_maintenance' => ($particular->repair_maintenance) ? $particular->repair_maintenance : null,
            'representation_expense' => ($particular->representation_expense) ? $particular->representation_expense : null,
            'transportation' => ($particular->transportation) ? $particular->transportation : null,
            'retainers' => ($particular->retainers) ? $particular->retainers : null,
            'lot_cancellation' => ($particular->lot_cancellation) ? $particular->lot_cancellation : null,
            'web_system_development' => ($particular->web_system_development) ? $particular->web_system_development : null,
            'others' => ($particular->others) ? $particular->others : null,
        ]);
    }
}
