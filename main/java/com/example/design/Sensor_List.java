package com.example.design;

import android.widget.Button;

public class Sensor_List {
    private String list_SSN;
    private String listMAC;
    private String sensorname;
    private String timestamp;
    private Button deregist;

    public String getList_SSN() {
        return list_SSN;
    }

    public void setList_SSN(String list_SSN) {
        this.list_SSN = list_SSN;
    }

    public String getListMAC() {
        return listMAC;
    }

    public void setListMAC(String listMAC) {
        this.listMAC = listMAC;
    }

    public String getSensorname() {
        return sensorname;
    }

    public void setSensorname(String sensorname) {
        this.sensorname = sensorname;
    }

    public String getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(String timestamp) {
        this.timestamp = timestamp;
    }

    public Button getDeregist() {
        return deregist;
    }

    public void setDeregist(Button deregist) {
        this.deregist = deregist;
    }
}
