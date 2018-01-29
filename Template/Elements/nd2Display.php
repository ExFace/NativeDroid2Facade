<?php
namespace exface\NativeDroid2Template\Template\Elements;

use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryDisplayTrait;
use exface\Core\Templates\AbstractAjaxTemplate\Interfaces\JsValueDecoratingInterface;

/**
 * Generates <div> elements for Display widgets.
 * 
 * @author Andrej Kabachnik
 *
 */
class nd2Display extends nd2Value implements JsValueDecoratingInterface
{
    use JqueryDisplayTrait;

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::init()
     */
    protected function init()
    {
        parent::init();
        $this->setElementType('div');
    }

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::generateHtml()
     */
    public function generateHtml()
    {
        $output = <<<HTML

        {$this->buildHtmlLabel()}
        <div id="{$this->getId()}">{$this->escapeString($this->getWidget()->getValue())}</div>

HTML;
        
        return $this->buildHtmlGridItemWrapper($output);
    }
}
?>