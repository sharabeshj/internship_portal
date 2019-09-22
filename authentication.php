<?php 
    require('db.php');
    class User 
    {
        const cookie_name = 'auth_cookie';
        const session_cookie = 604800;

        private $user_id;
        private $username;
        private $is_authenticated;
        private $session_id;
        private $session_start_time;
        private $db;

        public static function add_user($username, $password, $role, &$db)
        {
            if(mb_strlen($username) < 3)
            {
                return TRUE;
            }
            if ((mb_strlen($password) < 3) && (mb_strlen($password) > 24))
            {
                return TRUE;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO users (username, password, role) VALUES (?,?,?)';
            if($db->dbquery($sql, array("sss", $username, $hash, $role)))
            return TRUE;
            return FALSE;
        }

        public static function delete_user($user_id, &$db)
        {
            $sql = 'DELETE FROM sessions WHERE (user_id = ?)';
            if($db->dbquery($sql, 'i', $user_id))
                return TRUE;
            return FALSE;
        }

        public static function edit_user($user_id, &$db, $username=NULL, $password = NULL)
        {
            $sql_vars = array();
            $sql = 'UPDATE users SET ';

            if(!isnull($username))
            {
                $sql .= 'username = ?, ';
                $sql_vars[] = $username;
            }

            if(!is_null($password))
            {
                $sql .= 'password = ?, ';
                $sql_vars[] = password_hash($password, PASSWORD_DEFAULT);
            }

            if(count($sql_vars) == 0)
            {
                return TRUE;
            }

            $sql = mb_substr($sql, 0, -2) . ' WHERE (user_id = ?)';
            $sql_vars[] = $user_id;

            if($db->dbquery($sql, $sql_vars, TRUE))
                return TRUE;
            return FALSE;
        }

        public function __construct()
        {
            $this->user_id = NULL;
            $this->username = NULL;
            $this->is_authenticated = FALSE;
            $this->session_id = NULL;
            $this->session_start_time = NULL;
            $this->db = db::getInstance();
        }

        public function login($name, $password) 
        {
            if((mb_strlen($password) < 3) || (mb_strlen($password) > 24))
                return FALSE;
            
            $sql = 'SELECT * FROM users WHERE (username = ?)';
            $res = $this->db->get_result($sql, array($name));
            if(res)
            {
                if(password_verify($password, $res['password']))
                {
                    $this->user_id = $res['id'];
                    $this->username = $res['username'];
                    $this->is_authenticated = TRUE;
                    $this->session_start_time = time();

                    $this->create_session();
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function cookie_login()
        {
            if(array_key_exists(self::cookie_name, $_COOKIE))
            {
                if(mb_strlen($_COOKIE[self::cookie_name]) < 1)
                {
                    return FALSE;
                }

                $auth_sql = 'SELECT *,UNIX_TIMESTAMP(session_start) AS session_start_ts FROM ,users where (session_cookie = ?) AND (users.id = user_id)';
                $cookie_md5 = md5($_COOKIE[self::cookie_name]);
                $res = $this->db->getResult($auth_sql, array($cookie_md5));
                if($res)
                {
                    $this->user_id = $res['user_id'];
                    $this->username = $res['username'];
                    $this->is_authenticated = TRUE;
                    $this->session_id = $res['session_id'];
                    $this->session_start_time = intval($res['session_start_ts'],10);

                    return TRUE;
                }
            }
            return FALSE;
        }

        public function logout($close_all_sessions=FALSE)
        {
            if(mb_strlen($_COOKIE[self::cookie_name]) < 1)
                return TRUE;
            
            $cookie_md5 = md5($_COOKIE[self::cookie_name]);
            $sql = 'DELETE FROM sessions WHERE (session_cookie = ?) AND (user_id = ?)';
            if($this->db->dbquery($sql,array($cookie_md5, $this->user_id), TRUE))
            {
                if($close_all_sessions)
                {
                    $sql = 'DELETE FROM sessions WHERE (user_id = ?)';
                    $this->db->dbquery($sql, array($this->user_id), TRUE);
                }
                setcookie(self::cookie_name,'',0,'/');
                $_COOKIE[self::cookie_name] = NULL;

                $this->user_id = NULL;
                $this->username = NULL;
                $this->is_authenticated = FALSE;
                $this->session_id = NULL;
                $this->session_start_time = NULL;
                return TRUE;
            }
            return FALSE;
        }

        private function create_session()
        {
            $cookie = bin2hex(random_bytes(16));

            $sql = 'INSERT INTO sessions (session_cookie, user_id, session_start) VALUES (?,?,NOW())';
            if($this->db->dbquery($sql, array('ss',md5($cookie), $this->user_id)))
            {
                $this->session_id = $this->db->getPrevId();
                setcookie(self::cookie_name, $cookie, time() + self::session_time, '/');
                $_COOKIE[self::cookie_name] = $cookie;

                return TRUE;
            }
            return FALSE;
        }
    }
?>