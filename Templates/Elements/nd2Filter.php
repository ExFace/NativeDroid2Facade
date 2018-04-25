<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryFilterTrait;

class nd2Filter extends nd2AbstractElement
{
    use JqueryFilterTrait;

    /**
     * Need to override the generate_js() method of the trait to make sure, the $jqm_page_id is allways passed along
     *
     * {@inheritdoc}
     *
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildJs()
     */
    public function buildJs($jqm_page_id = NULL)
    {
        return $this->getInputElement()->buildJs($jqm_page_id);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Templates\AbstractAjaxTemplate\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        return $this->getInputElement()->buildHtml();
    }
}
?>