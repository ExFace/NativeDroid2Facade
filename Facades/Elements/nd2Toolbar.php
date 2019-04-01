<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryToolbarTrait;

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
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildJs()
     */
    public function buildJs($jqm_page_id = NULL)
    {
        return $this->buildJsButtons($jqm_page_id);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        return $this->buildHtmlToolbarWrapper($this->buildHtmlButtons());
    }
}
?>