<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class EmailSender
{
    public $template;
    public $data = [];
    public $from;
    public $name_sender;
    public $to;
    public $cc;
    public $subject;
    public $name;
    public $res;

    /**
     * send Email Custom Template
     *
     * @return string
     */
    public function sendEmail()
    {
        try {
            $template = $this->template;
            $data = $this->data;
            $name_sender = $this->name_sender;
            $from = $this->from;
            $to = $this->to;
            $subject = $this->subject;
            $name = $this->name;

            Mail::send($template, $data, function ($email) use ($from, $name_sender, $to, $subject, $name) {
                $email->priority(1);
                $email->to($to, $name)->subject($subject);
                $email->from($from, $name_sender);
            });

            return $this->res = "send";
        } catch (\Exception $th) {
            return $this->res = $th->getMessage();
        }
    }

    public function sendEmailCC()
    {
        try {
            $template = $this->template;
            $data = $this->data;
            $name_sender = $this->name_sender;
            $from = $this->from;
            $to = $this->to;
            $cc = $this->cc;
            $subject = $this->subject;
            $name = $this->name;

            Mail::send($template, $data, function ($email) use ($from, $name_sender, $to, $cc, $subject, $name) {
                $email->priority(1);
                $email->to($to, $name)->subject($subject);
                $email->cc($cc);
                $email->from($from, $name_sender);
            });

            return $this->res = "send";
        } catch (\Exception $th) {
            return $this->res = $th->getMessage();
        }
    }

}
