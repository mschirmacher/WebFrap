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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSettings_Search_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Conditions für die Query
   * @var array
   */
  public $conditions = array();


/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return WebfrapMessage_List_Access
   */
  public function loadUserAccess($params)
  {

    $user = $this->getUser();

    // ok nun kommen wir zu der zugriffskontrolle
    $this->access = new WebfrapMy_Data_Access(null, null, $this);
    $this->access->load($user->getProfileName(), $params);

    $params->access = $this->access;

    return $this->access;

  }//end public function loadUserAccess */


  /**
   * @param int $messageId
   * @param WebfrapMessage_Save_Request $rqtData
   * @throws Per
   */
  public function saveMessage($messageId, $rqtData)
  {

    $orm = $this->getOrm();
    $db = $this->getDb();
    $user = $this->getUser();

    foreach ($rqtData->aspects as $aspect) {
      $msgAspect = $orm->newEntity('WbfsysMessageAspect');
      $msgAspect->id_receiver = $user->getId();
      $msgAspect->id_message = $messageId;
      $msgAspect->aspect = $aspect;
      $orm->insertIfNotExists($msgAspect, array('id_receiver','id_message','aspect'));
    }

    // die anderen löschen
    $orm->deleteWhere(
    	'WbfsysMessageAspect',
    	" id_receiver={$user->getId()} AND id_message={$messageId} AND NOT aspect IN(".implode(', ',$rqtData->aspects).") "
    );

    $msgNode = $orm->get('WbfsysMessage',$messageId);



    // task data speichern
    if ($rqtData->hasTask) {

      if($rqtData->taskId) {

        $entTask = $orm->get('WbfsysTask', $rqtData->taskId);

      } else {

        $entTask = $orm->newEntity('WbfsysTask');
        $entTask->id_message = $messageId;
      }

      $entTask->addData($rqtData->taskData);

      $orm->save($entTask);

    } else if($rqtData->taskId) {

      $orm->delete('WbfsysTask',$rqtData->taskId);
      $rqtData->receiverData['flag_action_required'] = false;

    }

    // appointment data speichern
    if ($rqtData->hasAppointment) {

      if($rqtData->appointId) {

        $entAppoint = $orm->get('WbfsysAppointment', $rqtData->appointId);

      } else {

        $entAppoint = $orm->newEntity('WbfsysAppointment');
        $entAppoint->id_message = $messageId;
      }

      $entAppoint->addData($rqtData->appointData);

      $orm->save($entAppoint);

    } else if ($rqtData->appointId) {

      // wenn id vorhanden dann löschen
      $orm->delete('WbfsysAppointment',$rqtData->appointId);
      $rqtData->receiverData['flag_participation_required'] = false;
    }


    // task data speichern
    $entRecv = $orm->get('WbfsysMessageReceiver', $rqtData->receiverId);
    $entRecv->addData($rqtData->receiverData);
    $orm->save($entRecv);

    $mainAspect = 0;

    if( in_array(EMessageAspect::MESSAGE, $rqtData->aspects) )
      $mainAspect = EMessageAspect::MESSAGE;
    elseif ( in_array(EMessageAspect::DOCUMENT, $rqtData->aspects) ) {
      $mainAspect = EMessageAspect::DOCUMENT;
    } else {
      $mainAspect = EMessageAspect::DISCUSSION;
    }

    if( $msgNode->main_aspect != $mainAspect ) {
      $msgNode->main_aspect = $mainAspect;
      $msgNode->id_sender_status = EMessageStatus::UPDATED;

      $orm->save($msgNode);
    }

    $tmpUSt = EMessageStatus::UPDATED;
    $tmpASt = EMessageStatus::ARCHIVED;

    // alle nicht archivierten oder gelöschten receiver updaten
    $sql = <<<SQL
UPDATE wbfsys_message_receiver
	set status = {$tmpUSt}
WHERE
	id_message = {$messageId}
	AND ( NOT status = {$tmpASt} OR flag_deleted  = true );
SQL;

    $db->update($sql);

  }//ebnd public function saveMessage

  /**
   * @param int $messageId
   */
  public function deleteMessage($messageId)
  {

    $db = $this->getDb();
    $orm = $this->getOrm();
    $user = $this->getUser();

    // erst mal eventuelle receiver & aspekte des users löschen
    $orm->deleteWhere( 'WbfsysMessageReceiver', 'vid = '.$user->getId().' and id_message = '.$messageId );
    $orm->deleteWhere('WbfsysMessageAspect', 'id_message='.$messageId.' and id_receiver = '.$user->getId() );

    $sql = <<<SQL
SELECT
	msg.flag_sender_deleted,
	msg.id_sender,
	count(recv.rowid) as num_receiver
FROM
	wbfsys_message msg
LEFT JOIN
	wbfsys_message_receiver recv
		ON recv.id_message = msg.rowid AND recv.vid = {$user->getId()}
WHERE
 	msg.rowid = {$messageId}
 		AND NOT recv.flag_deleted = true
GROUP BY
	msg.id_sender,
	msg.flag_sender_deleted
SQL;

    $tmpData = $db->select($sql)->get();

    if (!$tmpData) {
      // ok sollte nicht passieren
      return;
    }

    if( $tmpData['id_sender'] == $user->getId() ) {

      // nur löschen wenn keine receiver mehr da sind
      if( $tmpData['num_receiver'] ) {
        $orm->update( 'WbfsysMessage', $messageId, array('flag_sender_deleted'=>true) );
        return;
      }

    } else {

      // löschen wenn deleted flag
      if( 't' != $tmpData['flag_sender_deleted'] ) {
        return;
      }

    }

    $orm->delete('WbfsysMessage', $messageId);

    // referenz tabellen leeren
    $orm->deleteWhere('WbfsysMessageAspect', 'id_message='.$messageId); // aspekt flags
    $orm->deleteWhere('WbfsysTask', 'id_message='.$messageId); // eventueller task aspekt
    $orm->deleteWhere('WbfsysAppointment', 'id_message='.$messageId); // eventueller appointment aspekt
    $orm->deleteWhere('WbfsysMessageReceiver', 'vid='.$messageId); // alle receiver
    $orm->deleteWhere('WbfsysDataIndex', 'vid='.$messageId); // fulltext index der db
    $orm->deleteWhere('WbfsysDataLink', 'vid='.$messageId); // referenzen
    $orm->deleteWhere('WbfsysEntityAttachment', 'vid='.$messageId); // attachments

  }//ebnd public function deleteMessage

  /**
   * @param int $messageId
   */
  public function deleteAllMessage()
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();
    $orm = $this->getOrm();

    $queries = array();
    $queries[] = 'UPDATE wbfsys_message set flag_sender_deleted = true WHERE id_sender = '.$userID.';';
    $queries[] = 'DELETE FROM wbfsys_message_receiver WHERE vid = '.$userID.';';
    $queries[] = 'DELETE FROM wbfsys_message_aspect WHERE id_receiver = '.$userID.';';

    foreach ($queries as $query) {
      $db->exec($query);
    }

    // alle
    $sql = <<<SQL
