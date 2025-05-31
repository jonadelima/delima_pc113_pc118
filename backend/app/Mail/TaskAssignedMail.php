<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $taskName;

    public function __construct($taskName)
    {
        $this->taskName = $taskName;
    }

    public function build()
    {
        return $this->subject('New Task Assigned')
                    ->view('emails.task_assigned')
                    ->with([
                        'taskName' => $this->taskName,
                    ]);
    }
}
    