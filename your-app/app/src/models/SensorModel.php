<?php

namespace App\Model;

final class SensorModel extends BaseModel
{
    public function select_sensor_info_from_User_table($user)
    {
        $sql = "SELECT SSN,MAC_address,sensor_name,timestamp from Sensor_info 
        where USN = ? and regActive = ? order by SSN";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN'],1));
        $results = $sth->fetchAll();
        return $results;
    }

    public function update_sensor_info_set_regAtive ($user)
    {
        $sql = "UPDATE Sensor_info SET regActive = ? where SSN = ? AND USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['regActive'],$user['SSN'],$user['USN']));
        $results = $sth->rowCount();
        return $results;
    }

    public function update_sensor_info_set_regAtive_by_USN ($user)
    {
        $sql = "UPDATE Sensor_info SET regActive = ? where USN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['regActive'],$user['USN']));
        $results = $sth->rowCount();
        return $results;
    }

    public function select_sensor_info_by_USN_AND_MAC ($user)
    {
        $sql = "SELECT * FROM Sensor_info where USN = ? AND MAC_address = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN'],$user['MAC_address']));
        $results = $sth->fetchAll();
        return $results;
    }
    public function select_USN_by_MAC ($user)
    {
        $sql = "SELECT USN FROM Sensor_info where MAC_address = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['MAC_address']));
        $results = $sth->fetchAll();
        return $results;
    }
    public function select_SSN_by_MAC ($user)
    {
        // $sql = "SELECT SSN FROM Sensor_info where MAC_address = ?";
       $sql = "SELECT * FROM Sensor_info";
        $sth = $this->db->prepare($sql);
        // $sth->execute(array($user['MAC_address']));
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }
    public function insert_sensor_info_into_sensor_info_table ($user)
    {
        $sql = "INSERT INTO Sensor_info values(NULL,? ,? ,? ,? , ? )";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN'],$user['MAC_address'],
        $user['sensor_name'],$user['timestamp'],$user['regActive']));
        $results = $sth->rowCount();
        return $results;
    }

}
