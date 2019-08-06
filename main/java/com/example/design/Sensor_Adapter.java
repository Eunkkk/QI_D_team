package com.example.design;

import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.concurrent.ExecutionException;

public class Sensor_Adapter extends BaseAdapter {

    ArrayList<Sensor_List> Sensor_Item = new ArrayList<>();
    String result = "";
    String result_code = "";
    String error_message = "";
    String success_message = "";

    @Override
    public int getCount() {
        return Sensor_Item.size();
    }

    @Override
    public Sensor_List getItem(int position) {
        return Sensor_Item.get(position);
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        Context context = parent.getContext();

        if(convertView == null){
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = inflater.inflate(R.layout.sensor_item, parent, false);
        }

        final TextView list_SSN = (TextView)convertView.findViewById(R.id.list_SSN);
        TextView list_MAC = (TextView)convertView.findViewById(R.id.list_MAC);
        TextView list_sensorname = (TextView)convertView.findViewById(R.id.list_Sensorname);
        TextView list_timestamp = (TextView)convertView.findViewById(R.id.list_timestamp);

        Sensor_List sensor_list = getItem(position);

        list_SSN.setText(sensor_list.getList_SSN());
        list_MAC.setText(sensor_list.getListMAC());
        list_sensorname.setText(sensor_list.getSensorname());
        list_timestamp.setText(sensor_list.getTimestamp());

        Button delete_button = (Button)convertView.findViewById(R.id.list_deregist);
        delete_button.setOnClickListener(new Button.OnClickListener(){

            @Override
            public void onClick(View view) {
                JSONObject json = new JSONObject();
                User_data user_data = User_data.getInstance();
                try {
                    json.put("USN", user_data.getUSN());
                    json.put("SSN", list_SSN.getText().toString());

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                try {
                    result = new PostJSON().execute("http://teamd-iot.calit2.net/sensor/app/deregistration/request", json.toString()).get();
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
            }
        });

        return convertView;
    }

    public void addItem(String SSN, String MAC, String sensorname, String timestamp){
        Sensor_List sensor_list = new Sensor_List();

        sensor_list.setList_SSN(SSN);
        sensor_list.setListMAC(MAC);
        sensor_list.setSensorname(sensorname);
        sensor_list.setTimestamp(timestamp);

        Sensor_Item.add(sensor_list);
    }

}
