<?php

namespace Database\Seeders;

use App\Models\Sku;
use App\Models\Bank;
use App\Models\Care;
use App\Models\Head;
use App\Models\User;
use App\Models\Brand;
use App\Models\Hscode;
use App\Models\Source;
use App\Models\Subhead;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Material;
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
        $this->seedHscode();
        $this->adminSeeder();
        $this->seedBank();
        $this->seedMaterial();
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
            'title' => 'HAIDER VALVE WALA',
            'source_id' => '1',
            'email' => ''
        ]);
        Supplier::Create([
            'title' => 'ARIF TAMBAWALA',
            'source_id' => '1',
            'email' => ''
        ]);
        Supplier::Create([
            'title' => 'ABDULLAH BHAI',
            'source_id' => '1',
            'email' => ''
        ]);
        Supplier::Create([
            'title' => 'TIANJIN BAOLAI INTERNATIONAL TRADE 	',
            'source_id' => '2',
            'email' => '',
            'address' => '1-A,1ST FLOOR,PLOT NO 8-391-A, K/S 1024, ALLAN BALIK'
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
        Head::create([
            'id' => 32,
            'title' => 'SUPPLIER'
        ]);
        Head::create([
            'id' => 33,
            'title' => 'CUSTOMER'
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
            'title'=> 'Local Stock Item',
            'nick' => 'LOC'
        ]);
        Category::create([
            'title'=> 'Imported Stock',
            'nick' => 'IMP'
        ]);
        Category::create([
            'title'=> 'Khokar Lahore',
            'nick' => 'KHL'
        ]);
        Category::create([
            'title'=> 'Mughal',
            'nick' => 'MUGHAL'
        ]);
    }

    public function seedDimensions()
    {
        Dimension::create([
            'title' => '6" X SCH 80 X 6M'
        ]);
        Dimension::create([
            'title' => '8" X SCH 40 X 6M'
        ]);
        Dimension::create([
            'title' => '1-1/4" X SCH 40 X 6.1M'
        ]);
        Dimension::create([
            'title' => '1/2" X SCH 40 X 6.1M'
        ]);
        Dimension::create([
            'title' => '3/8" X SCH 40 X 6.1M'
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

    public function seedHscode()
    {
        Hscode::Create([
            'hscode' => '7034.3900',
            'cd' => 15.360,
            'st' => 17,
            'rd' => 5,
            'acd' => 4,
            'ast' => 3,
            'it' => 5.5,
            'wse' => 1
        ]);
    }

    public function seedBank()
    {
        Bank::create([
            'title' => 'Allied Bank Limited',
            'nick' => 'ABL',
            'account_no' => 'ABL333232',
            'branch' => 'Gulistan-E-Johar',
            'address' => 'Near Munawar Chowrangi',
            'balance' => 450755
        ]);
        Bank::create([
            'title' => 'United Bank Limited',
            'nick' => 'UBL',
            'account_no' => '344-343-132032',
            'branch' => 'S.I.T.E',
            'address' => 'Near Where',
            'balance' => 3150735
        ]);
    }

    public function seedMaterial()
    {
        Material::create([
            'title' => 'CARBON STEEL SEAMLESS PIPE',
            'nick' => 'CSSP',
            'category_id' => 2,
            'brand_id' => 1,
            'source_id' => 2,
            'dimension_id' => 1,
            'sku_id' => 1,
            'hscode_id' => 1,
            'category' => 'IMPORTED STOCK',
            'brand' => 'AMRELLI STEEL',
            'source' => 'IMPORTED',
            'dimension' => '8" X SCH 40 X 6M',
            'sku' => 'KG',

        ]);
        Material::create([
            'title' => 'CARBON STEEL SEAMLESS PIPE',
            'nick' => 'CSSP',
            'category_id' => 2,
            'brand_id' => 1,
            'source_id' => 2,
            'dimension_id' => 2,
            'sku_id' => 1,
            'hscode_id' => 1,
            'category' => 'IMPORTED STOCK',
            'brand' => 'AMRELLI STEEL',
            'source' => 'IMPORTED',
            'dimension' => '6" X SCH 80 X 6M',
            'sku' => 'KG',
        ]);
    }
}
