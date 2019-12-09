<?php
class DatabaseAdaptor {
    private $DB; // The instance variable used in every method
    // Connect to an existing data based named 'first'
    public function __construct() {
        $dataBase = 'mysql:dbname=hangman;charset=utf8;host=127.0.0.1';
        $user = 'root';
        $password = ''; // Empty string with XAMPP install
        try {
            $this->DB = new PDO ( $dataBase, $user, $password );
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    } // . . . continued
    // ACCOUNT DETAILS FUNCTIONS
    public function getCredentials ($username, $password) {
        $stmt = $this->DB->prepare( "SELECT * FROM accounts where username = ". $username . " AND password = " .$password);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateCredentials($id, $category, $token) {
        $stmt = $this->DB->prepare("UPDATE accounts SET " .$category . "= " . $token . "where 'id'=".$id.";");
        $stmt->execute();
    }
    public function createID() {
        $newid = random_int(10000,99999);
        $stmt = $this->DB->prepare("SELECT * FROM accounts where 'id'=" . $newid . ";");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //check for uniqueness?
        return $newid;
    }
    public function checkUniqueness($table, $category, $token) {
        $stmt = $this->DB->prepare("SELECT * FROM " . $table . " WHERE " . $category . "=".$token.";");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function newCredentials($username, $password, $email) {
        $id = createID();
        $score = 0;
        $stmt = $this->DB->prepare("INSERT INTO accounts (".$id.",".$username.",".$email.",".$score.",".$password.";");
        $stmt->execute();
    }
    
    // WORDS_PHRASES FUNCTIONS
    public function getWordPhrase ($difficulty, $word_or_phrase) {
        $stmt = $this->DB->prepare("SELECT entry FROM words_phrases where 'type'=" . $word_or_phrase . "  and 'level'=" . $difficulty. ";");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addWordPhrase ($difficulty, $word_or_phrase, $entry, $hint_entry, $id) {
        $stmt = $this->DB->prepare("INSERT INTO words_phrases (id,'entry','type','level',hint)
        VALUES (" . $id . "," . $entry . "," . $word_or_phrase . "," . $difficulty . "," . $hint_entry . ");");
        $stmt->execute();
    }

    // GAME TABLE FUNCTIONS
    public function getGameData ($gameaspect) {
        $stmt = $this->DB->prepare( "SELECT " . $gameaspect . " FROM game_scaffold;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addChosenLetter ($toAdd) {
        $stmt = $this->DB->prepare("IF NOT (SELECT 1 FROM game_scaffold WHERE 'letter_entered' = " . $toAdd . ") 
            BEGIN 
            INSERT INTO game_scaffold (letter_entered, lives, score)
            VALUES (".$toAdd . ",1,10)
            END
            ELSE
            BEGIN
            INSERT INTO game_scaffold (letter_entered, lives, score)
            VALUES (" . $toAdd . ",-1,-5)
            END;");
        $stmt->execute();
    }
    public function getTotal($column) {
        $stmt = $this->DB->prepare("SELECT SUM(" . $column . ") FROM game_scaffold");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} // End class DatabaseAdaptor
?>