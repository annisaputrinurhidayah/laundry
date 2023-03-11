<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('outlets')->insert([
            [
                'nama' => 'Toko Annisa Laundry',
                'alamat' => 'Padaherang',
                'tlp' => '081234567890',
            ],
            [
                'nama' => 'Toko Puput Laundry',
                'alamat' => 'Kalipucang',
                'tlp' => '081212121212',
            ],

        ]);
        DB::table('users')->insert([
            [
                'nama' => 'Administrator',
                'username' => 'admin',
                'password' => bcrypt('1234'),
                'foto' => 'nisa.jpg',
                'role' => 'admin',
                'outlet_id' => 1,
            ],
            [
                'nama' => 'Kasir',
                'username' => 'kasir',
                'password' => bcrypt('1234'),
                'foto' => 'nisa.jpg',
                'role' => 'kasir',
                'outlet_id' => 1,
            ],
            [
                'nama' => 'Pemilik',
                'username' => 'owner',
                'password' => bcrypt('1234'),
                'foto' => 'nisa.jpg',
                'role' => 'owner',
                'outlet_id' => 1,
            ],
        ]);
        DB::table('members')->insert([
            [
                'nama' => 'Annisa',
                'jenis_kelamin' => 'P',
                'foto' => 'nisa.jpg',
                'alamat' => 'Korea',
                'tlp' => '0888333444',
            ],
        ]);
       

    }
}
