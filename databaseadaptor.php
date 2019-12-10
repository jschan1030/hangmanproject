<?php
class DatabaseAdaptor {
    private $DB; // The instance variable used in every method
    // Connect to an existing data based named 'first'
    
    public function __construct() {
        $dataBase = 'mysql:dbname=hangman;charset=utf8;host=127.0.0.1';
        $user = 'root';
        $password = ''; // Empty string with XAMPP install
       
 
        try {
            $this->DB = new PDO ( $dataBase, $user, $password);
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    } // . . . continued
    // ACCOUNT DETAILS FUNCTIONS
    public function checkUser($username, $email){
        $check = $this->DB->prepare("SELECT * FROM accounts WHERE username=".$username."or email=".$email."LIMIT 1");
        $result = mysqli_query($this->DB, $check);
        return mysqli_fetch_assoc($result);
        
        
    }
    public function newUser($username, $email, $pass){
        try{
            $add = $this->DB->prepare("INSERT INTO accounts VALUES(".rand(00000, 99999).", '".$username."','".$email."', 0,'".$pass."')");
        $add->execute();
      
            echo header("location: view.html");
        }
    
        catch(PDOException $e){
            
            echo "INSERT INTO accounts VALUES(".rand(00000, 99999).", '".$username."','".$email."', 0,'".$pass."'<br>" . $e->getMessage();
        }
        $this->DB = null;
    }
    public function getCredentials ($username, $pass) {
        $stmt = $this->DB->prepare( "SELECT * FROM accounts where username = ". $username . " AND password = " .$pass);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
 
}
}

?>