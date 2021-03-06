<?php

namespace MailPoetVendor\Egulias\EmailValidator\Validation;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Egulias\EmailValidator\EmailLexer;
use MailPoetVendor\Egulias\EmailValidator\EmailParser;
use MailPoetVendor\Egulias\EmailValidator\Exception\InvalidEmail;
class RFCValidation implements \MailPoetVendor\Egulias\EmailValidator\Validation\EmailValidation
{
    /**
     * @var EmailParser|null
     */
    private $parser;
    /**
     * @var array
     */
    private $warnings = [];
    /**
     * @var InvalidEmail|null
     */
    private $error;
    public function isValid($email, \MailPoetVendor\Egulias\EmailValidator\EmailLexer $emailLexer)
    {
        $this->parser = new \MailPoetVendor\Egulias\EmailValidator\EmailParser($emailLexer);
        try {
            $this->parser->parse((string) $email);
        } catch (\MailPoetVendor\Egulias\EmailValidator\Exception\InvalidEmail $invalid) {
            $this->error = $invalid;
            return \false;
        }
        $this->warnings = $this->parser->getWarnings();
        return \true;
    }
    public function getError()
    {
        return $this->error;
    }
    public function getWarnings()
    {
        return $this->warnings;
    }
}
