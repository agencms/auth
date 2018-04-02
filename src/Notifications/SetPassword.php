<?php

namespace Agencms\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $tenant;
    public $site;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $tenant, $site)
    {
        $this->tenant = $tenant;
        $this->site = $site;
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $resetUrl = sprintf(
            '%s#/%s/%s/password/%s',
            str_finish(config('agencms.portal', 'https://portal.agencms.com/'), '/'),
            $this->tenant,
            $this->site,
            $this->token
        );

        return (new MailMessage)
            ->line('Welcome to Agencms. An account has been created for you.')
            ->action('Set Password', $resetUrl)
            ->line('If you did not request this, no further action is required.');
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
