<?php

namespace luckywp\tableOfContents\plugin\dom;

use DOMDocument;

class Dom
{

    const BODY_ID = 'LuckyWPDomDocumentTableOfContentsBody';

    /**
     * @param string $content
     * @return DOMDocument|false
     */
    public static function make($content)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        if (!$dom->loadHTML('<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body id="' . static::BODY_ID . '">' . static::prepareHtmlIn($content) . '</body></html>')) {
            return false;
        }
        libxml_clear_errors();
        return $dom;
    }

    /**
     * @param DOMDocument $dom
     * @return string
     */
    public static function getBody($dom)
    {
        $content = '';
        foreach ($dom->getElementById(static::BODY_ID)->childNodes as $node) {
            $content .= $dom->saveHTML($node);
        }
        return static::prepareHtmlOut($content);
    }

    /**
     * @param \DOMNode $node
     * @param string $html
     */
    public static function beforeNodeInsertHtml($node, $html)
    {
        static::nodeInsertHtml($node, $html, true);
    }

    /**
     * @param \DOMNode $node
     * @param string $html
     */
    public static function afterNodeInsertHtml($node, $html)
    {
        static::nodeInsertHtml($node, $html, false);
    }

    /**
     * @param \DOMNode $node
     * @param string $html
     * @param bool $before
     */
    protected static function nodeInsertHtml($node, $html, $before)
    {
        $dom = static::make($html);
        if ($dom !== false) {
            foreach ($dom->getElementById(static::BODY_ID)->childNodes as $newNode) {
                $node->parentNode->insertBefore($node->ownerDocument->importNode($newNode, true), $before ? $node : $node->nextSibling);
            }
        }
    }

    /**
     * @param \DOMElement $node
     * @return string
     */
    public static function getNodeValue($node)
    {
        return static::prepareHtmlOut($node->nodeValue);
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function prepareHtmlIn($content)
    {
        // HTML-сущности
        $content = strtr($content, static::getEntitesReplacePairs());

        // CDATA
        $content = static::encode('#<!\[CDATA\[.*?\]\]>#imsu', $content);

        // Условные комментарии
        $content = static::encode('#<!--\s*\[\s*if.*?endif\s*\]\s*-->#imsu', $content);

        // Скрипты
        $content = static::encode('#<\s*script[^>]*>.*?</script\s*>#imsu', $content);

        // Стили
        $content = static::encode('#<\s*style[^>]*>.*?</style\s*>#imsu', $content);

        return $content;
    }

    /**
     * @param string $pattern
     * @param string $content
     * @return string
     */
    protected static function encode($pattern, $content)
    {
        return preg_replace_callback($pattern, function ($matches) {
            return '<!-- lwptocEncodedData ' . base64_encode($matches[0]) . ' -->';
        }, $content);
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function prepareHtmlOut($content)
    {
        // Закодированные данные
        $content = preg_replace_callback('#<!-- lwptocEncodedData (.*?) -->#imsu', function ($matches) {
            return base64_decode($matches[1]);
        }, $content);

        // HTML-сущности
        $content = strtr($content, array_flip(static::getEntitesReplacePairs()));

        return $content;
    }

    /**
     * @return array
     */
    protected static function getEntitesReplacePairs()
    {
        static $pairs;
        if ($pairs === null) {
            $pairs = include(__DIR__ . '/entities.php');
        }
        return $pairs;
    }
}
