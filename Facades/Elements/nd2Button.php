<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\DialogButton;
use exface\Core\Interfaces\Actions\ActionInterface;
use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryButtonTrait;
use exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement;
use exface\Core\Interfaces\Actions\iShowWidget;
use exface\Core\Widgets\Button;

/**
 * generates jQuery Mobile buttons for ExFace
 * 
 * @method Button getWidget()
 *
 * @author Andrej Kabachnik
 *        
 */
class nd2Button extends nd2AbstractElement
{
    
    use JqueryButtonTrait;

    function buildJs($jqm_page_id = null)
    {
        $output = '';
        $hotkey_handlers = array();
        
        // Actions with facade scripts may contain some helper functions or global variables.
        // Print the here first.
        if ($this->getAction() && $this->getAction()->implementsInterface('iRunFacadeScript')) {
            $output .= $this->getAction()->buildScriptHelperFunctions($this->getFacade());
        }
        
        if ($click = $this->buildJsClickFunction()) {
            
            // Generate the function to be called, when the button is clicked
            $output .= "
				function " . $this->buildJsClickFunctionName() . "(input){
					" . $this->buildJsClickFunction() . "
				}
				";
            
            // Handle hotkeys
            if ($this->getWidget()->getHotkey()) {
                $hotkey_handlers[$this->getWidget()->getHotkey()][] = $this->buildJsClickFunctionName();
            }
        }
        
        foreach ($hotkey_handlers as $hotkey => $handlers) {
            // TODO add hotkey detection here
        }
        
        return $output;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtml()
     */
    function buildHtml()
    {
        /* @var $widget \exface\Core\Widgets\Button */
        $widget = $this->getWidget();
        $icon = ($widget->getIcon() && $widget->getShowIcon(true) ? '<i class="' . ($widget->getCaption() && ! $widget->getHideCaption() ? 'ui-pull-left ' : '') . $this->buildCssIconClass($widget->getIcon() . '"></i> ') : '');
        $hidden_class = ($widget->isHidden() ? ' ui-hidden' : '');
        $output = '
				<a href="#" ' . $this->generateDataAttributes() . ' class="ui-btn ui-btn-inline ' . $hidden_class . '" onclick="' . $this->buildJsClickFunctionName() . '();">
						' . $icon . $widget->getCaption() . '
				</a>';
        
        return $output;
    }
    
    public function buildHtmlHeadTags()
    {
        $tags = parent::buildHtmlHeadTags();
        return array_merge($tags, $this->buildHtmlHeadTagsForCustomScriptIncludes());
    }

    protected function buildJsClickShowDialog(ActionInterface $action, AbstractJqueryElement $input_element)
    {
        $widget = $this->getWidget();
        $ajaxUrl = $this->getAjaxUrl();
        if (strpos($ajaxUrl, '?') === false) {
            $ajaxUrl .= '?';
        }
        // FIXME the request should be sent via POST to avoid length limitations of GET
        // The problem is, we would have to fetch the page via AJAX and insert it into the DOM, which
        // would probably mean, that we have to take care of removing it ourselves (to save memory)...
        return $this->buildJsRequestDataCollector($action, $input_element) . "
					$.mobile.pageContainer.pagecontainer('change', '" . $ajaxUrl . "&resource=" . $this->getWidget()->getPage()->getAliasWithNamespace() . "&element=" . $widget->getId() . "&action=" . $widget->getActionAlias() . "&data=' + encodeURIComponent(JSON.stringify(requestData)));
					";
    }

    /* FIXME using mobile.changePage caches pages, which leads to a page called with different prefills
     * to allways show the same content (the first prefill). Using the default location.href navigation
     * method causes the screen to go blank for a second, which is not as nice as the jqm transitions.
    protected function buildJsClickShowWidget(iShowWidget $action, AbstractJqueryElement $input_element)
    {
        $widget = $this->getWidget();
        if (! $widget->getPage()->is($action->getPageAlias())) {
            $output = $this->buildJsRequestDataCollector($action, $input_element) . "
				 	$.mobile.pageContainer.pagecontainer('change', '" . $this->getFacade()->buildUrlToPage($action->getPageAlias()) . "?prefill={\"meta_object_id\":\"" . $widget->getMetaObject()->getId() . "\",\"rows\":[{\"" . $widget->getMetaObject()->getUidAttributeAlias() . "\":' + requestData.rows[0]." . $widget->getMetaObject()->getUidAttributeAlias() . " + '}]}');";
        }
        return $output;
    }*/

    protected function buildJsClickGoBack(ActionInterface $action, AbstractJqueryElement $input_element)
    {
        return '$.mobile.back();';
    }

    protected function buildJsCloseDialog($widget, $input_element)
    {
        return ($widget->getWidgetType() == 'DialogButton' && $widget->getCloseDialogAfterActionSucceeds() ? "$('#" . $input_element->getId() . "').dialog('close');" : "");
    }

    protected function generateDataAttributes()
    {
        $widget = $this->getWidget();
        $output = '';
        if ($widget->getWidgetType() == 'DialogButton') {
            if ($widget->getCloseDialogAfterActionSucceeds()) {
                $output .= ' data-rel="back" ';
            }
        }
        return $output;
    }
}
?>