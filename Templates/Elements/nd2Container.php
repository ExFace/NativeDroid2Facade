<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryContainerTrait;

class nd2Container extends nd2AbstractElement
{
    
    use JqueryContainerTrait;

    public function buildJs($jqm_page_id = null)
    {
        return $this->buildJsForChildren($jqm_page_id);
    }

    public function buildJsForChildren($jqm_page_id = null)
    {
        foreach ($this->getWidget()->getChildren() as $subw) {
            $output .= $this->getTemplate()->buildJs($subw, $jqm_page_id) . "\n";
        }
        ;
        return $output;
    }

    public function buildJsForWidgets($jqm_page_id = null)
    {
        foreach ($this->getWidget()->getWidgets() as $subw) {
            $output .= $this->getTemplate()->buildJs($subw, $jqm_page_id) . "\n";
        }
        return $output;
    }
}
?>