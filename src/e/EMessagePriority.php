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
 * @package WebFrap
 * @subpackage tech_core
 */
class EMessagePriority
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const LOW = 1;

  /**
   * @var int
   */
  const NORMAL = 2;

  /**
   * @var int
   */
  const HIGH = 3;
  
  /**
   * @var array
   */
  public static $labels = array(
    self::LOW => 'Low',
    self::NORMAL=> 'Normal',
    self::HIGH => 'High',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : self::$labels[self::NORMAL];

  }//end public static function label */

}//end class EMessagePriority

