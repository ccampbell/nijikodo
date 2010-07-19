<?php
include 'Language/Generic.php';

/**
 * server side library for syntax highlighting code snippets
 *
 * @package Nijikodo
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class Nijikodo
{
    /**
     * @var string
     */
    const DEFAULT_CSS_CLASS = 'niji';

    /**
     * @var string
     */
    protected static $_css_prepend = self::DEFAULT_CSS_CLASS;

    /**
     * @var array
     */
    protected static $_tokenized = array();

    /**
     * converts specific code block to html
     *
     * @param string $code
     * @param string $language (see ./Language for supported languages)
     * @param int $height (optional height if set it will limit the height of the output to that many pixels and add a scrollbar)
     */
    public static function toHtml($code, $language = null, $height = null)
    {
        $code = htmlspecialchars($code, ENT_COMPAT, 'UTF-8', false);
        $language = strtolower($language);

        switch ($language) {
            case 'php':
                require_once 'Language/Php.php';
                $code = new Nijikodo\Language\Php($code);
                break;
            case 'html':
            case 'xml':
                require_once 'Language/Html.php';
                $code =  new Nijikodo\Language\Html($code);
                break;
            case 'css':
                require_once 'Language/Css.php';
                $code = new Nijikodo\Language\Css($code);
                break;
            case 'javascript':
                require_once 'Language/Javascript.php';
                $code = new Nijikodo\Language\Javascript($code);
                break;
            case 'shell':
                require_once 'Language/Shell.php';
                $code = new Nijikodo\Language\Shell($code);
                break;
            case 'apache':
                require_once 'Language/Apache.php';
                $code = new Nijikodo\Language\Apache($code);
                break;
            default:
                $code = new Nijikodo\Language\Generic($code);
                break;
        }

        $code->setCssPrepend(self::$_css_prepend);

        // hate outputting html in php but that is the point of this library
        return '<div class="' . self::$_css_prepend . '_code' . ($language !== null ? ' ' . self::$_css_prepend . '_' . $language : '') . '"' . ($height !== null ? ' style="height:' . $height . 'px;"' : '') . '>' . $code . '</div>';
    }

    /**
     * sets class name to prepend to css classes
     *
     * classes will look like {$class}_int or {$class}_keyword or ${class}_variable
     *
     * @param string
     * @return void
     */
    public static function prependCssClass($class = self::DEFAULT_CSS_CLASS)
    {
        self::$_css_prepend = $class;
    }

    /**
     * takes text input and finds {code} blocks and turns them into pretty code
     *
     * @param string $text
     * @return string
     */
    public static function process($text)
    {
        $text = preg_replace_callback('/\{code(:)?([^\}]+\b)?\}(.+?)(\{code\})(\n)?/is', 'self::_tokenizeCode', $text);
        foreach (self::$_tokenized as $key => $value) {
            $text = str_replace($key, $value, $text);
        }

        return $text;
    }

    /**
     * allows you to format code in a view with output buffering
     *
     * @return void
     */
    public static function captureStart()
    {
        ob_start();
    }

    /**
     * output what was captured
     *
     * @return string
     */
    public static function output()
    {
        $text = ob_get_contents();
        ob_end_clean();
        // replace code blocks with magic things we will replace later
        return self::process($text);
    }

    /**
     * tokenizes regex code match so we can replace it in the block of text later
     *
     * @param array $matches
     * @return string $token
     */
    protected static function _tokenizeCode($matches)
    {
        $language = isset($matches[2]) ? $matches[2] : null;

        $height = null;
        if (strpos($language, '|') !== false) {
            $bits = explode('|', $language);
            $language = $bits[0];
            $height = isset($bits[1]) ? str_replace('height:', '', $bits[1]) : null;
        }

        $code = $matches[3];

        $code = ltrim($code, "\n");
        $code = rtrim($code, "\n");

        $token = 'code:' . uniqid();
        $html = self::toHtml($code, $language, $height);

        self::$_tokenized[$token] = $html;

        return $token;
    }
}
