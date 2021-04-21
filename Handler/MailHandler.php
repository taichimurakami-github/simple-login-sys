<?php
namespace App\common;

class MailHandler {
    /**
     * メールを送信する
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string (or array) $headers
     * @return boolean
     */
    static function send($to, $subject, $message, $headers)
    {
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        mb_send_mail($to, $subject, $message, $headers);
    }
}