<?php

namespace Akkurate\LaravelAuth\Notifications;

use Akkurate\LaravelCore\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class UserRegisteredNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public $user;
    public $now;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {

        if (empty($user->activation_token)) {
            $user->update([
                'activation_token' => Str::random(32)
            ]);
        }

        $this->now = Carbon::now();
        $this->user = $user;
        $this->subject = 'Bienvenue sur '. config('app.name') ?? app_name();


    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->view('back::emails.register', [
                'user' => $this->user
            ]);
    }
}
