<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryDisplayTrait;
use exface\Core\Facades\AbstractAjaxFacade\Interfaces\JsValueDecoratingInterface;

/**
 * Generates <div> elements for Display widgets.
 * 
 * @author Andrej Kabachnik
 *
 */
class nd2Display extends nd2Value implements JsValueDecoratingInterface
{
    use JqueryDisplayTrait {
        buildJs as buildJsViaTrait;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::init()
     */
    protected function init()
    {
        parent::init();
        $this->setElementType('div');
    }

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        $output = <<<HTML

        {$this->buildHtmlLabel()}
        <div id="{$this->getId()}" class="exf-display">{$this->escapeString($this->getWidget()->getValue())}</div>

HTML;
        
        return $this->buildHtmlGridItemWrapper($output);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\NativeDroid2Facade\Facades\Elements\nd2Value::buildJs()
     */
    public function buildJs($jqm_page_id = null)
    {
        return $this->buildJsViaTrait();
    }
}
?>