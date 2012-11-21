<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
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
 * 
 * @package WebFrap
 * @subpackage Export
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 * 
 */
class WebfrapExport_Controller
  extends MvcController_Domain
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   * 
   * method: Der Service kann nur mit den im Array vorhandenen HTTP Methoden
   *   aufgerufen werden. Wenn eine falsche Methode verwendet wird, gibt das 
   *   System automatisch eine "Method not Allowed" Fehlermeldung zurück
   * 
   * views: Die Viewtypen die erlaubt sind. Wenn mit einem nicht definierten
   *   Viewtype auf einen Service zugegriffen wird, gibt das System automatisch
   *  eine "Invalid Request" Fehlerseite mit einer Detailierten Meldung, und der
   *  Information welche Services Viewtypen valide sind, zurück
   *  
   * public: boolean wert, ob der Service auch ohne Login aufgerufen werden darf
   *   wenn nicht vorhanden ist die Seite per default nur mit Login zu erreichen
   * 
   * @var array
   */
  protected $options           = array
  (
    'list' => array
    (
      'method'    => array( 'GET' ),
      //'views'      => array( 'document' )
    ),
    
  );
    
////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * 
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_list( $request, $response )
  {

    // load request parameters an interpret as flags
    $context     = new ContextDomainListing( $request );
    $domainNode  = $this->getDomainNode( $request );
    $variant     = $this->getVariant( $request );

    /* @var $model WebFrapExport_Model  */
    $model = $this->loadDomainModel( $domainNode, 'WebfrapExport' );
    $model->injectAccessContainer( $variant, $context );

    $className = $domainNode->domainKey.'_'.$variant->mask.'_Document';
    
    $exportModel = $this->loadModel( $domainNode->domainKey.'_'.$variant->mask  );
    
    $exportDoc = new $className
    (
      $env, 
      $domainNode->pLabel.' Export', 
      null,
      $domainNode->domainKey.'_'.$variant->mask.'_Sheet'
    );
    
    $dataSheet = $exportDoc->getSheet();
    $dataSheet->data = $exportModel->search( $context->access, $context );
    
    $exportDoc->executeRenderer();

  }//end public function service_list */

  
  /**
   * @param LibRequestHttp $request
   * @return DomainSimpleSubNode
   */
  public function getVariant( $request )
  {
    
    $variant = $request->param( 'variant', Validator::CNAME );
    
    if( !$variant )
      $variant = 'export';
      
    return new DomainSimpleSubNode( $variant );
    
  }//end public function getVariant */


} // end class WebfrapExport_Controller */

