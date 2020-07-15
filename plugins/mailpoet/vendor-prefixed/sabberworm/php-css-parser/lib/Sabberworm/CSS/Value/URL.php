<?php

namespace MailPoetVendor\Sabberworm\CSS\Value;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Sabberworm\CSS\Parsing\ParserState;
class URL extends \MailPoetVendor\Sabberworm\CSS\Value\PrimitiveValue
{
    private $oURL;
    public function __construct(\MailPoetVendor\Sabberworm\CSS\Value\CSSString $oURL, $iLineNo = 0)
    {
        parent::__construct($iLineNo);
        $this->oURL = $oURL;
    }
    public static function parse(\MailPoetVendor\Sabberworm\CSS\Parsing\ParserState $oParserState)
    {
        $bUseUrl = $oParserState->comes('url', \true);
        if ($bUseUrl) {
            $oParserState->consume('url');
            $oParserState->consumeWhiteSpace();
            $oParserState->consume('(');
        }
        $oParserState->consumeWhiteSpace();
        $oResult = new \MailPoetVendor\Sabberworm\CSS\Value\URL(\MailPoetVendor\Sabberworm\CSS\Value\CSSString::parse($oParserState), $oParserState->currentLine());
        if ($bUseUrl) {
            $oParserState->consumeWhiteSpace();
            $oParserState->consume(')');
        }
        return $oResult;
    }
    public function setURL(\MailPoetVendor\Sabberworm\CSS\Value\CSSString $oURL)
    {
        $this->oURL = $oURL;
    }
    public function getURL()
    {
        return $this->oURL;
    }
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        return "url({$this->oURL->render($oOutputFormat)})";
    }
}
