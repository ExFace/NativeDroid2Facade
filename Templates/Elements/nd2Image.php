<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Widgets\Image;
use exface\Core\Templates\AbstractAjaxTemplate\Elements\HtmlImageTrait;

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
    
    public function buildJs()
    {
        // This hack prevents the URI of the image from being broken when rendering the jqm page.
        return parent::buildJs() . <<<JS

setTimeout(function() {
    $('#{$this->getId()}').attr('src', '{$this->getWidget()->getUri()}');
}, 100);

JS;
    }
}
?>