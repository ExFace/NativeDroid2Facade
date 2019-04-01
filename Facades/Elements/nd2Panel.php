<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

class nd2Panel extends nd2Container
{

    function buildHtml()
    {
        $output = '
				<div class="panel" 
					title="' . $this->getWidget()->getCaption() . '">' . "\n";
        $output .= $this->buildHtmlForChildren();
        $output .= '</div>';
        return $output;
    }

    function buildHtmlButtons()
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $btn) {
            $output .= $this->getFacade()->buildHtml($btn);
        }
        
        return $output;
    }

    function buildJsButtons($jqm_page_id = null)
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $btn) {
            $output .= $this->getFacade()->buildJs($btn, $jqm_page_id);
        }
        
        return $output;
    }
}
?>