<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\Address;
use Botble\Ecommerce\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('customers');

        Customer::query()->truncate();
        Address::query()->truncate();

        $names = [
            'John Smith',
            'Sarah Johnson',
            'Michael Brown',
            'Emily Davis',
            'David Wilson',
            'Jessica Taylor',
            'Robert Anderson',
            'Amanda Thomas',
            'William Martinez',
            'Jennifer Garcia',
        ];

        $countryCodes = ['US', 'CA', 'GB', 'AU', 'DE', 'FR'];
        $states = ['California', 'New York', 'Texas', 'Florida', 'Illinois', 'Pennsylvania'];
        $cities = ['Los Angeles', 'New York City', 'Houston', 'Miami', 'Chicago', 'Philadelphia'];
        $addresses = [
            '123 Main Street',
            '456 Oak Avenue',
            '789 Pine Road',
            '321 Elm Boulevard',
            '654 Maple Drive',
            '987 Cedar Lane',
        ];
        $zipCodes = ['90001', '10001', '77001', '33101', '60601', '19101'];

        $customers = [
            'customer@botble.com',
            'john.smith@botble.com',
        ];

        foreach ($customers as $index => $item) {
            $customer = Customer::query()->create([
                'name' => $names[$index],
                'email' => $item,
                'password' => Hash::make('12345678'),
                'phone' => '+1' . rand(2000000000, 9999999999),
                'avatar' => 'customers/' . rand(1, 10) . '.jpg',
                'dob' => Carbon::now()->subYears(rand(20, 50))->subDays(rand(1, 30)),
            ]);

            $customer->confirmed_at = Carbon::now();
            $customer->save();

            Address::query()->create([
                'name' => $customer->name,
                'phone' => '+1' . rand(2000000000, 9999999999),
                'email' => $customer->email,
                'country' => Arr::random($countryCodes),
                'state' => Arr::random($states),
                'city' => Arr::random($cities),
                'address' => Arr::random($addresses),
                'zip_code' => Arr::random($zipCodes),
                'customer_id' => $customer->id,
                'is_default' => true,
            ]);

            Address::query()->create([
                'name' => $customer->name,
                'phone' => '+1' . rand(2000000000, 9999999999),
                'email' => $customer->email,
                'country' => Arr::random($countryCodes),
                'state' => Arr::random($states),
                'city' => Arr::random($cities),
                'address' => Arr::random($addresses),
                'zip_code' => Arr::random($zipCodes),
                'customer_id' => $customer->id,
                'is_default' => false,
            ]);
        }

        $additionalEmails = [
            'michael.brown@example.com',
            'emily.davis@example.com',
            'david.wilson@example.com',
            'jessica.taylor@example.com',
            'robert.anderson@example.com',
            'amanda.thomas@example.com',
            'william.martinez@example.com',
            'jennifer.garcia@example.com',
        ];

        for ($i = 0; $i < 8; $i++) {
            $customer = Customer::query()->create([
                'name' => $names[$i + 2],
                'email' => $additionalEmails[$i],
                'password' => Hash::make('12345678'),
                'phone' => '+1' . rand(2000000000, 9999999999),
                'avatar' => 'customers/' . ($i + 1) . '.jpg',
                'dob' => Carbon::now()->subYears(rand(20, 50))->subDays(rand(1, 30)),
            ]);

            $customer->confirmed_at = Carbon::now();
            $customer->save();

            Address::query()->create([
                'name' => $customer->name,
                'phone' => '+1' . rand(2000000000, 9999999999),
                'email' => $customer->email,
                'country' => Arr::random($countryCodes),
                'state' => Arr::random($states),
                'city' => Arr::random($cities),
                'address' => Arr::random($addresses),
                'zip_code' => Arr::random($zipCodes),
                'customer_id' => $customer->id,
                'is_default' => true,
            ]);
        }
    }
}
