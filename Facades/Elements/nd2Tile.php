<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Widgets\Tile;

/**
 * 
 * @author Andrej Kabachnik
 *
 * @method Tile getWidget()
 */
class nd2Tile extends nd2Button
{

    function buildHtml()
    {
        $widget = $this->getWidget();
        
        if ($icon = $widget->getIcon()) {
            $avatar = '<div class="card-avatar"><i class="' . $this->buildCssIconClass($icon) . '"></i></div>';
            $headerClasses .= 'has-avatar';
        }
        
        if ($this->getWidget()->hasAction()) {
            $click = "onclick=\"{$this->buildJsClickFunctionName()}();\"";
            $style = 'cursor: pointer;';
        }
        
        $subtitle = $widget->getSubtitle();
        if (empty($subtitle)){
            $subtitle = '&nbsp;';
        }
        
        return <<<JS

    <div class="nd2-card exf-tile {$this->buildCssElementClass()}" id="{$this->getId()}" {$click} style="{$style}">
		<div class="card-title {$headerClasses}">
			{$avatar}
			<h3 class="card-primary-title">{$widget->getTitle()}</h3>
            <h5 class="card-subtitle">{$subtitle}</h5>
		</div>
	</div>

JS;
    }

    function buildHtmlButtons()
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $btn) {
            $output .= $this->getFacade()->buildHtml($btn);
        }
        
        return $output;
    }

    function buildJsButtons($jqm_page_id = null)
    {
        $output = '';
        foreach ($this->getWidget()->getButtons() as $btn) {
            $output .= $this->getFacade()->buildJs($btn, $jqm_page_id);
        }
        
        return $output;
    }
}
?>