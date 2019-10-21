<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\ProgressBar;
use exface\Core\Facades\AbstractAjaxFacade\Elements\HtmlProgressBarTrait;

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
     * @see \exface\NativeDroid2Facade\Facades\Elements\nd2Display::buildHtml()
     */
    public function buildHtml()
    {
        return $this->buildHtmlProgressBar($this->getWidget()->getValueWithDefaults());
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\NativeDroid2Facade\Facades\Elements\nd2Value::buildJs()
     */
    public function buildJs($jqm_page_id = null)
    {
        return '';
    }
}
?>