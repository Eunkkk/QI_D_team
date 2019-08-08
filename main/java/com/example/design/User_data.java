package com.example.design;

import android.app.Application;

public class User_data extends Application {
    private String USN = "";
    private String MACaddress = "";
    private String lat = "";
    private String lng = "";

    private static User_data mInstance;

    public void onCreate(){
        super.onCreate();
        mInstance = this;
    }

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

    public static User_data getInstance() { return mInstance; }

    public String getLat() {
        return lat;
    }

    public void setLat(String lat) {
        this.lat = lat;
    }

    public String getLng() {
        return lng;
    }

    public void setLng(String lng) {
        this.lng = lng;
    }
}