<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\InterviewSchedule;

class InterviewScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public InterviewSchedule $schedule;
    public $santriName;
    public $programName;
    public $scheduleDate;
    public $scheduleTime;
    public $media;
    public $ustadName;
    public $notes;

    /**
     * Create a new message instance.
     */
    public function __construct(InterviewSchedule $schedule)
    {
        $this->schedule = $schedule;
        $this->santriName = $schedule->registration->user->name ?? 'Santri';
        $this->programName = $schedule->registration->program->name ?? '-';
        $this->scheduleDate = $schedule->schedule_date;
        $this->scheduleTime = $schedule->schedule_time;
        $this->media = $this->getMediaLabel($schedule->media);
        $this->ustadName = $schedule->ustad->name ?? '-';
        $this->notes = $schedule->notes;
    }

    /**
     * Get media label in Indonesian
     */
    private function getMediaLabel($media): string
    {
        return match($media) {
            'whatsapp' => 'WhatsApp Video Call',
            'video_call' => 'Video Call (Zoom/Google Meet)',
            'tatap_muka' => 'Tatap Muka',
            default => $media,
        };
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jadwal Wawancara PPDB - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.interview-scheduled',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
