<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

class nd2WidgetGroup extends nd2Panel
{

    public function buildHtml()
    {
        $children_html = $this->buildHtmlForChildren();
        
        $output = '
				<fieldset class="exface_inputgroup">
					<legend>' . $this->getWidget()->getCaption() . '</legend>
					' . $children_html . '
				</fieldset>';
        return $output;
    }
}
?>
