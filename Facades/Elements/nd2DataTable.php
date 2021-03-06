<?php
namespace exface\NativeDroid2Facade\Facades\Elements;

use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryDataTablesTrait;
use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryDataTableTrait;
use exface\Core\CommonLogic\Constants\Icons;
use exface\Core\Facades\AbstractAjaxFacade\Elements\JqueryToolbarsTrait;
use exface\Core\Widgets\Button;
use exface\Core\Widgets\MenuButton;
use exface\Core\Widgets\ButtonGroup;
use exface\Core\Widgets\DataTable;
use exface\Core\Factories\WidgetFactory;
use exface\Core\Interfaces\Widgets\iContainOtherWidgets;
use exface\Core\Widgets\Container;

/**
 *
 * @method DataTable getWidget()
 * 
 * @author PATRIOT
 *        
 */
class nd2DataTable extends nd2AbstractElement
{
    
    use JqueryDataTableTrait;
    
    use JqueryDataTablesTrait;
    
    use JqueryToolbarsTrait;
    
    protected function init()
    {
        parent::init();
        // Do not render the search action in the main toolbar. We will add custom
        // buttons via HTML instead.
        $this->getWidget()->getToolbarMain()->setIncludeSearchActions(false);
    }

    public function buildHtml()
    {
        /* @var $widget \exface\Core\Widgets\DataTable */
        $widget = $this->getWidget();
        
        // Render the context menu BEFORE the toolbars, because the toolbars
        // will create more-buttons-menus for optional buttons, but we want
        // to make them still appear at their original places in the menu.
        $context_menu = $this->buildHtmlContextMenu();
        
        // Move promoted buttons to a separate toolbar with position=floating
        // to render them as a material design floating action button
        /* @var $floating_toolbar \exface\Core\Widgets\DataToolbar */
        $floating_toolbar = WidgetFactory::create($widget->getPage(), 'DataToolbar', $widget);
        $floating_toolbar->setPosition(nd2DataToolbar::POSITION_FLOATING);
        $main_toolbar = $widget->getToolbarMain();
        foreach ($main_toolbar->getButtons(function ($b) {return $b->getVisibility() === EXF_WIDGET_VISIBILITY_PROMOTED;}) as $btn){
            $floating_toolbar->addButton($btn);
            $main_toolbar->removeButton($btn);
        }
        if ($floating_toolbar->hasButtons()){
            $widget->addToolbar($floating_toolbar);
        }
        
        // Toolbars
        $footer = $this->buildHtmlFooter($this->buildHtmlToolbars());
        $header = $this->buildHtmlHeader();
        
        $wrapperClasses = '';
        if ($widget->hasParent() && $widget->getParent() instanceof Container && $widget->getParent()->countWidgetsVisible() > 1) {
            $wrapperClasses .= 'nd2-card';
        }
        
        // output the html code
        // TODO replace "stripe" class by a custom css class
        $output = <<<HTML
<div class="{$wrapperClasses}">
    {$header}
    <div class="jqmDataTable">
    	{$this->buildHtmlTable('mdl-data-table stripe')}
    </div>
    {$footer}
</div>
{$context_menu}
HTML;
        
        return $output;
    }
    
    protected function buildHtmlCardWrapper(string $html) : string
    {
        
    }
    
    protected function movePromotedButtonsToFloatingActionMenu()
    {
        
    }

