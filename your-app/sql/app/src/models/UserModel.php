<?php

namespace App\Model;

final class UserModel extends BaseModel
{

    public function delete_from_temp_user_table($nonce)
    {
        $sql = "DELETE FROM Temp_user where auth_code = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($nonce));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }

    public function duplicate_check_by_email_from_user_table($user)
    {
        $sql = "SELECT USN from User where e_mail = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['e_mail']));
        $results = $sth->fetchAll();
        return $results;
    }
    public function duplicate_check_by_email_from_temp_user_table($user)
    {
        $sql = "SELECT e_mail from Temp_user where e_mail = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['e_mail']));
        $results = $sth->fetchAll();
        return $results;
    }

    public function select_USN_PW_from_User_table($user)
    {
        $sql = "SELECT USN,hashed_pwd from User where e_mail = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['e_mail']));
        $results = $sth->fetch();
        return $results;
    }


    public function select_user_information_by_nonce_from_temp_table($nonce)
    {
        $sql = "SELECT * from Temp_user where auth_code = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($nonce));
        $results = $sth->fetchAll();
        return $results;
    }

    public function select_USN_by_nonce_from_user_table($nonce)
    {
        $sql = "SELECT USN from User where auth_code = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($nonce));
        $results = $sth->fetchAll();
        return $results;
    }


    public function select_permission_from_user_table($user)
    {
        $sql = "SELECT permission FROM User WHERE USN=?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN']));
        $results = $sth->fetch();
        return $results;
    }
    public function select_hashpw_from_user_table($user)
    {
        $sql = "SELECT hashed_pwd FROM User WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN']));
        $results = $sth->fetch();
        return $results;
    }


    public function insert_user_into_temp_table($user)
    {
        $sql = "INSERT INTO Temp_user values(?,?,?,?,?,?,?)";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            $user['e_mail'],
            $user['first_name'],
            $user['last_name'],
            $user['birth_date'],
            $user['hashed_pwd'],
            $user['auth_code'],
            $user['timestamp'],
        ));
        $results = $sth;
        return $results;
    }

    public function insert_user_into_user_table($user)
    {
        $sql = "INSERT into User values (?,?,?,?,?,?,?,?,?,?,?)";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            0,
            $user['e_mail'],
            $user['first_name'],
            $user['last_name'],
            $user['birth_date'],
            $user['hashed_pwd'],
            $user['auth_code'],
            $user['timestamp'],
            $user['permission'],
            $user['loginStateFlag'],
            $user['isActive'],
        ));
        $last_id = $this->db->lastInsertId();
        return $last_id;
    }

    public function update_user_set_loginStateFlag($user)
    {
        $sql = "UPDATE User SET loginStateFlag = ? WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['loginStateFlag'], $user['USN']));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }

    public function update_user_set_isActive($user)
    {
        $sql = "UPDATE User SET isActive = ? WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['isActive'], $user['USN']));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }

    public function update_user_set_password($user)
    {
        $sql = "UPDATE User SET hashed_pwd = ? WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['new_password'], $user['USN']));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }

    public function update_user_set_auth_code($user)
    {
        $sql = "UPDATE User SET auth_code = ? WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['auth_code'], $user['USN']));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }

    public function update_user_set_password_auth_code($user)
    {
        $sql = "UPDATE User SET hashed_pwd = ? , auth_code = ? WHERE USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['hashed_pwd'], $user['auth_code'], $user['USN']));
        $results = $sth !== false ? 0 : 1;
        return $results;
    }
}
