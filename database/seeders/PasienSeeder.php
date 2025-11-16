<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use Faker\Factory as Faker;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 25; $i++) {
            Pasien::create([
                'noreg'         => 'REG-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama'          => $faker->name,
                'tempat_lahir'  => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2015-12-31'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'nomor_hp'      => $faker->phoneNumber,
            ]);
        }
    }
}
