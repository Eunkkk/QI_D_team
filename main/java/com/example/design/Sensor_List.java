package com.example.design;

import android.widget.Button;

public class Sensor_List {
    private String list_SSN;
    private String listMAC;
    private String sensorname;
    private String timestamp;
    private Button chart_button;
    private Button delete_button;

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

    public Button getChart_button() {
        return chart_button;
    }

    public void setChart_button(Button chart_button) {
        this.chart_button = chart_button;
    }

    public Button getDelete_button() {
        return delete_button;
    }

    public void setDelete_button(Button delete_button) {
        this.delete_button = delete_button;
    }
}