    public function buildJs($jqm_page_id = null)
    {
        /* @var $widget \exface\Core\Widgets\DataTable */
        $widget = $this->getWidget();
        
        if (is_null($jqm_page_id)){
            $jqm_page_id = $this->getJqmPageId();
        }
        
        $output = <<<JS
var {$this->getId()}_table;

$(document).on('pageshow', '#{$jqm_page_id}', function() {
	
	if ({$this->getId()}_table && $.fn.DataTable.isDataTable( '#{$this->getId()}' )) {
		{$this->getId()}_table.columns.adjust();
		return;
	}	
	
	$('#{$this->getId()}_popup_columns input').click(function(){
		setColumnVisibility(this.name, (this.checked ? true : false) );
	});
	
    {$this->buildJsNoInitialLoadMessageBefore()}
    
	{$this->getId()}_table = {$this->buildJsTableInit()}
	
    {$this->buildJsNoInitialLoadMessageAfter()}
	
    {$this->buildJsClickListeners()}
    
    {$this->buildJsInitialSelection()}
    
    {$this->buildJsPagination()}
    
    {$this->buildJsQuicksearch()}
    
    {$this->buildJsRowDetails()}
    
    {$this->buildJsTapHandler()}

} );
	
function setColumnVisibility(name, visible){
	{$this->getId()}_table.column(name+':name').visible(visible);
	$('#columnToggle_'+name).attr("checked", visible);
	try {
		$('#columnToggle_'+name).checkboxradio('refresh');
	} catch (ex) {}
}

function {$this->getId()}_drawPagination(){
	var pages = {$this->getId()}_table.page.info();
	if (pages.page == 0) {
		$('#{$this->getId()}_prevPage').addClass('ui-disabled');
	} else {
		$('#{$this->getId()}_prevPage').removeClass('ui-disabled');
	}
	if (pages.page == pages.pages-1 || pages.end == pages.recordsDisplay) {
		$('#{$this->getId()}_nextPage').addClass('ui-disabled');
	} else {
		$('#{$this->getId()}_nextPage').removeClass('ui-disabled');	
	}
	$('#{$this->getId()}_pageInfo').html(pages.page*pages.length+1 + ' - ' + (pages.recordsDisplay < (pages.page+1)*pages.length || pages.end == pages.recordsDisplay ? pages.recordsDisplay : (pages.page+1)*pages.length) + ' / ' + pages.recordsDisplay);
	
}

{$this->getFacade()->getElement($widget->getConfiguratorWidget())->buildJs($jqm_page_id)}
	
{$this->buildJsRowGroupFunctions()}
    
{$this->buildJsButtons()}

JS;
        
        return $output;
    }

    public function buildHtmlHeadTags()
    {
        $includes = parent::buildHtmlHeadTags();
        $facade = $this->getFacade();
        
        // $includes[] = '<link rel="stylesheet" type="text/css" href="exface/vendor/exface/NativeDroid2Facade/Facades/js/DataTables/media/css/jquery.dataTables.min.css">';
        // $includes[] = '<script type="text/javascript" src="exface/vendor/exface/NativeDroid2Facade/Facades/js/DataTables/media/js/jquery.dataTables.min.js"></script>';
        $includes[] = '<script type="text/javascript" src="exface/vendor/exface/NativeDroid2Facade/Facades/js/DataTables.exface.helpers.js"></script>';
        
        if ($this->getWidget()->hasRowGroups()){
            $includes[] = '<script type="text/javascript" src="' . $facade->buildUrlToSource('LIBS.DATATABLES.ROWGROUP.JS') . '"></script>';
            $includes[] = '<link rel="stylesheet" type="text/css" href="' . $facade->buildUrlToSource('LIBS.DATATABLES.ROWGROUP.CSS') . '">';
        }
        
        if ($this->isResponsive()){
            $includes[] = '<script type="text/javascript" src="' . $facade->buildUrlToSource('LIBS.DATATABLES.RESPONSIVE.JS') . '"></script>';
            $includes[] = '<link rel="stylesheet" type="text/css" href="' . $facade->buildUrlToSource('LIBS.DATATABLES.RESPONSIVE.CSS') . '">';
        }
        
        return $includes;
    }

    /**
     * Generates a popup context menu with actions available upon selection of a row.
     * The menu contains all buttons, that do
     * something with a specific object (= the corresponding action has input_rows_min = 1) or do not have an action at all.
     * This way, the user really only sees the buttons, that perform an action with the selected object and not those, that
     * do something with all object, create new objects, etc.
     */
    private function buildHtmlContextMenu()
    {
        if (! $this->getWidget()->getContextMenuEnabled())
            return '';
        $buttons_html = '';
        foreach ($this->getWidget()->getButtons() as $b) {
            /* @var $b \exface\Core\Widgets\Button */
            if (! $b->isHidden() && $b->getAction()) {
                $buttons_html .= '<li data-icon="false"><a href="#" onclick="' . $this->getFacade()->getElement($b)->buildJsClickFunctionName() . '(); $(this).parent().parent().parent().popup(\'close\');"><i class="' . $this->buildCssIconClass($b->getIcon()) . '"></i> ' . $b->getCaption() . '</a></li>';
            }
        }
        
        if ($buttons_html) {
            $output = <<<HTML
<div data-role="popup" id="{$this->getId()}_context_menu" class="exf-context-menu">
	<ul data-role="listview" data-inset="false">
		{$buttons_html}
	</ul>
</div>
HTML;
        }
        return $output;
    }

