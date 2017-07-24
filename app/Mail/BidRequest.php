<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BidRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user_bid;
    public $files;
    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $user_bid, $files)
    {
        $this->user_bid = $user_bid;
        $this->files = $files;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = unserialize($this->user_bid->data);
        $name = $this->user_bid->bid->name;
        $user = $this->user;
        $email = $this->from($this->user->email)->markdown('email.bid_request', compact('data', 'user', 'name'));
        if($this->files)
        {
            foreach ($this->files as $file)
            {
                $email->attach(config('filesystems.disks.public.url').'/'.$file);
            }
        }
        return $email;
    }
}
