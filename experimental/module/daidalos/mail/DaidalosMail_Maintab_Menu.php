<?php
/*******************************************************************************
*
* @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage Daidalos
 * @author Malte Schirmacher <malte.schirmacher@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosMail_Maintab_Menu extends WgtDropmenu
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $params)
  {


    $entries = new TArray();
    $entries->support = $this->entriesSupport($params);

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}"  >
  <li class="wgt-root" >
    <button class="wgt-button" ><i class="icon-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" ><i class="icon-bookmark" ></i> {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->support}
      <li>
        <p class="wgtac_close" ><i class="icon-remove" ></i> {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

  }//end public function buildMenu */



  /**
   * @param TFlag $params
   */
  protected function entriesSupport($params)
  {

    $iconHelp = $this->view->icon('control/help.png'     ,'Help');

    $html = <<<HTML

      <li>
        <p><i class="icon-question-sign" ></i> Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" ><i class="icon-question" ></i> Faq</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * just add the code for the edit ui controls
   *
   * @param int $objid die rowid des zu editierende Datensatzes
   * @param TFlag $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *     die aktuelle maske
   *
   *   @param string formId: die html id der form zum ansprechen des update
   *     services
   * }
   */
  public function injectActions($view, $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });


BUTTONJS;

    $view->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdlProject_Maintab_Menu

