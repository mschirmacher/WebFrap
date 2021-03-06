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
class SDate
{

  /**
   * get the actual time in standard format
   *
   * @return string
   */
  public static function getTime($format = 'H:i:s' , $time = null)
  {
    if ($time) {
      if (is_numeric($time)) {
        return date($format,$time);
      } else {
        return date($format,strtotime($time));
      }
    } else {
      return date($format);
    }

  }//end public static function getTime($format = 'H:i:s')

  /**
   * get the actual timestamp in standard format
   *
   * @return string
   */
  public static function getTimestamp($format = 'Y-m-d H:i:s' , $timestamp = null)
  {

    if ($timestamp) {
      if (is_numeric($timestamp)) {
        return date($format,$timestamp);
      } else {
        return date($format,strtotime($timestamp));
      }
    } else {
      return date($format);
    }

  }//end public static function getTimestamp */

  /**
   * get the actual date as standart format
   * @return string
   */
  public static function getDate($format = 'Y-m-d' , $date = null)
  {

    if ($date) {
      if (is_numeric($date)) {
        return date($format,$date);
      } else {
        return date($format,strtotime($date));
      }
    } else {
      return date($format);
    }

  }//end public static function getDate($format = 'Y-m-d')

  /**
   * Check if the year is a leapyear
   * @param boolean $timeStamp
   */
  public static function isLeapYear($timeStamp)
  {

    if ($timeStamp > 3000)
      return (date('L', $timeStamp) == '1') ;
    else
      return (date('L', mktime( 0, 0, 0, 1, 1, $timeStamp)) == '1');

  }//end public static function isLeapYear */

  /**
   * Anzahl der Tages eines Monats auslesen
   * kann durch wochentage oder wochen gefiltert werden
   *
   * z.B gibt mir die Anzahl Tage für
   * - Januar 2011,
   * - Wochentag: 1,3,5
   * - Woche: 1,3
   *
   * @var int $year
   * @var int $month
   * @var array $days
   * @var array $weeks
   */
  public static function getFilteredMonthDays($year, $month, $days = array(), $weeks = array())
  {

    $filteredDays = array();

    // anzahl tage im monat
    $numDays = (int) date('t', mktime( 0, 0, 0, $month, 1, $year));

    // position des ersten wochentages
    $startDay = (int) date('w',mktime(0, 0, 0, $month, 1, $year  ));

    if ($startDay !== 1 || $startDay !== 0) {
      $week = 0;
    } else {
      $week = 1;
    }

    for ($pos = 1; $pos < $numDays; ++$pos) {

      $theTime = mktime(0, 0, 0, $month, $pos,  $year  );

      $numDay = (int) date('w', $theTime);

      if ($weeks) {
        if (in_array($numDay, $days) && in_array($week, $weeks)) {
          $filteredDays[] = $pos;
        }
      } else {
        if (in_array($numDay, $days))
          $filteredDays[] = $pos;
      }

      // start next week
      if (0 === $numDay  )
        ++$week;

    }

    return $filteredDays;

  }//end public function getFilteredMonthDays */

  /**
   * Anzahl der Tage für einen bestimmten Monat
   * @param int $year
   * @param int $month
   * @return int
   */
  public static function getMonthDays($year, $month)
  {
    return date('t', mktime( 0, 0, 0, $month, 1,  $year));

  }//end public static function getMonthDays */
  
  /**
   * Erstellt ein Dateinterval String nach  http://en.wikipedia.org/wiki/Iso8601#Durations
   * @param int $duration
   * @param string $type
   * @return string
   */
  public static function durationToInterval($duration, $type = 'm')
  {
    
    $months = floor($duration);
    $days = ($duration - $months) * 30;
    
    if ($days) {
      return 'P'.$months.'M'.$days.'D';
    } else {
      return 'P'.$months.'M';
    }
    
  }//end public static function durationToInterval */

}// end class SDate

