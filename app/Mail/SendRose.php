<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($send_mail)
    {
        $this->send_mail = $send_mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function handle()
    {
        $input=$this->send_mail['input'];
        try {
            Mail::send($this->send_mail['view'], array('title'=>config('core.cname'),'body' => $this->send_mail['data']), function ($message) use ($input) {
                $str_mailer = explode ("+", $input['mail_to']);
                if(isset($str_mailer[1])){
                    $message->to($str_mailer[0]);
                    array_shift($str_mailer);
                    $message->bcc($str_mailer);

                } else {
                    $message->to($input['mail_to']);
                }

                $message->subject($input['subject']);
            });
        } catch (\Exception $e) {
            return json_encode(array('status' => 'Error', 'message' => trans('general.email_error')));
        }
    }
}
