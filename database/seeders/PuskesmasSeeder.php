<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PuskesmasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'code'          => 'PKM-001',
                'name'          => 'Puskesmas Sugih Waras',
                'district'      => 'Rambang',
                'officer_name'  => 'Siti Bulkis, S.Tr, Gz',
                'officer_email' => 'siti.bulkis@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-002',
                'name'          => 'Puskesmas Kelekar',
                'district'      => 'Kelekar',
                'officer_name'  => 'Ichi Shakti Rafiah, A.Md.Gz',
                'officer_email' => 'ichi.shakti.rafiah@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-003',
                'name'          => 'Puskesmas Gunung Megang',
                'district'      => 'Gunung Megang',
                'officer_name'  => 'Meitriyani, AMG',
                'officer_email' => 'meitriyani@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-004',
                'name'          => 'Puskesmas Muara Enim',
                'district'      => 'Muara Enim',
                'officer_name'  => 'Aminah Andriani, AMG, SKM',
                'officer_email' => 'aminah.andriani@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-005',
                'name'          => 'Puskesmas Teluk Lubuk',
                'district'      => 'Belimbing',
                'officer_name'  => 'Windah Ismijranti, S.Gz',
                'officer_email' => 'windah.ismijranti@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-006',
                'name'          => 'Puskesmas Sumaja Makmur',
                'district'      => 'Gunung Megang',
                'officer_name'  => 'Ika Monika, S.Tr.Keb',
                'officer_email' => 'ika.monika@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-007',
                'name'          => 'Puskesmas Lembak',
                'district'      => 'Lembak',
                'officer_name'  => 'Rohmaniyah, S. Tr. Keb',
                'officer_email' => 'rohmaniyah@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-008',
                'name'          => 'Puskesmas Pajar Bulan',
                'district'      => 'Semende Darat Ulu',
                'officer_name'  => 'Lini Pisti, A.Md.Kep',
                'officer_email' => 'lini.pisti@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-009',
                'name'          => 'Puskesmas Pulau Panggung',
                'district'      => 'Semende Darat Laut',
                'officer_name'  => 'Nurhidayati, A.Md.Gz',
                'officer_email' => 'nurhidayati@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-010',
                'name'          => 'Puskesmas Tanjung Agung',
                'district'      => 'Tanjung Agung',
                'officer_name'  => 'Bella Ristanty, S.Tr. Gz',
                'officer_email' => 'bella.ristanty@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-011',
                'name'          => 'Puskesmas Tanjung Raya',
                'district'      => 'Semende Darat Tengah',
                'officer_name'  => 'Nia Maghfirah',
                'officer_email' => 'nia.maghfirah@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-012',
                'name'          => 'Puskesmas Tanjung Enim',
                'district'      => 'Lawang Kidul',
                'officer_name'  => 'Renti Delfina, A.Md.Gz',
                'officer_email' => 'renti.delfina@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-013',
                'name'          => 'Puskesmas Ujan Mas',
                'district'      => 'Ujan Mas',
                'officer_name'  => 'Welli Novita, AMG',
                'officer_email' => 'welli.novita@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-014',
                'name'          => 'Puskesmas Benakat',
                'district'      => 'Benakat',
                'officer_name'  => 'Friska Adhisty, Amd.Keb',
                'officer_email' => 'friska.adhisty@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-015',
                'name'          => 'Puskesmas Tebat Agung',
                'district'      => 'Rambang Niru',
                'officer_name'  => 'Gita Almira, A.Md.Gz',
                'officer_email' => 'gita.almira@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-016',
                'name'          => 'Puskesmas Muara Emburung',
                'district'      => 'Rambang Niru',
                'officer_name'  => 'Miati, A.Md.Gz',
                'officer_email' => 'miati@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-017',
                'name'          => 'Puskesmas Beringin',
                'district'      => 'Lubai',
                'officer_name'  => 'Nini Ulan Dari, A.Md.Gz',
                'officer_email' => 'nini.ulan.dari@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-018',
                'name'          => 'Puskesmas Sumber Mulya',
                'district'      => 'Lubai Ulu',
                'officer_name'  => 'Regita Cahyani',
                'officer_email' => 'regita.cahyani@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-019',
                'name'          => 'Puskesmas Belida Darat',
                'district'      => 'Belida Darat',
                'officer_name'  => 'Juli Artika, Am, Keb',
                'officer_email' => 'juli.artika@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-020',
                'name'          => 'Puskesmas Gelumbang',
                'district'      => 'Gelumbang',
                'officer_name'  => 'Betti sunaini, SKM',
                'officer_email' => 'betti.sunaini@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-021',
                'name'          => 'Puskesmas Sukarami',
                'district'      => 'Sungai Rotan',
                'officer_name'  => 'Asnara AMG',
                'officer_email' => 'asnara@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-022',
                'name'          => 'Puskesmas Muara Belida',
                'district'      => 'Muara Belida',
                'officer_name'  => 'Latifah Khairunnisak',
                'officer_email' => 'latifah.khairunnisak@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-023',
                'name'          => 'Puskesmas Empat Petulai',
                'district'      => 'Empat Petulai Dangku',
                'officer_name'  => 'Mirdiana, AM. Keb',
                'officer_email' => 'mirdiana@muaraenimkab.go.id',
            ],
            [
                'code'          => 'PKM-024',
                'name'          => 'Puskesmas Panang Enim',
                'district'      => 'Panang Enim',
                'officer_name'  => 'Bella Oktalena, S.Gz',
                'officer_email' => 'bella.oktalena@muaraenimkab.go.id',
            ],
        ];

        foreach ($data as $row) {
            // Insert / update puskesmas
            $puskesmas = Puskesmas::firstOrCreate(
                ['code' => $row['code']],
                [
                    'name'      => $row['name'],
                    'address'   => 'Kecamatan ' . $row['district'] . ', Kabupaten Muara Enim',
                    'district'  => $row['district'],
                    'phone'     => '-',  // supaya aman kalau kolom NOT NULL
                    'is_active' => true,
                ]
            );

            // Akun petugas puskesmas
            User::firstOrCreate(
                ['email' => $row['officer_email']],
                [
                    'name'          => $row['officer_name'],
                    'password'      => Hash::make('password'), // GANTI di produksi
                    'role'          => 'puskesmas',
                    'puskesmas_id'  => $puskesmas->id,
                    'is_active'     => true,
                ]
            );
        }
    }
}
