<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class BelajarController extends Controller
{
    public function cache(Request $request)
    {
        $data = Cache::remember('users', now()->addMinutes(5), function () {
            return User::get();
        });
        return view('belajar.cache', compact('data'));
    }
    public function enkripsi()
    {
        $string = 'Hello World';
        $enkripsi = Crypt::encryptString($string);
        $dekripsi = Crypt::decryptString($enkripsi);

        echo "String $string <br><br>";
        echo "Hasil enkripsi $enkripsi <br><br>";
        echo "Hasil enkripsi $dekripsi <br><br>";

        $params = [
            'name' => 'Arya Javas Fatih',
            'age' => 20,
        ];
        $params = Crypt::encrypt($params);
        echo "<a href=" . route('enkripsi-detail', ['params' => $params]) . ">Lihat Detail</a>";
    }

    public function enkripsi_detail($params)
    {
        $params = Crypt::decrypt($params);
        dd($params);
    }
}
