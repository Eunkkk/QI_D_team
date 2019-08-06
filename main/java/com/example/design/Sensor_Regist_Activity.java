package com.example.design;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import androidx.fragment.app.FragmentActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.concurrent.ExecutionException;

public class Sensor_Regist_Activity extends FragmentActivity {
    String result_code = "";
    String success_message = "";
    String error_message = "";
    String result = "";

    EditText Mac_Edit;
    ListView listView;
    @Override
    protected void onCreate (Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.sensor_regist);

        Button load_button = (Button)findViewById(R.id.Se_device_button);
        Button save_button = (Button)findViewById(R.id.Se_complete_button);
        Button cancel_button = (Button)findViewById(R.id.Se_cancel_button);
        Button list_button = (Button)findViewById(R.id.Se_Load_button);

        listView = (ListView)findViewById(R.id.Se_sensor_list);

        dataSetting();

        load_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText Mac_Edit = (EditText)findViewById(R.id.Se_Mac_Edit);
                User_data user_data = (User_data)getApplication();
                Mac_Edit.setText(user_data.getMACaddress());
            }
        });

        list_button.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                JSONObject json = new JSONObject();
                User_data user_data = (User_data) getApplication();
                try {
                    json.put("USN", user_data.getUSN());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                try {
                    result = new PostJSON().execute("http://teamd-iot.calit2.net/sensor/app/userlistview/request", json.toString()).get();
                    Log.d("asdf", "here result: " + result);
                } catch (ExecutionException e) {
                    e.printStackTrace();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                try {
                    JSONArray json_array = new JSONArray(result);
                    Sensor_Adapter sensor_adapter = new Sensor_Adapter();
                    for (int i = 0 ; i< json_array.length(); i++){
                        JSONObject json_data = json_array.getJSONObject(i);
                        Log.d("asdf", "receive json: " + json_data.toString());
                        String ssn = json_data.optString("SSN");
                        String mac_address = json_data.optString("MAC_address");
                        String sensor_name = json_data.optString("sensor_name");
                        String timestamp = json_data.optString("timestamp");
                        sensor_adapter.addItem(ssn, mac_address, sensor_name, timestamp);
                    }
                    listView.setAdapter(sensor_adapter);

                } catch (Exception e) {
                    Log.e("Fail 3", e.toString());
                }
                try {
                    JSONObject json_data = new JSONObject(result);
                    Log.d("asdf", "receive json: " + json_data.toString());
                    result_code = (json_data.optString("result_code"));
                    success_message = (json_data.optString("success_message"));
                    error_message = (json_data.optString("error_message"));
                    Log.d("asdf", "result_code: " + result_code);
                    Log.d("asdf", "success_message: " + success_message);
                    Log.d("asdf", "error_message: " + error_message);
                } catch (Exception e) {
                    Log.e("Fail 3", e.toString());
                }
                if(result_code.equals("0")){
                    Toast.makeText(Sensor_Regist_Activity.this, success_message, Toast.LENGTH_SHORT).show();
                }
                else if(result_code.equals("1")){
                    Toast.makeText(Sensor_Regist_Activity.this, error_message, Toast.LENGTH_SHORT).show();
                }
            }
        });
        save_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(!Mac_Edit.getText().equals("")){
                    JSONObject json = new JSONObject();
                    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd-MM-hh-mm-ss");
                    String format = simpleDateFormat.format(new Date());
                    User_data user_data = (User_data) getApplication();
                    try {
                        json.put("USN", user_data.getUSN());
                        json.put("MAC_address", user_data.getMACaddress());
                        json.put("timestamp", format);

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    try {
                        result = new PostJSON().execute("http://teamd-iot.calit2.net/sensor/registration", json.toString()).get();
                    } catch (ExecutionException e) {
                        e.printStackTrace();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    Log.d("asdf", "json: " + json.toString());

                    try {
                        JSONObject json_data = new JSONObject(result);
                        Log.d("asdf", "receive json: " + json_data.toString());
                        result_code = (json_data.optString("result_code"));
                        success_message = (json_data.optString("success_message"));
                        error_message = (json_data.optString("error_message"));
                        Log.d("asdf", "result_code: " + result_code);
                        Log.d("asdf", "success_message: " + success_message);
                        Log.d("asdf", "error_message: " + error_message);
                    } catch (Exception e) {
                        Log.e("Fail 3", e.toString());
                    }
                    if(result_code.equals("0")){
                        Toast.makeText(Sensor_Regist_Activity.this, success_message, Toast.LENGTH_SHORT).show();
                    }
                    else if(result_code.equals("1")){
                        Toast.makeText(Sensor_Regist_Activity.this, error_message, Toast.LENGTH_SHORT).show();
                    }
                }
            }
        });
        cancel_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
    }

    private void dataSetting(){

    }
}
