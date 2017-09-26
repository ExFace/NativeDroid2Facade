<?php
namespace exface\JQueryMobileTemplate\Template\Elements;

class nd2InputHidden extends nd2Input
{

    protected function init()
    {
        parent::init();
        $this->setElementType('hidden');
    }

    public function generateHtml()
    {
        $output = '<input type="hidden" 
								name="' . $this->getWidget()->getAttributeAlias() . '" 
								value="' . addslashes($this->getWidget()->getValue()) . '" 
								id="' . $this->getId() . '" />';
        return $output;
    }
}