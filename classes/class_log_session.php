<?php
class Login {
    public $user;
    public function __construct() {
        session_start();

        $this->DB = $DB;
    }

    public function verify_user() {
        if (!isset($_SESSION['username'])) {
            return false;
        }

        $username = $_SESSION['username'];
    }

    private function user_exists($where_value, $where_field = 'username') {
        $user = $this->DB->get_results("SELECT * FROM accounts WHERE {$where_field} = :where_value", ['where_value'=>$where_value]);
        
        if ( false !== $user ) {
            return $user[0];
        }
        
        return false;
    }
}
?>