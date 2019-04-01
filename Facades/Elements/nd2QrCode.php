<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\QrCode;
use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryQrCodeTrait;

/**
 *
 * @method QrCode getWidget()
 *        
 * @author Andrej Kabachnik
 *        
 */
class nd2QrCode extends nd2Display
{
    use JqueryQrCodeTrait;
    
    public function buildHtml()
    {
        // For some reason the original wrapper div (with the id, etc.) gets removed if
        // there is no additional wrapper.
        return '<div class="exf-qrcode-wrapper">' . $this->buildHtmlQrCode() . '</div>';
    }
}
?>