<?php

namespace MailPoetVendor\Egulias\EmailValidator\Warning;

if (!defined('ABSPATH')) exit;


class TLD extends \MailPoetVendor\Egulias\EmailValidator\Warning\Warning
{
    const CODE = 9;
    public function __construct()
    {
        $this->message = "RFC5321, TLD";
    }
}
