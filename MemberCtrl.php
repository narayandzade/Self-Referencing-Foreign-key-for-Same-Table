<?php 
require_once 'Database.php';
require_once 'MemberModel.php';

class MemberCtrl {
  
    public function insertMember($name,$datetime, $parentid) {

        
        $db = new Database();
        $connected = $db->Connection();
        $query = "INSERT INTO members (name, createddate, parentid) VALUES (:name, :datetime, :parentid)";
        $stmt = $connected->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':datetime', $datetime);
        $stmt->bindParam(':parentid', $parentid);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}









































?>