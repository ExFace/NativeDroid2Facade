<?php
namespace exface\NativeDroid2Template\Templates\Elements;

class nd2InputCheckBox extends nd2Value
{

    protected function init()
    {
        parent::init();
        $this->setElementType('checkbox');
    }

    function buildHtml()
    {
        $value = $this->getWidget()->getValue() ? 'checked="checked" ' : '';
        $disabled = $this->getWidget()->isDisabled() ? 'disabled="disabled"' : '';
        $output = <<<HTML
        <input class="exf-input checkbox" type="checkbox" value="1" id="{$this->getWidget()->getId()}" $value $disabled />
HTML;
        return $this->buildHtmlGridItemWrapper($output);
    }

    function buildJs($jqm_page_id = null)
    {
        return '';
    }
}
?>