    protected function buildHtmlHeader()
    {
        $table_caption = $this->getWidget()->getCaption() ? $this->getWidget()->getCaption() : $this->getMetaObject()->getName();
        $widget = $this->getWidget();
        $output = <<<HTML
	      <div class="ui-grid-a ui-responsive card-title has-supporting-text">
    			<div class="ui-block-a">
    				<h3 class="card-primary-title">$table_caption</h3>
    			</div>
    			<div class="ui-block-b exf-quick-search">
                    <form id="{$this->getId()}_quickSearch_form">
                        <div class="ui-grid-a pull-right" style="width: 100%">
                            <div class="ui-block-a" style="width: calc(100% - 108px); margin-right: 10px;">
        				        <input id="{$this->getFacade()->getElement($widget->getQuickSearchWidget())->getId()}" type="text" placeholder="{$this->getWidget()->getQuickSearchPlaceholder()}" data-clear-btn="true" />
                            </div>
                            <div class="ui-block-b" style="width: 98px;">
                                <a href="#" data-role="button" class="ui-btn ui-btn-inline ui-btn-mini" onclick="{$this->buildJsRefresh(false)} return false;"><i class="fa fa-search"></i></a>
                                <a href="#{$this->getFacade()->getElement($widget->getConfiguratorWidget())->getId()}" data-role="button" class="ui-btn ui-btn-inline"><i class="fa fa-filter"></i></a>
                            </div>
        				</div>
                        </form>
    			</div>
		</div>
HTML;
        return $output;
    }

    protected function buildHtmlFooter($buttons_html)
    {
        $widget = $this->getWidget();
        
        if ($widget->isPaged() === true) {
            $pagingButtons = <<<HTML

            <a href="#{$this->getId()}_pagingPopup" id="{$this->getId()}_pageInfo" data-rel="popup" class="ui-btn ui-btn-inline"></a>
		    <div data-role="popup" id="{$this->getId()}_pagingPopup" style="width:300px; padding:10px;">
				<form>
				    <label for="{$this->getId()}_pageSlider">Page:</label>
				    <input type="range" name="{$this->getId()}_pageSlider" id="{$this->getId()}_pageSlider" min="1" max="100" value="1">
				</form>
			</div>
			<a href="#" id="{$this->getId()}_prevPage" class="ui-btn ui-btn-inline"><i class="fa fa-chevron-left"></i></a>
			<a href="#" id="{$this->getId()}_nextPage" class="ui-btn ui-btn-inline"><i class="fa fa-chevron-right"></i></a>

HTML;
            $paginatorStyle = 'min-width: 350px';
        } else {
            $paginatorStyle = 'min-width: 92px';
        }
        
        $style = '';
        if ($widget->getHideFooter()) {
            $style .= 'display: none;';
        }
        
        $output = <<<HTML

<div class="card-action" style="{$style}">
    <div class="box">
		<div class="pull-right text-right exf-toolbar exf-paginator" style="{$paginatorStyle}">
			<a href="#{$this->getFacade()->getElement($widget->getConfiguratorWidget())->getId()}" class="ui-btn ui-btn-inline" title="{$this->translate('WIDGET.DATATABLE.SETTINGS_DIALOG.TITLE')}"><i class="fa fa-filter"></i></a>
			<a href="#" class="ui-btn ui-btn-inline" onclick="{$this->buildJsRefresh(false)} return false;" title="{$this->translate('WIDGET.REFRESH')}"><i class="fa fa-refresh"></i></a>
			{$pagingButtons}
		</div>
        <div>{$buttons_html}</div>
	</div>
</div>
HTML;
        return $output;
    }
    
    
    
