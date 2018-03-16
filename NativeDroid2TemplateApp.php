<?php
namespace exface\NativeDroid2Template;

use exface\Core\Interfaces\InstallerInterface;
use exface\Core\Templates\AbstractHttpTemplate\HttpTemplateInstaller;
use exface\Core\CommonLogic\Model\App;
use exface\Core\Factories\TemplateFactory;

class NativeDroid2TemplateApp extends App
{

    /**
     * {@inheritdoc}
     * 
     * An additional installer is included to condigure the routing for the HTTP templates.
     * 
     * @see App::getInstaller($injected_installer)
     */
    public function getInstaller(InstallerInterface $injected_installer = null)
    {
        $installer = parent::getInstaller($injected_installer);
        $tplInstaller = new HttpTemplateInstaller($this->getSelector());
        $tplInstaller->setTemplate(TemplateFactory::createFromString('exface.NativeDroid2Template', $this->getWorkbench()));
        $installer->addInstaller($tplInstaller);
        return $installer;
    }
}
?>