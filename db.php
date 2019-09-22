<?php 
    include('./config.php');
    class db extends mysqli {
        private static $instance = null;

        private $user = DBUSERNAME;
        private $password = DBPWD;
        private $dbName = DBNAME;
        private $dbHost = DBHOST;

        public static function getInstance() {
            if (!self::$instance instanceof self) {
                self::$instance = new self;
            }
                return self::$instance;
        }

        public function __close() {
            triggerError('Clone is not allowed.', E_USER_ERROR);
        }
        public function __wakeup() {
            trigger_error('Deserializing is not allowed', E_USER_ERROR);
        }

        private function __construct() {
            parent::__construct($this->dbHost, $this->user, $this->password, $this->dbName);
            if(mysqli_connect_error()) {
                exit('Connect Error ('. mysqli_connect_errno . ') '.mysqli_connect_error());
            }
            parent::set_charset('utf-8');
        }

        public function dbquery($query,$params,$update=FALSE) {
            $stmt = $this->prepare($query);
            if($update)
            {
                if($stmt->execute($params)) 
                {
                    return TRUE;
                }
            }
            else
            {
                call_user_func_array(array($stmt, "bind_param"),$params);
                if($stmt->execute())
                    return TRUE;
            }
        }

        public function get_result($query,$params=NULL) {
            $stmt = $this->prepare($query);
            $result = $stmt->execute($params);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            } else 
                return null;
        }

        public function getPrevId()
        {
            return $this->getLastId();
        }
    }
?>