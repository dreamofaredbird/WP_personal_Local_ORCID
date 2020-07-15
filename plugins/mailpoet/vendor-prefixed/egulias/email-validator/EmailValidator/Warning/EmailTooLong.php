<?php

namespace MailPoetVendor\Egulias\EmailValidator\Warning;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Egulias\EmailValidator\EmailParser;
class EmailTooLong extends \MailPoetVendor\Egulias\EmailValidator\Warning\Warning
{
    const CODE = 66;
    public function __construct()
    {
        $this->message = 'Email is too long, exceeds ' . \MailPoetVendor\Egulias\EmailValidator\EmailParser::EMAIL_MAX_LENGTH;
    }
}
