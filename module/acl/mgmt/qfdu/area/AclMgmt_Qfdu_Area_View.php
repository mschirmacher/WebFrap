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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Area_View
  extends LibTemplateAreaView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var AclMgmt_Model
    */
    public $model = null;
    
   /**
    * @var DomainNode
    */
    public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * display the Quallified users tab
  *
  * @param int $areaId
  * @param TFlag $params
  *
  * @return boolean
  */
  public function displayTab( $areaId, $params )
  {

    // create the form action
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Acl.Mgmt.searchQfdUsers&dkey'.$this->domainNode->domainName.'&area_id='.$areaId;

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-qfdu-search';

    // fill the relevant data for the search form
    $this->setSearchFormData( $params );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-update';

     // create the form action
    if( !$params->formActionAppend )
      $params->formActionAppend = 'ajax.php?c=Acl.Mgmt.appendQfdUser&dkey'.$this->domainNode->domainName;

    // add the id to the form
    if( !$params->formIdAppend )
      $params->formIdAppend = 'wgt-form-'.$this->domainNode->domainName.'-acl-qfdu-append';

    // append form actions
    $this->setFormData( $params->formActionAppend, $params->formIdAppend, $params, 'Append' );

    // set the path to the template
    $this->setTemplate( 'acl/mgmt/maintab/tab_qualified_users' );

    $this->addVar( 'areaId', $areaId );
    $this->addVar( 'domain', $this->domainNode );

    // create the ui helper object
    $ui = $this->loadUi( 'AclMgmt_Qfdu' );

    // inject needed resources in the ui object
    $ui->setModel( $this->model );
    $ui->setView( $this );
    $ui->domainNode = $this->domainNode;

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers( $areaId, $params ),
      $areaId,
      $params->access,
      $params
    );

    //add selectbox
    $selectboxGroups = new WgtSelectbox( 'selectboxGroups', $this );
    $selectboxGroups->setData( $this->model->getAreaGroups( $areaId, $params ) );
    $selectboxGroups->addAttributes( array(
      'id'    => 'wgt-input-'.$this->domainNode->domainName.'-acl-qfdu-id_group',
      'name'  => 'wbfsys_group_users[id_group]',
      'class' => 'medium'
    ));

    $jsCode = <<<JSCODE

  \$S('input#wgt-input-{$this->domainNode->domainName}-acl-qfdu-id_user-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-{$this->domainNode->domainName}-acl-qfdu-id_user').val(objid);
    \$R.get( 'ajax.php?c=Wbfsys.RoleUser.data&amp;objid='+objid );
  });

  \$S('input#wgt-input-{$this->domainNode->domainName}-acl-qfdu-vid-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-{$this->domainNode->domainName}-acl-qfdu-vid').val(objid);
    \$R.get( 'ajax.php?c={$this->domainNode->domainUrl}.data&amp;objid='+objid );
  });

JSCODE;

    $this->addJsCode( $jsCode );

    // kein fehler alles klar
    return null;

  }//end public function displayTab */

} // end class AclMgmt_Qfdu_Area_View */

