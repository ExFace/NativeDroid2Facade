<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

class nd2InputSelect extends nd2Input
{

    protected function init()
    {
        parent::init();
        $this->setElementType('select');
    }

    function buildHtml()
    {
        $widget = $this->getWidget();
        $options = '';
        $selected_cnt = count($widget->getValues());
        foreach ($widget->getSelectableOptions() as $value => $text) {
            if ($widget->getMultiSelect() && $selected_cnt > 1) {
                $selected = in_array($value, $widget->getValues());
            } else {
                $selected = strcasecmp($widget->getValueWithDefaults(), $value) === 0 ? true : false;
            }
            $options .= '
					<option value="' . $value . '"' . ($selected ? ' selected="selected"' : '') . '>' . $text . '</option>';
        }
        
        $props = '';
        $props .= $widget->isRequired() ? ' required="true"' : '';
        $props .= $widget->isDisabled() ? ' disabled="disabled"' : '';
        $props .= $widget->getMultiSelect() ? ' multiple' : '';
        $props .= $widget->isDisabled() ? ' disabled="disabled"' : '';
        $output = <<<HTML
        <select data-native-menu="false" name="{$widget->getAttributeAlias()}" value="{$this->escapeString($widget->getValueWithDefaults())}" id="{$this->getId()}" {$props}>
            {$options}
        </select>

HTML;
        return $this->buildHtmlGridItemWrapper($output);
    }

    function buildJs($jqm_page_id = null)
    {
        return '';
    }
}
?>