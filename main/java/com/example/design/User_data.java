package com.example.design;

import android.app.Application;

public class User_data extends Application {
    private String USN = "";
    private String MACaddress = "";

    public String getUSN() {
        return USN;
    }

    public void setUSN(String USN) {
        this.USN = USN;
    }

    public String getMACaddress() {
        return MACaddress;
    }

    public void setMACaddress(String MACaddress) {
        this.MACaddress = MACaddress;
    }
}