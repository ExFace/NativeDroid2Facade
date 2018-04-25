<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryToolbarTrait;

/**
 * The jQuery mobile implementation of the Toolbar widget
 *
 * @author Andrej Kabachnik
 *
 * @method Toolbar getWidget()
 */
class nd2Toolbar extends nd2AbstractElement
{
    use JqueryToolbarTrait;
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildJs()
     */
    public function buildJs($jqm_page_id = NULL)
    {
        return $this->buildJsButtons($jqm_page_id);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        return $this->buildHtmlToolbarWrapper($this->buildHtmlButtons());
    }
}
?>