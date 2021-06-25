<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'user.view'],
            ['name' => 'user.add'],
            ['name' => 'user.update'],
            ['name' => 'user.delete'],
            ['name' => 'user.role'],

            ['name' => 'supplier.view'],
            ['name' => 'supplier.add'],
            ['name' => 'supplier.update'],
            ['name' => 'supplier.delete'],

            ['name' => 'customer.view'],
            ['name' => 'customer.add'],
            ['name' => 'customer.update'],
            ['name' => 'customer.delete'],
            ['name' => 'customer_group.view'],

            ['name' => 'product.view'],
            ['name' => 'product.add'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],

            ['name' => 'purchase.view'],
            ['name' => 'purchase.add'],
            ['name' => 'purchase.update'],
            ['name' => 'purchase.delete'],
            ['name' => 'purchase_return.add'],
            ['name' => 'purchase_return.view'],
            ['name' => 'purchase_payment.view'],
            ['name' => 'purchase_payment.add'],
            ['name' => 'purchase_payment.return'],

            ['name' => 'sell.view'],
            ['name' => 'sell.add'],
            ['name' => 'sell.update'],
            ['name' => 'sell.delete'],
            ['name' => 'sell_return.add'],
            ['name' => 'sell_return.view'],
            ['name' => 'sell_payment.view'],
            ['name' => 'sell_payment.add'],
            ['name' => 'sell_payment.return'],

            ['name' => 'purchase_n_sell_report.view'],
            ['name' => 'contacts_report.view'],
            ['name' => 'stock_report.view'],
            ['name' => 'tax_report.view'],
            ['name' => 'trending_product_report.view'],
            ['name' => 'register_report.view'],
            ['name' => 'sales_representative.view'],
            ['name' => 'expense_report.view'],

            ['name' => 'brand.view'],
            ['name' => 'brand.add'],
            ['name' => 'brand.update'],
            ['name' => 'brand.delete'],

            ['name' => 'unit.view'],
            ['name' => 'unit.add'],
            ['name' => 'unit.update'],
            ['name' => 'unit.delete'],

            ['name' => 'category.view'],
            ['name' => 'category.add'],
            ['name' => 'category.update'],
            ['name' => 'category.delete'],

            ['name' => 'variation.view'],
            ['name' => 'variation.add'],
            ['name' => 'variation.update'],
            ['name' => 'variation.delete'],

            ['name' => 'tax_rate.view'],
            ['name' => 'tax_rate.add'],
            ['name' => 'tax_rate.update'],
            ['name' => 'tax_rate.delete'],

            ['name' => 'stock_transfer.view'],
            ['name' => 'stock_transfer.add'],
            ['name' => 'stock_transfer.update'],

            ['name' => 'expense.add'],
            ['name' => 'expense.update'],
            ['name' => 'expense.view'],
            ['name' => 'expense.delete'],
            
            ['name' => 'expense_category.view'],
            ['name' => 'expense_category.add'],
            ['name' => 'expense_category.delete'],
            ['name' => 'expense_category.update'],

            ['name' => 'settings.business'],
            ['name' => 'settings.locations'],

        ];

        $insert_data = [];
        $time_stamp = Carbon::now()->toDateTimeString();
        foreach ($data as $d) {
            $d['guard_name'] = 'api';
            $d['created_at'] = $time_stamp;
            $insert_data[] = $d;
        }
        Permission::insert($insert_data);
    }
}