SELECT
	msg.rowid as msg_id
FROM
	wbfsys_message msg
JOIN
	wbfsys_message_receiver recv
		ON recv.id_message = msg.rowid
having count(recv.rowid) = 0
WHERE
	msg.id_sender = {$userID}
SQL;


    $messages = $db->select($sql);

    $msgIds = array();

    foreach ( $messages as $msg ) {
      $msgIds[] = $msg['msg_id'];
    }

    $whereString = implode(', ', $msgIds);

    $orm->deleteWhere('WbfsysMessageAspect', 'id_message IN('.$whereString.')'); // aspekt flags
    $orm->deleteWhere('WbfsysTask', 'id_message IN('.$whereString.')'); // eventueller task aspekt
    $orm->deleteWhere('WbfsysAppointment', 'id_message IN('.$whereString.')'); // eventueller appointment aspekt
    $orm->deleteWhere('WbfsysMessageReceiver', 'id_message IN('.$whereString.')'); // alle receiver
    $orm->deleteWhere('WbfsysDataIndex', 'id_message IN('.$whereString.')'); // fulltext index der db
    $orm->deleteWhere('WbfsysDataLink', 'id_message IN('.$whereString.')'); // referenzen
    $orm->deleteWhere('WbfsysEntityAttachment', 'id_message IN('.$whereString.')'); // attachments

  }//end public function deleteAllMessage */

  /**
   *
   * @param int $messageId
   * @throws Per
   */
  public function deleteSelection($msgIds)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();
    $orm = $this->getOrm();

    if (!$msgIds)
      return;

    $sqlIds = implode(', ', $msgIds);

    $queries = array();
    $queries[] = 'UPDATE wbfsys_message set flag_sender_deleted = true WHERE id_sender = '.$userID.' AND rowid IN('.$sqlIds.');';
    $queries[] = 'DELETE FROM wbfsys_message_receiver WHERE vid = '.$userID.' AND id_message IN('.$sqlIds.');';
    $queries[] = 'DELETE FROM wbfsys_message_aspect WHERE id_receiver = '.$userID.' AND id_message IN('.$sqlIds.');';

    foreach ($queries as $query) {
      $db->exec($query);
    }

    // alle
    $sql = <<<SQL
