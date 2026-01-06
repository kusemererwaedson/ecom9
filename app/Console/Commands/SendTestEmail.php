<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class SendTestEmail extends Command
{
    protected $signature = 'email:send';
    protected $description = 'Send a test email';

    public function handle()
    {
        $recipientEmail = 'kusemererwaedson2000@gmail.com';
        Mail::to($recipientEmail)->send(new TestEmail());

        $this->info('Test email sent successfully to ' . $recipientEmail);
    }
}
