<?php

class Backup_Action extends Action
{

  /**
	 * Benutzerobjekt mit dessen Rechten die Aktion ausgeführt wird.
	 *
	 * @var User
	 */
  public $user = null;

  /**
	 * Das Umgebungsobjekt.
	 *
	 * @var LibFlowApachemod $env
	 */
  public $env = null;

  /**
	 * Pfad zu den Backups
	 *
	 * @var String
	 */
  public $backupPathWin = "C:\\Backup";

  /**
   * Response Objekt für Logging etc.
   * @var LibResponseCollector
   */
  public $response = null;

  /**
   * 
   * @var string
   */
  public $DBdataPath = "C:\\Program Files (x86)\\PostgreSQL\\9.2\\data";

  public $zipPath = "C:\\Program Files\\7-Zip\\7z.exe";

  /**
	 *
	 * @param LibFlowApachemod $env        	
	 */
  public function __construct ($env = null, $response = null)
  {

    if ($env) {
      $this->env = $env;
    } else {
      $this->env = WebFrap::$env;
    }
    
    if ($response) {
      $this->response = $response;
    } else {
      $this->response = new LibResponseCollector();
    }
  }

  /**
	 * Trigger für das Backup einer einzelnen Tabelle
	 *
	 * @param String $tableName        	
	 */
  public function trigger_table ($tableName)
  {

    echo "Starting Backup of Table " . $tableName . "<br>";
    
    $filename = $tableName . "-backup-" . time() . ".csv";
    
    $path = implode('\\', array(
        $this->backupPathWin, 
        $filename
    ));
    
    $db = $this->env->getDb();
    
    $sql = <<<SQL
		
		COPY {$tableName}
		TO '{$path}'
		CSV HEADER
		
SQL;
    
    $db->query($sql);
  }

  /**
	 * Trigger für das Backup einer kompletten Datenbank
	 *
	 * @param String $databaseName        	
	 */
  public function trigger_database ($response)
  {
    
    echo "Starting Backup of Database: " . $databaseName . "<br>";
  }

  /**
	 * Trigger für das Backup eines gesamten Servers
	 */
  public function trigger_all ()
  {

    echo "Starting Backup of All Data";
  }

  /**
   * Testmethode, 1 = true, 0 = false
   * @param int $tv
   * @param LibResponseCollector $response
   * @return boolean
   */
  public function trigger_happy ($tv, $response)
  {

    $result = false;
    
    if ($tv == "1") {
      $response->addMessage("Eingabe erfolgreich!");
      $result = true;
    }
    if ($tv == "0") {
      $response->addWarning("Eingabe nicht erfolgreich!");
      $result = false;
    }
    
    return $result;
  }

  public function trigger_continuousArchive ($response)
  {

    $label = "lalalalaTestBackup";
    
    $db = $this->env->getDb();
    
    // Force Checkpoint
    $sql = "SELECT pg_start_backup('{$label}', true)";
    
    $db->query($sql);
    
    system("C:\\Backup\\bck.cmd");
    
    $sql = "SELECT pg_stop_backup()";
    
    $db->query($sql);
  }

  /**
	 * (non-PHPdoc)
	 *
	 * @see BaseChild::setUser()
	 */
  public function setUser ($user)
  {

    $this->user = $user;
  }
}

?>