<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmail;

class EmailController extends Controller
{
    public function sendWelcomeEmail(){
        $toEmail = "edsonkusemererwa2000@gmail.com";
        $message = "Welcome to MEWA";
        $subject = "Welcome to email in laravel 10 using gmail";

        $response = Mail::to($toEmail)->send(new OrderEmail($message, $subject));

        dd($response);
    }
}
