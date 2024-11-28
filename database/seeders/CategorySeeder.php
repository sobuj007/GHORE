<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg
        DB::table('categories')->insert([
            //admin
            [
                'name' =>  'Wax',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],
            [
                'name' =>  'Wax2',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],
            [
                'name' =>  'Wax3',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],
            [
                'name' =>  'Wax4',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],
            [
                'name' =>  'Wax5',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],
            [
                'name' =>  'Wax6',
                'image' => 'https://as1.ftcdn.net/v2/jpg/04/33/36/10/1000_F_433361028_pKPWRqtZkmXQKAcNYFZ2sY0m04SWx7uc.jpg',

            ],


        ]);
    }
}
