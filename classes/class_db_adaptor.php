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
    public function get_row($table, $id) {
        $stmt = $this->DB->prepare("SELECT * FROM {$table} WHERE 'id' = :id");
        $stmt->execute(array('id' => $id));
        $result = $stmt->fetch();
        
        return $result;
    }
    public function get_array($query, $parameters = array()) {
        if (empty($parameters)) {
            return $this->query($query);
        }
        if (!$stmt = $this->db->prepare($query)) {
            return false;	
        }
        $stmt->execute($parameters);

        while ($row = $stmt->fetch()) {
            $array[] = $row;
        }
        if (!empty($array)) {
            return $array;
        }
        
        return false;
    }
    public function query($query) {
        $stmt = $this->DB->query($query);
        while ($row = $stmt->fetch()) {
            $ret_array[] = $row;
        }
        return $ret_array;
    }

    public function insert($table, $item) {
        // Notice handling
		$columns = '';
		$placeholders = '';
			
		// Check for table or item not set
		if ((empty($table) || empty($item)) || !is_array($item)) {
			return false;
		}
            
        // Parse data for column and placeholder names
        foreach ($item as $key => $value) {
            // Concatenation but a little fancy to get any values from $key as a string.
            $columns .= sprintf('%s,', $key);
            $placeholders .= sprintf(':%s,', $key);
        }
            
        // Trim extra commas, with what happens above, the end of the string will have a comma.
        $columns = rtrim($columns, ',');
        $placeholders = rtrim($placeholders, ',');
		
		// Prepare the statement
		$stmt = $this->DB->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
			
		// Execute statement
		$stmt->execute($item);
		if ($stmt->rowCount()) {
            // Check for successful insertion
			return true;
		}
			
		return false;
    }

    public function update($table, $item, $where_id) {
        // Check for table or item not set
        if ((empty($table) || empty($item)) || empty($item)) {
            return false;
        }
        
        // Parse data for column and placeholder names
        foreach ($item as $key => $value) {
            $placeholders .= sprintf('%s=:%s,', $key, $key);
        }
        
        // Trim excess commas
        $placeholders = rtrim($placeholders, ',');
        
        // Append where ID to $item
        $item['where_id'] = $where_id;
        
        // Prepary our query for binding
        $stmt = $this->db->prepare("UPDATE {$table} SET {$placeholders} WHERE ID = :where_id");
        
        // Execute the query
        $stmt->execute($item);
        
        // Check for successful insertion
        if ($stmt->rowCount()) {
            return true;
        }
        
        return false;
    }
    public function getTotal($column) {
        // Gets the summation for a column, will maily be used in the game_scaffold table
        $stmt = $this->DB->prepare("SELECT SUM(" . $column . ") FROM game_scaffold");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function delete($table, $where_field = 'id', $where_value) {
        // Prepary our query for binding
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE {$where_field} = :where_value");
        
        // Execute the query
        $stmt->execute(array('where_value'=>$where_value));
        
        // Check for successful insertion
        if ( $stmt->rowCount() ) {
            return true;
        }
        
        return false;
    }
} // End class DatabaseAdaptor
?>