    /**
     * Renders javascript event handlers for tapping on rows.
     * A single tap (or click) selects a row, while a longtap opens the
     * context menu for the row if one is defined. The long tap also selects the row.
     */
    protected function buildJsTapHandler()
    {
        $output = '';
            // Select a row on tap. Make sure no other row is selected
            $output .= "
                $('#{$this->getId()} tbody').on( 'taphold', '{$this->buildCssSelectorDataRows()}', function(e){
                    {$this->getId()}_table.row($(e.target).closest('{$this->buildCssSelectorDataRows()}')).select();
                } );
             ";
        return $output;
    }

    protected function buildJsPagination()
    {
        $output = <<<JS
	$('#{$this->getId()}_prevPage').on('click', function(){{$this->getId()}_table.page('previous'); {$this->buildJsRefresh()}});
	$('#{$this->getId()}_nextPage').on('click', function(){{$this->getId()}_table.page('next'); {$this->buildJsRefresh()}});
	
	$('#{$this->getId()}_pagingPopup').on('popupafteropen', function(){
		$('#{$this->getId()}_pageSlider').val({$this->getId()}_table.page()+1).attr('max', {$this->getId()}_table.page.info().pages).slider('refresh');
	});
	
	$('#{$this->getId()}_pagingPopup').on('popupafterclose', function(){
		{$this->getId()}_table.page(parseInt($('#{$this->getId()}_pageSlider').val())-1).draw(false);
	});
JS;
        return $output;
    }

    /**
     * Generates JS to disable text selection on the rows of the table.
     * If not done so, every time you longtap a row, something gets selected along
     * with the context menu being displayed. It look awful.
     *
     * @return string
     */
    private function buildJsDisableTextSelection()
    {
        return "$('#{$this->getId()} tbody tr td').attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);";
    }
    
    public function buildJsFilterIndicatorUpdater()
    {
        // TODO
    }
    
    /**
     *
     * @param Button[] $buttons
     * @return string
     */
    protected function buildJsContextMenu()
    {
        $output = '';
        // Listen for a long tap to open the context menu. Also trigger a click event, but enforce row selection.
        if ($this->getWidget()->getContextMenuEnabled()) {
            $output .= "
				$('#{$this->getId()} tbody').on( 'taphold', '{$this->buildCssSelectorDataRows()}', function (event) {
					$(this).trigger('click');
					$(this).addClass('selected');
					$('#{$this->getId()}_context_menu').popup('open', {x: exfTapCoordinates.X, y: exfTapCoordinates.Y});
				});";
        }
        
        return $output;
    }
    
    /**
     *
     * @return string
     */
    protected function buildJsNoInitialLoadMessageBefore()
    {
        $widget = $this->getWidget();
        
        if (! $widget->getAutoloadData() && $widget->getLazyLoading()) {
            // Wenn noetig initiales Laden ueberspringen.
            $output = <<<JS
            
        $("#{$this->getId()}").data("_skipNextLoad", true);
JS;
            
            // Dieses Skript wird nach dem erfolgreichen Laden ausgefuehrt, um die angezeigte
            // Nachricht (s.u.) zu entfernen. Das Skript muss vor $grid_head erzeugt werden.
            $onLoadSuccessSkript = <<<JS
            
        $("#{$this->getId()}_no_initial_load_message").remove();
JS;
            $this->addOnLoadSuccess($onLoadSuccessSkript);
        } else {
            $output = '';
        }
        
        return $output;
    }
    
    /**
     * Generates JS code to show a message if the initial load was skipped.
     *
     * @return string
     */
    protected function buildJsNoInitialLoadMessageAfter()
    {
        $widget = $this->getWidget();
        
        if (! $widget->getAutoloadData() && $widget->getLazyLoading()) {
            $output = <<<JS
            
            $("#{$this->getId()}").closest(".jqmDataTable").append("\
                <div id='{$this->getId()}_no_initial_load_message'\
                     class='no-initial-load-message-overlay'>\
                    <table class='no-initial-load-message-overlay-table'>\
                        <tr>\
                            <td style='text-align:center;'>\
                                {$widget->getAutoloadDisabledHint()}\
                            </td>\
                        </tr>\
                    </table>\
                </div>\
            ");
JS;
        } else {
            $output = '';
        }
        
        return $output;
    }
}
?>