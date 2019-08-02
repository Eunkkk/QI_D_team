<?php
namespace App\Model;

final class DataModel extends BaseModel
{
    public function insert_data_into_airquaility_table($data)
    {
        $sql = "INSERT INTO Airquality_sensor values(?,?,?,?,?,?,?)";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            'SSN' => $data['SSN'],
            'timestamp' => $data['timestampl'],
            'temperature' => $data['temperature'],
            'PM2.5' => $data['PM2.5'],
            'CO' => $data['CO'],
            'NO2' => $data['NO2'],
            'O3' => $data['O3'],
            'SO2' => $data['SO2'],
            'PM2.5_AQI' => $data['PM2.5_AQI'],
            'CO_AQI' => $data['CO_AQI'],
            'NO2_AQI' => $data['NO2_AQI'],
            'O3_AQI' => $data['O3_AQI'],
            'SO2_AQI' => $data['SO2_AQI'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ));
        $last_id = $this->db->lastInsertId();
        return $last_id;
    }

}
