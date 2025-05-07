<?php

namespace App\Http\Controllers;

use App\Mail\LogisticaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\DatabaseNotification;

class MailController extends Controller
{
    public function index()

    {
        $mailData = [

            'title' => 'Mail from illimitis.com',

            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('your_email@gmail.com')->send(new LogisticaMail($mailData));

        dd("Email is sent successfully.");

    }

    public function markAsRead($id)
    {
        
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url']);
        }

        return redirect()->back();
    }
}
