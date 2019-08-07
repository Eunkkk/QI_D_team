<?php

namespace App\Model;

final class DataModel extends BaseModel
{
    public function select_SSN_from_sensor_info_table($data) {
        $sql = "SELECT SSN FROM Sensor_info where SSN = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array( $data['SSN']));
        $results = $sth->fetchAll();
        return $results;


    }
    public function insert_data_into_airquaility_table($data)
    {
                                       
        $sql = "INSERT INTO Airquality_sensor (
        SSN, air_timestamp, CO,
        SO2, NO2, O3,
        temperature, PM2_5, CO_AQI,
        NO2_AQI ,O3_AQI ,SO2_AQI,
        PM2_5_AQI, lat,lng )
        values
        (?, ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?, ?, ? )";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            $data['SSN'], //1
            $data['air_timestamp'], //2
            $data['CO'], //3
            $data['SO2'], //4
        
            $data['NO2'], //5
            $data['O3'], //6
            $data['temperature'], //7
            $data['PM2_5'], //8
            $data['CO_AQI'], //9
            $data['NO2_AQI'], //10

            $data['O3_AQI'], //11
            $data['SO2_AQI'], //12
            $data['PM2_5_AQI'],  //13

            $data['lat'], //14
            $data['lng'], //15 

        )); ////
        $results = $sth->rowCount();
        return $results;

    }

    public function insert_data_into_heartrate_table($data)
    {                      
        $sql = "INSERT INTO Heart_rate_sensor (
        USN, heart_timestamp, heart_rate,
        RR_interval, lat,lng )
        values
        (?, ?, ?,
        ?, ?,? )";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            $data['USN'], 
            $data['heart_timestamp'], 
            $data['heart_rate'], 
            $data['RR_interval'], 
            $data['lat'], 
            $data['lng'],  
        )); 
        $results = $sth->rowCount();
        return $results;

    }

    public function select_data_from_airquality_table($user)
    {   
        if($user['value']==="All") 
         $sql = "SELECT * FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="CO")  $sql = "SELECT CO,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?" ;
        else if ($user['value']==="CO_AQI")  $sql = "SELECT CO_AQI,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="NO2")  $sql = "SELECT NO2,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="NO2_AQI")  $sql = "SELECT NO2_AQI,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="O3")  $sql = "SELECT O3,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="O3_AQI")  $sql = "SELECT O3_AQI,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="SO2")  $sql = "SELECT SO2,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="SO2_AQI")  $sql = "SELECT SO2_AQI,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="PM2_5")  $sql = "SELECT PM2_5,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else if ($user['value']==="PM2_5_AQI")  $sql = "SELECT PM2_5_AQI,lat,lng,air_timestamp,sensor_name,temperature FROM Sensor_info as S JOIN Airquality_sensor as A on S.SSN = A.SSN where ? > lat AND lat > ? AND ? > lng AND lng > ?";
        else $sql = null;
        
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['north'],$user['south'],$user['east'],$user['west'])); 
        $results = $sth->fetchAll();
        return $results;
    }

    public function select_data_from_heartrate_table($user)
    {     
         $sql = "SELECT heart_rate, heart_timestamp, RR_interval,lat,lng FROM Heart_rate_sensor where USN = ? ";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($user['USN'])); 
        $results = $sth->fetchAll();
        return $results;
    }

}
