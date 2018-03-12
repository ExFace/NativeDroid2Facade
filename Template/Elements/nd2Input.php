<?php
namespace exface\NativeDroid2Template\Template\Elements;

use exface\Core\Interfaces\Actions\ActionInterface;

class nd2Input extends nd2Value
{

    protected function init()
    {
        parent::init();
        $this->setElementType('text');
    }

    public function buildHtml()
    {
        $output = $this->buildHtmlLabel() . '	    <input data-clear-btn="true"
								type="' . $this->getElementType() . '"
								name="' . $this->getWidget()->getAttributeAlias() . '"
								value="' . $this->escapeString($this->getWidget()->getValue()) . '"
								id="' . $this->getId() . '"
								' . ($this->getWidget()->isRequired() ? 'required="true" ' : '') . '
								' . ($this->getWidget()->isDisabled() ? 'disabled="disabled" ' : '') . '/>';
        
        return $this->buildHtmlGridItemWrapper($output);
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