<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NomorCaborSeeder extends Seeder
{
    public function run()
    {
        $jenjang = ['SD','SMP','SMA'];
        $kategoriDefault = ['Putra','Putri'];

        // ================= FULL 114 CABOR – STANDAR POPDA =================
        $master = [

            // 3 ATLETIK
            3 => [
                ['nama'=>'Lari 100 Meter','detail'=>'100m'],
                ['nama'=>'Lari 200 Meter','detail'=>'200m'],
                ['nama'=>'Lari 400 Meter','detail'=>'400m'],
                ['nama'=>'Lompat Jauh','detail'=>null],
                ['nama'=>'Lompat Tinggi','detail'=>null],
                ['nama'=>'Tolak Peluru','detail'=>null],
            ],

            // 5 BOLA VOLI INDOOR
            5 => [ ['nama'=>'Bola Voli','detail'=>'6 vs 6'] ],

            // 6 SENAM ARTISTIK
            6 => [ ['nama'=>'Serba Bisa','detail'=>null] ],

            // 7 SENAM
            7 => [ ['nama'=>'Aerobik','detail'=>null] ],

            // 8 FUTSAL
            8 => [ ['nama'=>'Futsal','detail'=>'5 vs 5'] ],

            // 9 SEPAK BOLA
            9 => [ ['nama'=>'Sepak Bola','detail'=>'11 vs 11'] ],

            // 10 TAEKWONDO
            10 => [
                ['nama'=>'Kyorugi','detail'=>'-45 Kg'],
                ['nama'=>'Kyorugi','detail'=>'-48 Kg'],
                ['nama'=>'Poomsae','detail'=>null],
            ],

            // 11 ANGKAT BESI
            11 => [ ['nama'=>'Total Angkatan','detail'=>'Kg'] ],

            // 14 PANJAT TEBING
            14 => [
                ['nama'=>'Lead','detail'=>null],
                ['nama'=>'Speed','detail'=>null],
            ],

            // 15 SEPAK TAKRAW
            15 => [ ['nama'=>'Regu','detail'=>null] ],

            // 16 BOLA VOLI PASIR
            16 => [ ['nama'=>'Voli Pasir','detail'=>'2 vs 2'] ],

            // 17 PANAHAN
            17 => [ ['nama'=>'Recurve','detail'=>'70m'] ],

            // 18 PETANQUE
            18 => [ ['nama'=>'Triple','detail'=>null] ],

            // 19 CATUR
            19 => [ ['nama'=>'Perorangan','detail'=>null] ],

            // 20 WUSHU
            20 => [ ['nama'=>'Taolu','detail'=>null], ['nama'=>'Sanda','detail'=>'-56 Kg'] ],

            // 21 BILIARD
            21 => [ ['nama'=>'9 Ball','detail'=>null] ],

            // 22 GOLF
            22 => [ ['nama'=>'Stroke Play','detail'=>null] ],

            // 23 BOLA BASKET
            23 => [ ['nama'=>'5 vs 5','detail'=>null], ['nama'=>'3 vs 3','detail'=>null] ],

            // 24 GULAT
            24 => [ ['nama'=>'Freestyle','detail'=>'-55 Kg'] ],

            // 25 PARALAYANG
            25 => [ ['nama'=>'Akurasi','detail'=>null] ],

            // 26 TENIS LAPANGAN
            26 => [ ['nama'=>'Tunggal','detail'=>null], ['nama'=>'Ganda','detail'=>null] ],

            // 27 TARUNG DERAJAT
            27 => [ ['nama'=>'Tarung','detail'=>'-60 Kg'] ],

            // 28 SEPATU RODA
            28 => [ ['nama'=>'Speed','detail'=>'500m'] ],

            // 29 JUDO
            29 => [ ['nama'=>'Tanding','detail'=>'-46 Kg'] ],

            // 30 ANGGAR
            30 => [ ['nama'=>'Floret','detail'=>null] ],

            // 31 TINJU
            31 => [ ['nama'=>'Tinju','detail'=>'-52 Kg'] ],

            // 32 RENANG
            32 => [ ['nama'=>'50m Gaya Bebas','detail'=>'50m'], ['nama'=>'100m Gaya Bebas','detail'=>'100m'] ],

            // 33 TENIS MEJA
            33 => [ ['nama'=>'Tunggal','detail'=>null] ],

            // 34 BALAP SEPEDA
            34 => [ ['nama'=>'Time Trial','detail'=>null] ],

            // 35 MENEMBAK
            35 => [ ['nama'=>'Air Rifle','detail'=>'10m'] ],

            // 36 SQUASH
            36 => [ ['nama'=>'Perorangan','detail'=>null] ],

            // 37 WOOD BALL
            37 => [ ['nama'=>'Fairway','detail'=>null] ],

            // 38 PENCAK SILAT
            38 => [ ['nama'=>'Tanding','detail'=>'Kelas A'], ['nama'=>'Seni Tunggal','detail'=>null] ],

            // 39 SOFT TENNIS
            39 => [ ['nama'=>'Ganda','detail'=>null] ],

            // 40 MUAYTHAI
            40 => [ ['nama'=>'Fight','detail'=>'-54 Kg'] ],

            // 41 DAYUNG
            41 => [ ['nama'=>'Perahu Naga','detail'=>'500m'] ],

            // 42 BERKUDA
            42 => [ ['nama'=>'Equestrian','detail'=>null] ],

            // 43 AEROMODELLING
            43 => [ ['nama'=>'F2A','detail'=>null] ],

            // 44 KARATE
            44 => [ ['nama'=>'Kumite','detail'=>'-55 Kg'], ['nama'=>'Kata','detail'=>null] ],

            // 45 GANTOLLE
            45 => [ ['nama'=>'Akurasi','detail'=>null] ],

            // 46 TERBANG LAYANG
            46 => [ ['nama'=>'Akurasi','detail'=>null] ],

            // 47 TERJUN PAYUNG
            47 => [ ['nama'=>'Akurasi','detail'=>null] ],

            // 48 BINARAGA
            48 => [ ['nama'=>'Men Physique','detail'=>null] ],

            // 49 BASEBALL / SOFTBALL
            49 => [ ['nama'=>'Softball','detail'=>null] ],

            // 50 BALAP MOTOR
            50 => [ ['nama'=>'Road Race','detail'=>'150cc'] ],

            // 51 BOLA TANGAN
            51 => [ ['nama'=>'Handball','detail'=>null] ],

            // 52 BRIDGE
            52 => [ ['nama'=>'Beregu','detail'=>null] ],

            // 53 BULUTANGKIS
            53 => [ ['nama'=>'Tunggal','detail'=>null], ['nama'=>'Ganda','detail'=>null], ['nama'=>'Ganda Campuran','detail'=>null,'kategori'=>'Campuran'] ],

            // 54 CRICKET
            54 => [ ['nama'=>'T20','detail'=>null] ],

            // 55 DANCESPORT
            55 => [ ['nama'=>'Latin','detail'=>null] ],

            // 56 GATEBALL
            56 => [ ['nama'=>'Beregu','detail'=>null] ],

            // 57 HOCKEY
            57 => [ ['nama'=>'Field Hockey','detail'=>null] ],

            // 58 KEMPO
            58 => [ ['nama'=>'Kumite','detail'=>'-55 Kg'] ],

            // 59 LAYAR
            59 => [ ['nama'=>'Optimist','detail'=>null] ],

            // 60 SELAM
            60 => [ ['nama'=>'Fin Swimming','detail'=>'50m'] ],

            // 61 GYMNASTIC
            61 => [ ['nama'=>'Artistic','detail'=>null] ],

            // 62 E-SPORT
            62 => [ ['nama'=>'Mobile Legends','detail'=>'Tim'], ['nama'=>'PUBG Mobile','detail'=>'Squad'] ],

            // 63 SKATEBOARDING
            63 => [ ['nama'=>'Street','detail'=>null] ],

            // 64 SAMBO
            64 => [ ['nama'=>'Sport','detail'=>'-58 Kg'] ],

            // 65 KURASH
            65 => [ ['nama'=>'Tanding','detail'=>'-60 Kg'] ],

            // 66 CANOEING
            66 => [ ['nama'=>'Sprint','detail'=>'500m'] ],

            // 67 LONCAT INDAH
            67 => [ ['nama'=>'3 Meter','detail'=>null] ],

            // 68 KICK BOXING
            68 => [ ['nama'=>'Full Contact','detail'=>'-60 Kg'] ],

            // 111–114 PARA CABOR
            111 => [ ['nama'=>'Lari 100 Meter','detail'=>'T12'] ],
            112 => [ ['nama'=>'Tunggal','detail'=>'SL4'] ],
            113 => [ ['nama'=>'50m Gaya Bebas','detail'=>'S10'] ],
            114 => [ ['nama'=>'Tunggal','detail'=>'TT8'] ],
        ];

        $data = [];
        foreach ($master as $caborId => $nomors) {
            foreach ($nomors as $nomor) {
                foreach ($jenjang as $j) {
                    if (($nomor['kategori'] ?? null) === 'Campuran') {
                        $data[] = [
                            'cabor_id'=>$caborId,
                            'nama'=>$nomor['nama'],
                            'jenjang'=>$j,
                            'kategori'=>'Campuran',
                            'detail'=>$nomor['detail']
                        ];
                    } else {
                        foreach ($kategoriDefault as $k) {
                            $data[] = [
                                'cabor_id'=>$caborId,
                                'nama'=>$nomor['nama'],
                                'jenjang'=>$j,
                                'kategori'=>$k,
                                'detail'=>$nomor['detail']
                            ];
                        }
                    }
                }
            }
        }

        $this->db->table('nomor_cabor')->insertBatch($data);
    }
}
