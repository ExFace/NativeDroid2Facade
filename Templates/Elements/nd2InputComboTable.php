<?php
namespace exface\NativeDroid2Template\Templates\Elements;

use exface\Core\Widgets\InputComboTable;

/**
 * In jQuery Mobile a InputComboTable is represented by a filterable UL-list.
 * The code is based on the JQM-example below.
 * jqm example: http://demos.jquerymobile.com/1.4.5/listview-autocomplete-remote/
 * 
 * @method InputComboTable getWidget()
 *
 * @author Andrej Kabachnik
 *        
 */
class nd2InputComboTable extends nd2Input
{

    private $min_chars_to_search = 1;

    function buildHtml()
    {
        $output = '	<div class="exf-grid-item exf-input" title="' . $this->buildHintText() . '">
						<label for="' . $this->getId() . '">' . $this->getWidget()->getCaption() . '</label>
						<input id="' . $this->getId() . '_autocomplete_input" type="text" data-clear-btn="true" class="ui-input-has-clear" value="' . $this->getWidget()->getValueText() . '" />
						<input type="hidden"		
								id="' . $this->getId() . '" 
								name="' . $this->getWidget()->getAttributeAlias() . '"
								value="' . $this->escapeString($this->getWidget()->getValue()) . '" />
						<ul id="' . $this->getId() . '_autocomplete" data-role="listview" data-inset="true" data-filter="true" data-input="#' . $this->getId() . '_autocomplete_input" ></ul> 
					</div>';
        return $output;
    }

    function buildJs($jqm_page_id = null)
    {
        /* @var $widget \exface\Core\Widgets\InputComboTable */
        $widget = $this->getWidget();
        
        $jqm_page_id = ! is_null($jqm_page_id) ? $jqm_page_id : $this->getJqmPageId();
        
        $output = <<<JS
		
$(document).on('pagecreate', '#{$jqm_page_id}', function() {
	$( "#{$this->getId()}_autocomplete" ).on( "filterablebeforefilter", function ( e, data ) {
        var ul = $( this ),
            input = $( data.input ),
            value = input.val(),
            html = "";
        ul.html( "" );
        $('#{$this->getId()}').val('');
        if ( value && value.length >= {$this->min_chars_to_search} ) {
            ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
            ul.listview( "refresh" );
            $.ajax({
                url: "{$this->getAjaxUrl()}",
                dataType: "json",
                data: {
                	action: "{$widget->getLazyLoadingActionAlias()}",
                	resource: "{$this->getPageId()}",
					element: "{$widget->getTable()->getId()}",
					object: "{$widget->getTable()->getMetaObject()->getId()}",
                    q: input.val()
                },
				success: function ( response ) {
					$.each( response.data, function ( i, val ) {
	                    html += '<li><a href="#" exf-value="' + val.{$widget->getValueColumn()->getDataColumnName()} + '">' + val.{$widget->getTextColumn()->getDataColumnName()} + '</a></li>';
	                	if (response.data.length == 1){
	                		$('#{$this->getId()}').val(val.{$widget->getValueColumn()->getDataColumnName()});
	                		$("#{$this->getId()}_autocomplete_input").val(val.{$widget->getTextColumn()->getDataColumnName()});
                		}
					});
	                ul.html( html );
	                ul.listview( "refresh" );
	                ul.trigger( "updatelayout");
	            },
				error: function (jqXHR, status, error) {
					ul.html( "<li>Error: " + status + "</li>" );
					ul.listview( "refresh" );		
				}
            });
        }
    });
    
    $("#{$this->getId()}_autocomplete_input").on('input', function(event){ $( "#{$this->getId()}_autocomplete" ).html(''); });

});
	                    		
$( document ).on('click', '#{$this->getId()}_autocomplete li a', function(event){
	$('#{$this->getId()}').val($(this).attr('exf-value'));
	$("#{$this->getId()}_autocomplete_input").val($(this).html());
	$('#{$this->getId()}_autocomplete').html('');		
	event.preventDefault();
	return false;	
});
		
JS;
        return $output;
    }
}
?>