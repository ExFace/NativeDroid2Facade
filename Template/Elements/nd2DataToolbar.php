<?php
namespace exface\NativeDroid2Template\Template\Elements;

use exface\Core\Widgets\DataToolbar;
use exface\Core\CommonLogic\Constants\Icons;

/**
 * The nativeDroid2 implementation of the DataToolbar with the option to create
 * a material design floating action button if the position of the toolbar
 * is set to "floating".
 *
 * @author Andrej Kabachnik
 *
 * @method DataToolbar getWidget()
 */
class nd2DataToolbar extends nd2Toolbar
{
    const POSITION_FLOATING = 'FLOATING';
    
    public function buildHtmlButtons()
    {
        // Render buttons normally unless the position is set to floating
        if (strtoupper($this->getWidget()->getPosition()) !== self::POSITION_FLOATING){
            return parent::buildHtmlButtons();
        } else {
            return $this->buildHtmlFloatingActionMenu();
        }
    }
    
    protected function buildHtmlFloatingActionMenu()
    {
        $widget = $this->getWidget();
        
        // Position = FLOATING means, we need a material design floating action button or menu
        if ($widget->countButtons() === 1){
            $btn = $widget->getButton(0);
            $main_button_icon_class = $this->buildCssIconClass($btn->getIcon());
            $main_button_icon_class_active = $main_button_icon_class;
            $main_button_properties = 'data-mfb-label="' . $btn->getCaption() . '" onclick="' . $this->getTemplate()->getElement($btn)->buildJsClickFunctionName() . '()"';
        } else {
            $main_button_icon_class = $this->buildCssIconClass(Icons::ELLIPSIS_V);
            $main_button_icon_class_active = $this->buildCssIconClass(Icons::TIMES);
            $main_button_properties = 'onclick="$(\'.mfb-component__list a\').removeClass(\'waves-effect\').removeClass(\'waves-button\');"';
            foreach ($widget->getButtons() as $btn){
                $menu_html .= <<<HTML

      <li>
        <a href="#" data-mfb-label="{$btn->getCaption()}" class="mfb-component__button--child" onclick="{$this->getTemplate()->getElement($btn)->buildJsClickFunctionName()}();">
          <i class="mfb-component__child-icon {$this->buildCssIconClass($btn->getIcon())}"></i>
        </a>
      </li>

HTML;
            }
            $menu_html = $menu_html ? '<ul class="mfb-component__list">' . $menu_html . '</ul>' : '';
        }
        
        return <<<HTML
        
<ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="click">
  <li class="mfb-component__wrap">
    <!-- the main menu button -->
    <a class="mfb-component__button--main" {$main_button_properties}>
      <!-- the main button icon visibile by default -->
      <i class="mfb-component__main-icon--resting {$main_button_icon_class}"></i>
      <!-- the main button icon visibile when the user is hovering/interacting with the menu -->
      <i class="mfb-component__main-icon--active {$main_button_icon_class_active}"></i>
    </a>
    {$menu_html}
  </li>
</ul>

HTML;
    }
}
?>