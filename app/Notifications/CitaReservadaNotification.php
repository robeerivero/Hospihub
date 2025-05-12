<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CitaReservadaNotification extends Notification
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
            ->subject('📅 Cita reservada')
            ->greeting("Hola {$notifiable->name},")
            ->line("Has reservado una cita para el día {$this->fecha} a las {$this->hora}.")
            ->action('Ver mis citas', route('paciente.citas.index'))
            ->line('Gracias por confiar en HospiHub.');
    }
}
