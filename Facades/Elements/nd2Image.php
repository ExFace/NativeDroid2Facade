<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\Image;
use exface\Core\Facades\AbstractAjaxFacade\Elements\HtmlImageTrait;

/**
 *
 * @method Image getWidget()
 *        
 * @author Andrej Kabachnik
 *        
 */
class nd2Image extends nd2Display
{
    use HtmlImageTrait;
    
    public function buildJs($jqm_page_id = null)
    {
        // This hack prevents the URI of the image from being broken when rendering the jqm page.
        return parent::buildJs() . <<<JS

setTimeout(function() {
    $('#{$this->getId()}').attr('src', '{$this->getWidget()->getUri()}');
}, 0);

JS;
    }
}
?>