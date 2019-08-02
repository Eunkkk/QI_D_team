<?php
namespace App\Model;

final class mapsModel extends BaseModel
{
    public function getFakeSensorByFeedsId($id) {
        $sql = "SELECT p.name, p.pokedex, p.id, p.lat, p.lng, 100 as s1, 150 as s2, 300 as s3, 133 as s4, 83 as s5, 88 as s6 
            from pokemon p 
            inner join feeds f on p.feeds_id = f.id
            where f.id = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($id));
        $results = $sth->fetchAll();
        
        return $results;
    }
    
    public function addUser($user) {
        $sql = "INSERT into customers (fname, lname, email) values (:fname, :lname, :email)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam(':fname', $user['firstname']);
        $sth->bindParam(':lname', $user['lastname']);
        $sth->bindParam(':email', $user['email']);
        $sth->execute();
        $last_id = $this->db->lastInsertId();
        
        return $last_id;
    }

//    public function getUserFromNonce($nonce)
}
