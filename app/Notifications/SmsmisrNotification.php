<?php
namespace App\Notifications;
use Ghanem\LaravelSmsmisr\{SmsmisrChannel,SmsmisrMessage};
use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
class SmsmisrNotification extends Notification {
    public $message;
    public $otp;

    public function __construct() {
        $this->message = 'use the below otp code to reset your password';
        $this->otp = new Otp;
    }
    /*public function via($notifiable) {
        return [SmsmisrChannel::class];
    }

    public function toSmsmisr($notifiable) {
        $greetingName = $notifiable->name ?: $notifiable->nickname;
        $otp = $this->otp->generate($notifiable->email, 'numeric', 6, 60);
    	return new SmsmisrMessage(
            'Hello ' . $greetingName . 'Code: ' . $otp->token,
    	    $notifiable->phone
        );
    }*/
}
