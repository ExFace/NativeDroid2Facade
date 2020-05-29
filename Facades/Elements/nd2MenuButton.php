<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\Button;
use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryButtonTrait;
use exface\Core\Widgets\MenuButton;
use exface\Core\CommonLogic\Constants\Icons;

/**
 * generates jQuery Mobile buttons for ExFace
 *
 * @method MenuButton getWidget()
 * 
 * @author Andrej Kabachnik
 *        
 */
class nd2MenuButton extends nd2AbstractElement
{
    
    use JqueryButtonTrait;

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtmlHeadTags()
     */
    public function buildHtmlHeadTags()
    {
        return array_merge(parent::buildHtmlHeadTags(), $this->getFacade()->getElement($this->getWidget()->getMenu())->buildHtmlHeadTags());
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {
        $widget = $this->getWidget();
        
        $buttons_html = '';
        foreach ($widget->getButtons() as $b) {
            $buttons_html .= '<li><a href="#" onclick="' . $this->buildJsButtonFunctionName($b) . '(); $(this).parent().parent().parent().popup(\'close\');"><i class="' . $this->buildCssIconClass($b->getIcon()) . '"></i> ' . $b->getCaption() . '</a></li>';
        }
        
        $icon = $widget->getIcon() ? $this->buildCssIconClass($widget->getIcon()) : $this->buildCssIconClass(Icons::ELLIPSIS_H);
        
        $output = <<<HTML

<a href="#{$this->getId()}" data-rel="popup" class="ui-btn ui-btn-inline"><i class="{$icon}"></i> {$widget->getCaption()}</a>
<div data-role="popup" id="{$this->getId()}">
	<ul data-role="listview" data-inset="true">
		{$buttons_html}
	</ul>
</div>		
HTML;
        
        return $output;
    }

    /**
     * {@inheritdoc}
     *
     * @see \exface\NativeDroid2Facade\Facades\Elements\nd2AbstractElement::buildJs()
     */
    public function buildJs($jqm_page_id = null)
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $b) {
            $output .= "\n" . $this->getFacade()->getElement($b)->buildJs($jqm_page_id);
        }
        return $output;
    }

    protected function buildJsButtonFunctionName(Button $button)
    {
        return $this->getFacade()->getElement($button)->buildJsClickFunctionName();
    }
    
    /**
     *
     * {@inheritdoc}
     * @see JqueryButtonTrait::buildJsCloseDialog()
     */
    protected function buildJsCloseDialog($widget, $input_element)
    {
        return '';
    }
}
?>