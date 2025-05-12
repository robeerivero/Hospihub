<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CitaCanceladaNotification extends Notification
{
    use Queueable;

    protected $fecha;
    protected $hora;

    public function __construct($fecha, $hora)
    {
        $this->fecha = $fecha;
        $this->hora = $hora;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('❌ Cita Cancelada')
            ->greeting("Hola {$notifiable->name},")
            ->line("Has cancelado tu cita del día {$this->fecha} a las {$this->hora}.")
            ->line('Si fue un error, puedes volver a reservar una cita en HospiHub.');
    }
}

