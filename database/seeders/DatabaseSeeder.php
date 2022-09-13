<?php

namespace Database\Seeders;

use App\Models\Sku;
use App\Models\Care;
use App\Models\Head;
use App\Models\User;
use App\Models\Brand;
use App\Models\Source;
use App\Models\Subhead;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Dimension;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->seedCare();
        $this->seedSupplier();
        $this->seedCustomers();
        $this->seedLocations();
        $this->seedHeads();
        $this->seedSubHeads();
        $this->seedCategories();
        $this->seedDimensions();
        $this->seedSources();
        $this->seedSkus();
        $this->seedBrands();
        $this->adminSeeder();
    }

    public function seedCare()
    {
        Care::Create([
            'title' => 'Someone',
        ]);
        Care::Create([
            'title' => 'OtherTwo',
        ]);
    }

    public function seedSupplier()
    {
        Supplier::Create([
            'title' => 'Aziz Packages',
            'source_id' => '1',
            'email' => 'aziz@g.com'
        ]);
        Supplier::Create([
            'title' => 'Omer Jibran',
            'source_id' => '1',
            'email' => 'oj@g.com'
        ]);
        Supplier::Create([
            'title' => 'Prime HR',
            'source_id' => '1',
            'email' => 'pj@g.com'
        ]);
        Supplier::Create([
            'title' => 'Thal Boshoko',
            'source_id' => '2',
            'email' => 'tb@g.com'
        ]);
    }

    public function seedCustomers()
    {
        Customer::create([
            'title' => 'Indus Motor',
            'care_id' => '1',
            'obalance' => '235000'
        ]);
        Customer::create([
            'title' => 'Suzuki Motor',
            'care_id' => '2',
            'obalance' => '785000'
        ]);
    }

    public function seedLocations()
    {
        Location::create([
            'title' => 'Port Qasim',
            'address' => 'PQA'
        ]);
        Location::create([
            'title' => 'Hub Balochistan',
            'address' => 'HUB'
        ]);
        Location::create([
            'title' => 'New Town',
            'address' => 'NWT'
        ]);
        Location::create([
            'title' => 'Baldia',
            'address' => 'Baldia'
        ]);
        Location::create([
            'title' => 'SITE',
            'address' => 'S.I.T.E'
        ]);
    }

    public function seedHeads()
    {
        Head::create([
            'title' => 'CAPITAL',
        ]);
        Head::create([
            'title' => 'DRAWING',
        ]);
        Head::create([
            'title' => 'EXPENSES',
            'nature' => 1
        ]);
        Head::create([
            'title' => 'FIXED ASSETS',
        ]);
        Head::create([
            'title' => 'INCOME TAX',
            'nature' => 1
        ]);
        Head::create([
            'title' => 'INVESTMENT',
        ]);
        Head::create([
            'title' => 'LOANS & ADVANCES',
        ]);
        Head::create([
            'title' => 'LONG TERM LIABILITY',
        ]);
        Head::create([
            'title' => 'MAIN HEAD ACCOUNT',
        ]);
        Head::create([
            'title' => 'NEW HEAD',
            'nature' => 1
        ]);
        Head::create([
            'title' => 'OTHER INCOME',
        ]);
        Head::create([
            'title' => 'OTHER PAYABLE',
        ]);
        Head::create([
            'title' => 'OTHER RECEIVABLE',
        ]);
        Head::create([
            'title' => 'SALE TAX REFUNDABLE',
        ]);
        Head::create([
            'title' => 'TAX PAYABLE',
        ]);
    }

    public function seedSubheads()
    {
        Subhead::create([
            'head_id' => 1,
            'title' => 'BAHRIA PROPERTY',
            'ob' => 5000
        ]);
        Subhead::create([
            'head_id' => 1,
            'title' => 'PLOT# E-13 (NEW GODOWN)',
            'ob' => 3000
        ]);
        Subhead::create([
            'head_id' => 1,
            'title' => 'EVERY VAN FRO SCHOOL',
            'ob' => 25000
        ]);
        Subhead::create([
            'head_id' => 2,
            'title' => 'SAAD IMPORT',
            'ob' => 150000
        ]);
        Subhead::create([
            'head_id' => 4,
            'title' => 'SALARY OFFICE/GODOWN EXPENSE',
            'ob' => 6000
        ]);
        Subhead::create([
            'head_id' => 4,
            'title' => 'Kamra Bhai',
            'ob' => 5000
        ]);
        Subhead::create([
            'head_id' => 6,
            'title' => 'USMAN PAKISTAN',
            'ob' => 20000
        ]);
        Subhead::create([
            'head_id' => 4,
            'title' => 'TRANSPORT ACCOUNTS',
            'ob' => 20000
        ]);
    }

    public function seedCategories()
    {
        Category::create([
            'title'=> 'Automotives',
            'nick' => 'AUTO'
        ]);
        Category::create([
            'title'=> 'Health Care Products',
            'nick' => 'HCP'
        ]);
        Category::create([
            'title'=> 'Alternate Building Materials',
            'nick' => 'ABM'
        ]);
    }

    public function seedDimensions()
    {
        Dimension::create([
            'title' => '2x3'
        ]);
        Dimension::create([
            'title' => '14"'
        ]);
        Dimension::create([
            'title' => 'Dozen Pack'
        ]);
        Dimension::create([
            'title' => '36 each'
        ]);
    }

    public function seedSources()
    {
        Source::create([
            'title' => 'Local'
        ]);
        Source::create([
            'title' => 'Imported'
        ]);
    }

    public function seedSkus()
    {
        Sku::create([
            'title' => 'KG'
        ]);
        Sku::create([
            'title' => 'METER'
        ]);
        Sku::create([
            'title' => 'INCHES'
        ]);
        Sku::create([
            'title' => 'BARREL'
        ]);
        Sku::create([
            'title' => 'PACKET'
        ]);
    }

    public function seedBrands()
    {
        Brand::create([
            'title' => 'Amrelli Steel'
        ]);
        Brand::create([
            'title' => 'Agha Steel'
        ]);
        Brand::create([
            'title' => 'Auvitronics'
        ]);
        Brand::create([
            'title' => 'Honda Atlas'
        ]);
        Brand::create([
            'title' => 'Procter & Gamble'
        ]);
    }


    public function adminSeeder()
    {
        User::create([
            'name' => 'M.Usman',
            'email' => 'usman@auvitronics.com',
            'password' => bcrypt('abc123')
        ]);
        User::create([
            'name' => 'Ali Jibran',
            'email' => 'ali.jibran@auvitronics.com',
            'password' => bcrypt('abc123')
        ]);
    }
}
