<?php
namespace exface\NativeDroid2Template\Template\Elements;

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
    function buildJs($jqm_page_id = NULL)
    {
        return $this->getInputElement()->buildJs($jqm_page_id);
    }
}
?>