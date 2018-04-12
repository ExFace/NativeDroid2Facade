<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Interfaces\Actions\ActionInterface;

/**
 * Generates <div> elements for value widgets.
 * 
 * @author Andrej Kabachnik
 *
 */
class nd2Value extends nd2AbstractElement
{

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
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        $output = <<<HTML

        <div id="{$this->getId()}">{$this->escapeString($this->getWidget()->getValue())}</div>

HTML;
        
        return $this->buildHtmlGridItemWrapper($output);
    }
    
    /**
     * 
     * @return string
     */
    protected function buildHtmlLabel()
    {
        if (! $this->getCaption() || $this->getWidget()->getHideCaption() || $this->getWidget()->isInTable()) {
            return '';
        }
        
        return <<<HTML

        <label for="{$this->getId()}">{$this->getCaption()}</label>

HTML;
    }
    
    /**
     * 
     * @param string $html
     * @return string
     */
    protected function buildHtmlGridItemWrapper($html)
    {
        if (! $this->getWidget()->isInTable()) {
            $cssClasses = "exf-grid-item";
        }
        
        return <<<HTML

    <div class="exf-input {$cssClasses}" title="{$this->buildHintText()}">
        {$html}
    </div>
HTML;
    }

    public function buildJs($jqm_page_id = null)
    {
        return '';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildJsDataGetter($action, $custom_body_js)
     */
    public function buildJsDataGetter(ActionInterface $action = null)
    {
        if ($this->getWidget()->isDisplayOnly()) {
            return '{}';
        } else {
            return parent::buildJsDataGetter($action);
        }
    }
}
?>