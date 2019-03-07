<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Widgets\QrCode;
use exface\Core\Templates\AbstractAjaxTemplate\Elements\JqueryQrCodeTrait;

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
}
?>