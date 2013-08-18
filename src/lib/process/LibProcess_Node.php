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
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcess_Node
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Backlink zum Prozess
   * @var string
   */
  public $process = null;

  /**
   * Key des Projektknotens
   * @var string
   */
  public $key = null;

  /**
   * Key der aktuellen Projekt Phase
   * @var string
   */
  public $phaseKey = null;

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $order = null;

  /**
   * @var string
   */
  public $icon = null;

  /**
   * @var string
   */
  public $color = null;

  /**
   * @var string
   */
  public $description = null;

  /**
   * Complete node data
   * @var array
   */
  public $data = array();

/*//////////////////////////////////////////////////////////////////////////////
// Standard Konstruktor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Process $process der dazugehörige Prozess
   * @param array $nodeData die Daten des Nodes
   * @param string $key der Key des Nodes
   */
  public function __construct($process, array $nodeData, $key = null)
  {
    
    $this->process = $process;

    $this->data = $nodeData;
    $this->key = $key;

    $this->label = $nodeData['label'];

    $this->order = $nodeData['order'];

    $this->icon = isset($nodeData['icon'])
      ? $nodeData['icon']
      : 'process/go_on.png';

    $this->color = isset($nodeData['color'])
      ? $nodeData['color']
      : 'default';

    $this->description = isset($nodeData['description'])
      ? $nodeData['description']
      : '';

    $this->phaseKey = isset($nodeData['phase'])
      ? $nodeData['phase']
      : null;

  }//end public function __construct */
  
  
  /**
   * @param string $key
   * @return boolean
   */
  public function display($key)
  {
    return isset($this->data['display'][$key]) 
      ? $this->data['display'][$key]
      : true;
      
  }//end public function display */

}//end class LibProcess_Node

