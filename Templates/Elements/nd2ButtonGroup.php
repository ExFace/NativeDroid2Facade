<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryButtonGroupTrait;

/**
 * The jQuery mobile implementation of the Toolbar widget
 *
 * @author Andrej Kabachnik
 *
 * @method Toolbar getWidget()
 */
class nd2ButtonGroup extends nd2AbstractElement
{
    use JqueryButtonGroupTrait;
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        return $this->buildHtmlButtonGroupWrapper($this->buildHtmlButtons());
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildJs()
     */
    public function buildJs()
    {
        $this->buildJsForButtons();
    }
}
?>