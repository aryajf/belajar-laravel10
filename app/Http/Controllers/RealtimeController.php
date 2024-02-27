<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;

class RealtimeController extends Controller
{
    public function chat1()
    {
        return view('realtime.chat1');
    }
    public function chat2()
    {
        return view('realtime.chat1');
    }
    public function sendMessage(Request $request)
    {
        $to = $request->to;
        $subject = $request->subject;
        $pesan = $request->pesan;

        $jumlahInbox = 1;

        $array = [
            'kepada' => $to,
            'subject' => $subject,
            'pesan' => $pesan,
            'inbox' => $jumlahInbox
        ];

        NewMessage::dispatch($array);
    }
}
