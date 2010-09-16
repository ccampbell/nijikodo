<?php
namespace Nijikodo\Language;

/**
 * Ini code processor
 *
 * @package Language
 * @subpackage Ini
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class Ini extends Generic
{
    /**
     * regex rules for ini files
     *
     * @return void
     */
    protected function _preProcess()
    {
        parent::_addStringPattern();
        parent::_addMathPattern();
        parent::_addNumberPattern();
        $this->_addPattern('/(\[.*\])/', '<span class="' . $this->_css_prefix . 'method">$1</span>');
        $this->_addPattern('/\[(.*\s?\:\s?)(.*)\]/', '[$1<em>$2</em>]');
    }
}
