<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Widgets\ProgressBar;
use exface\Core\Templates\AbstractAjaxTemplate\Elements\HtmlProgressBarTrait;

/**
 *
 * @method ProgressBar getWidget()
 *        
 * @author Andrej Kabachnik
 *        
 */
class nd2ProgressBar extends nd2Display
{
    use HtmlProgressBarTrait;
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\NativeDroid2Template\Templates\Elements\nd2Display::buildHtml()
     */
    public function buildHtml()
    {
        return $this->buildHtmlProgressBar($this->getValueWithDefaults());
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\NativeDroid2Template\Templates\Elements\nd2Value::buildJs()
     */
    public function buildJs()
    {
        return '';
    }
}
?>