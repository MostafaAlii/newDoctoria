<?php
namespace App\Notifications;
use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class ResetPasswordNotification extends Notification {
    use Queueable;
    public $message;
    public $otp;
    public $mailer;
    public $subject;
    public $fromEmail;

    public function __construct() {
        $this->message = 'use the below otp code to reset your password';
        $this->subject = 'Reset Password';
        $this->mailer = 'smtp';
        $this->fromEmail = 'doctoria@example.com';
        $this->otp = new Otp;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        $greetingName = $notifiable->name ?: ($notifiable->nickname ?: $notifiable->email);
        $otp = $this->otp->generate($notifiable->email, 'numeric', 6, 60);
        return (new MailMessage)
            ->mailer('smtp')
            ->subject($this->subject)
            ->greeting('Hello ' . $greetingName)
            ->line($this->message)
            ->line('Code: ' . $otp->token);
    }
}
