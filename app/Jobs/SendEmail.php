<?php

namespace App\Jobs;

use App\Models\Point;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Request;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use Queueable, SerializesModels;
    public $subject;
    public $data;

    public function __construct($subject,$data)
    {
        $this->subject = $subject;
        $this->data = $data;
    }
    public function build(Request $request){
        $data = Point::where('student_id', auth('student')->user()->id)->get();
        return $this->subject('UbWork')
                    ->view('student.mail.index', ['data' => $data]);
    }
}
