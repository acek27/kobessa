<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class setiapMenit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setiapMenit:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Data Setiap Menit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $waktu = date("Y-m-d h:i:sa");
        DB::table('notif')->insert([
            'waktunotif' => $waktu,
            'isinotif' => "Notif Sukses!"
            
        ]);
        echo "Perintah Berhasil Dijalankan!";
    }
}
