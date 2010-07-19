<?php
namespace Nijikodo\Language;

/**
 * Shell code processor
 *
 * @package Language
 * @subpackage Shell
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class Shell extends Generic
{
    /**
     * regex rules for shell scripts
     *
     * @return void
     */
    protected function _preProcess()
    {
        $this->_addPattern('/(&amp;&amp;|export)/', '<span class="' . $this->_css_prepend . '_keyword">$1</span>');
        $this->_addPattern('/((^|\s)(ls|rm|wget|cd|mkdir|gzip|unzip|sh|tar))/', '<span class="' . $this->_css_prepend . '_function">$1</span>');
    }
}
