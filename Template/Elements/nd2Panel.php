<?php
namespace exface\NativeDroid2Template\Template\Elements;

class nd2Panel extends nd2Container
{

    function generateHtml()
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
            $output .= $this->getTemplate()->generateHtml($btn);
        }
        
        return $output;
    }

    function buildJsButtons($jqm_page_id = null)
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $btn) {
            $output .= $this->getTemplate()->generateJs($btn, $jqm_page_id);
        }
        
        return $output;
    }
}
?>