package com.example.design;

import android.app.Activity;
import android.os.Bundle;
import android.widget.ListView;

import java.util.ArrayList;

public class SensorListActivity extends Activity {
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.my_sensor_list);

        final ListView sensor_listview = (ListView)findViewById(R.id.sensor_listview);

        final ArrayList<String> list = new ArrayList<String>();

    }
}
