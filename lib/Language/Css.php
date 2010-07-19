<?php
namespace Nijikodo\Language;

/**
 * Css code processor
 *
 * @package Language
 * @subpackage Css
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class Css extends Generic
{
    /**
     * regex rules for css
     *
     * @return void
     */
    protected function _preProcess()
    {
        $this->_addPattern('/((?<!\\\)&quot;.*?(?<!\\\)&quot;|(?<!\\\)\'(.*?)(?<!\\\)\')/', '<span class="' . $this->_css_prepend . '_string">$1</span>');
        $this->_addPattern('/\/\*(.+?)\*\//s', '<span class="' . $this->_css_prepend . '_comment">/*$1*/</span>');
        $this->_addPattern('/(#)(.+?);/', '<span class="' . $this->_css_prepend . '_int">$1$2$3</span><span class="' . $this->_css_prepend . '_default">;</span>');
        $this->_addPattern('/(.+)([\:]{1}(.*;))/', '<span class="' . $this->_css_prepend . '_class">$1</span>:$3');
        $this->_addPattern('/(.+)([\{]{1})/', '<span class="' . $this->_css_prepend . '_method">$1</span>{');
        $this->_addPattern('/([0-9\.]+)(px)/', '<span class="' . $this->_css_prepend . '_int">$1</span><span class="' . $this->_css_prepend . '_keyword">px</span>');
        $this->_addPattern('/([0-9\.]+)(%)/', '<span class="' . $this->_css_prepend . '_int">$1</span><span class="' . $this->_css_prepend . '_keyword">%</span>');
        $this->_addPattern('/([0-9\.]+)(;)/', '<span class="' . $this->_css_prepend . '_int">$1</span>;');
        $this->_addPattern('/([\:]{1}(\s)?(none|fixed|absolute))/', ':$2<span class="' . $this->_css_prepend . '_class">$3</span>');
    }
}
