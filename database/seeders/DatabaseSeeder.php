<?php

namespace Database\Seeders;
use Faker\Factory as Faker;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function trans(){
        // Membuat data customer
        $faker = Faker::create();
        $agenda = ['KEBERSIHAN', 'KATERING', 'KEAMANAN', 'KOS-KOSAN', 'REFILL AIR'];
        foreach (range(1, 5) as $index) {
            $produkcode = 'P' . $faker->unique()->numberBetween(100, 999);
            $produkname = $faker->randomElement($agenda);
            $Pokok = $faker->randomFloat(2, 10, 1000);
            DB::table('tblmasterproduct')->insert([
                'productCode' => $produkcode,
                'companyid' => 1,
                'productName' => $produkname,
                'statusid' => 1,
                'producttypeid' => 1,
                'UserInsert' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 1,
                'UpdateDT' => now()
            ]);

            $apoinmentid = DB::table('tblagenda')->insertGetId([
                'Text' => $produkname,
                'companyid' => 1,
                'StartDate' => "2023-02-01 00:00:00.000",
                'EndDate' => '2023-02-02 00:00:00.000',
                'productCode' => $produkcode,
                'RecurrenceRule' => 'FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2',
                'userid' => 1,
                'statusid' => 1,
            ]);
            DB::table('tblbilling')->insert([
                'companyid' => 1,
                'userid' => 2,
                'AppointmentId' => $apoinmentid,
                // 'Pokok' => $Pokok + 1500,
                'statusid' => 1,
            ]);

        }
        $banks = ['BCA', 'BRI', 'Mandiri', 'QRIS', 'DANA', 'BNI'];
        $jt = ["2023-06-01 00:00:00.000","2023-05-01 00:00:00.000","2023-04-01 00:00:00.000","2023-03-01 00:00:00.000","2023-02-01 00:00:00.000"];
        foreach (range(1, 50) as $index) {
            DB::table('tbluser')->insert([
                'statusid' => 1,
                'companyidArray' => '1,2,',
                'email' => $faker->unique()->email(),
                'password' => Hash::make('admadm'),
                'nama' => $faker->name(),
                'hp' => $faker->phoneNumber(),
                'alamatSingkat' => $faker->streetAddress(),
                'alamatLengkap' => $faker->address(),
                'infoTambahan' => $faker->text(),
                'profileImg' => 'user/user.png',
                'UserInsert' => $faker->name(),
                'InsertDT' => now(),
                'UserUpdate' => $faker->name(),
                'UpdateDT' => now(),
            ]);
            DB::table('tblcomp')->insert([
                'companyname' => $faker->company,
                'statusid' => 1,
                'UserInsert' => 'system',
                'email' => $faker->unique()->email(),
                'hp' => $faker->phoneNumber(),
                'companyaddress' => $faker->address(),
                'producttypeArray' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 'system',
                'UpdateDT' => now(),
            ]);

            $notrans = 'DEV' . $faker->unique()->numberBetween(100, 999);
            $paymentid = $faker->numberBetween(1, 2);
            $billingid = $faker->numberBetween(1, 5);
            $Pokok = $faker->randomFloat(2, 10, 1000);

            DB::table('tbltrans')->insert([
                'notrans' => $notrans,
                'companyid' => 1,
                'userid' => 2,
                'billingid' => $billingid,
                'paymentid' => $paymentid,
                'jatuhTempoTagihan' => $faker->randomElement($jt),
                'SisaPok' => $Pokok,
                'statusid' => 7,
                'UserInsert' => '2',
                'transdate' => now(),
                'InsertDT' => now(),
                'UserUpdate' => '2',
                'UpdateDT' => now(),
            ]);

            DB::table('tblpaymenttrans')->insert([
                'notrans' => $notrans,
                'paymentid' => $paymentid,
                'statusid' => 1,
                'tglBayar' => now(),
                'tglVerifikasi' => now(),
                'total' => $Pokok,
                'totalPay' => $Pokok,
                'bank' => $faker->randomElement($banks),
                'va_number' => $faker->bankAccountNumber,
                'transaction_status' => 'Success',
                'transaction_time' => now(),
                'transaction_id' => $faker->uuid,
                'UserInsert' => '2',
                'InsertDT' => now(),
                'UserUpdate' => '2',
                'UpdateDT' => now(),
            ]);
        }
    }
    public function chat(){
        DB::table('tblchat')->insert([
            'companyid' => '1',
            'statusid' => 1,
            'userArray' => '[1,2]',
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
        ]);

        DB::table('tblchatd')->insert([
            [
            'chatid' => 1,
            'description' => 'Hello!',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Hi there!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'How are you?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'I am doing well, thanks for asking!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'What have you been up to?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Not much, just working a lot. How about you?',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Hello!',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Hi there!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'How are you?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'I am doing well, thanks for asking!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'What have you been up to?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Not much, just working a lot. How about you?',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Hello!',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Hi there!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'How are you?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'I am doing well, thanks for asking!',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'What have you been up to?',
            'userid' => '1',
            'statusid' => 1,
            'UserInsert' => '1',
            'InsertDT' => now(),
            'UserUpdate' => '2',
            'UpdateDT' => now(),
            ],
            [
            'chatid' => 1,
            'description' => 'Not much, just working a lot. How about you?',
            'userid' => '2',
            'statusid' => 1,
            'UserInsert' => '2',
            'InsertDT' => now(),
            'UserUpdate' => '1',
            'UpdateDT' => now(),
            ],
        ]);
    }

    public function run(): void
    {
        DB::table('tblcomp')->insert([
            'companyname' => 'Default2',
            'statusid' => 1,
            'UserInsert' => 'system',
            'email' => 'company2@comp.com',
            'hp' => '123456789',
            'companyaddress' => 'Jl. Merdeka No. 10, Kota Jakarta, DKI Jakarta',
            'producttypeArray' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);

        DB::table('tbluser')->insert([
            'companyidArray' => '1,',
            'companyid' => 2,
            'statusid' => 1,
            'superadmin' => 0,
            'email' => 'umum@gmail.com',
            'nama' => 'Umum Default',
            'hp' => '081234567890',
            'alamatSingkat' => 'Jl. Merdeka No. 10',
            'alamatLengkap' => 'Jl. Merdeka No. 10, Kota Jakarta, DKI Jakarta',
            'infoTambahan' => 'Suka memasak',
            'profileImg' => 'user/user.png',
            'password' => Hash::make('admadm'),
            'UserInsert' => 'system',
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);

        DB::table('tblproducttype')->insert([
            'companyid' => 1,
            'statusid' => 1,
            'productTypeName' => 'Produk Jasa',
            'UserInsert' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 1,
            'UpdateDT' => now()
        ]);
        DB::table('tblproducttype')->insert([
            'companyid' => 1,
            'statusid' => 1,
            'productTypeName' => 'Produk Digital',
            'UserInsert' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 1,
            'UpdateDT' => now()
        ]);
        DB::table('tblproducttype')->insert([
            'companyid' => 1,
            'statusid' => 1,
            'productTypeName' => 'Produk Fisik',
            'UserInsert' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 1,
            'UpdateDT' => now()
        ]);
        DB::table('tblproducttype')->insert([
            'companyid' => 1,
            'statusid' => 1,
            'productTypeName' => 'Produk Campuran',
            'UserInsert' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 1,
            'UpdateDT' => now()
        ]);
      
        // $this->trans();

        // $this->chat();
    }
}