SELECT
	msg.rowid as msg_id
FROM
	wbfsys_message msg
JOIN
	wbfsys_message_receiver recv
		ON recv.id_message = msg.rowid
having count(recv.rowid) = 0
WHERE
	msg.id_sender = {$userID} AND msg.rowid IN({$sqlIds})
SQL;


    $messages = $db->select($sql);

    $msgIds = array();

    foreach ( $messages as $msg ) {
      $msgIds[] = $msg['msg_id'];
    }

    // wenn keine msg ids dann sind wir fertig
    if(!$msgIds)
      return;

    $whereString = implode(', ', $msgIds);

    $orm->deleteWhere('WbfsysMessageAspect', 'id_message IN('.$whereString.')'); // aspekt flags
    $orm->deleteWhere('WbfsysTask', 'id_message IN('.$whereString.')'); // eventueller task aspekt
    $orm->deleteWhere('WbfsysAppointment', 'id_message IN('.$whereString.')'); // eventueller appointment aspekt
    $orm->deleteWhere('WbfsysMessageReceiver', 'id_message IN('.$whereString.')'); // alle receiver
    $orm->deleteWhere('WbfsysDataIndex', 'id_message IN('.$whereString.')'); // fulltext index der db
    $orm->deleteWhere('WbfsysDataLink', 'id_message IN('.$whereString.')'); // referenzen
    $orm->deleteWhere('WbfsysEntityAttachment', 'id_message IN('.$whereString.')'); // attachments

  }//end public function deleteSelection */


  /**
   *
   * @param User $user
   * @return WebfrapMessage_Table_Search_Settings
   */
  public function loadSettings()
  {

    $db     = $this->getDb();
    $user   = $this->getUser();
    $cache  = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);

    return $settingsLoader->getSetting(EUserSettingType::MESSAGES);

  }//end public function countNewMessages */

  /**
   * @param WebfrapMessage_Table_Search_Settings $settings
   */
  public function saveSettings($settings)
  {

    $db     = $this->getDb();
    $user   = $this->getUser();
    $cache  = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);
    $settingsLoader->saveSetting(EUserSettingType::MESSAGES, $settings);

  }//end public function countNewMessages */



} // end class WebfrapSettings_Search_Model

