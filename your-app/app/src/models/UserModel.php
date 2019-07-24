<?php
namespace App\Model;

final class UserModel extends BaseModel
{
    public function duplicate_check_by_email($user) {
        $sql = "SELECT * from User where e_mail = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['e_mail']));
        // $results = $sth->fetchAll()
        $results = $sth->fetchAll();
        return $results;

    }

    public function insert_user_into_temp_table($user) {
        $sql = "INSERT INTO Temp_table values(?,?,?,?,?,?,?,?,?)";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(0,
        $user['e_mail'],
        $user['first_name'],
        $user['last_name'],
        $user['birth_date'],
        $user['hashed_pwd'],
        $user['timestamp'],
        $user['permission'],
        $user['loginStateFlag'],
        ));
        $results = $sth;
        return $results;
    }

    public function select_USN_PW_from_User_table($user) {
      $sql = "SELECT USN,hashed_pwd from User where e_mail = ?";
      $sth = $this->db->prepare($sql);
      $sth->execute(array($user['e_mail']));
      $results = $sth->fetchAll();
      return $results;
    }

    // public function insert_user_into_temp_table($user) {
    //     $sql = "INSERT INTO Temp_user values(?,?,?,?,?,?,?)";
    //     $sth = $this->db->prepare($sql);
    //     $sth->execute(array(
    //       $user['e_mail'],
    //       $user['first_name'],
    //       $user['last_name'],
    //       $user['birth_date'],
    //       $user['hashed_pwd'],
    //       $user['auth_code'],
    //       $user['timestamp']
    //     ));
    //     $results = $sth->fetch();
    //     return $results;
    // }

    public function addUser($user) {
        // $sql = "INSERT into customers (fname, lname, email) values (?, ?, ?)";
        // $sth = $this->db->prepare($sql);
        // $sth->execute(array($user['fname'], $user['lname'], $user['email']));
        // $last_id = $this->db->lastInsertId();
        //
        // return $last_id;
    }
}
