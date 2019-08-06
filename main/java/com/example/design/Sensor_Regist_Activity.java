package com.example.design;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.fragment.app.FragmentActivity;

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
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.sensor_regist);

        Button load_button = (Button)findViewById(R.id.Se_device_button);
        Button save_button = (Button)findViewById(R.id.Se_complete_button);
        Button cancel_button = (Button)findViewById(R.id.Se_cancel_button);

        load_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText Mac_Edit = (EditText)findViewById(R.id.Se_Mac_Edit);
                User_data user_data = (User_data)getApplication();
                Mac_Edit.setText(user_data.getMACaddress());
            }
        });
        save_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
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
        });
        cancel_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
    }
}
