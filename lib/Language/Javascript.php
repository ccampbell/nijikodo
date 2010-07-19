<?php
namespace Nijikodo\Language;

/**
 * Javascript code processor
 *
 * @package Language
 * @subpackage Javascript
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class Javascript extends Generic
{
    /**
     * regex rules for javascript
     *
     * @return void
     */
    protected function _preProcess()
    {
        $this->_addPattern('/\$\(/', '<span class="' . $this->_css_prepend . '_keyword">$</span>(');
        $this->_addPattern('/(.*)(\.)(.*)(\s?=\s?)function/', '<span class="' . $this->_css_prepend . '_class">$1</span>$2$3$4function');
        $this->_addPattern('/(.*?(\s)?)=(\s)?function/', '<span class="' . $this->_css_prepend . '_method">$1</span>=$2function');
        $this->_addPattern('/(.*?(\s)?)\:(\s)?function/', '<span class="' . $this->_css_prepend . '_method">$1</span>:$2function');
        $this->_addPattern('/\./', '<span class="' . $this->_css_prepend . '_default">.</span>');
        $this->_addPattern('/(document|window)/', '<span class="' . $this->_css_prepend . '_class">$1</span>');

        // add the generic code handling stuff
        parent::_preProcess();
    }
}
