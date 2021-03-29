package com.example.design;

import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.widget.EditText;
import android.widget.TextView;

import androidx.fragment.app.FragmentActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.concurrent.ExecutionException;

public class MyPolarActivity extends FragmentActivity{
    // Whether the Log Fragment is currently shown
    private boolean mLogShown;
    private static MyPolarActivity ins;
    String result = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.polar_activity);
        TextView textView1 = (TextView)findViewById(R.id.HR_Min);
        TextView textView2 = (TextView)findViewById(R.id.beats);

        textView1.bringToFront();
        textView2.bringToFront();

        ins = this;

        activatePolar();
    }

    public static MyPolarActivity getInstance(){
        return ins;
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();

        deactivatePolar();
    }

    private final MyPolarBleReceiver mPolarBleUpdateReceiver = new MyPolarBleReceiver() {};

    protected void activatePolar() {
        Log.w(this.getClass().getName(), "activatePolar()");
        registerReceiver(mPolarBleUpdateReceiver, makePolarGattUpdateIntentFilter());
    }

    protected void deactivatePolar() {
        unregisterReceiver(mPolarBleUpdateReceiver);
    }

    private static IntentFilter makePolarGattUpdateIntentFilter() {
        final IntentFilter intentFilter = new IntentFilter();
        intentFilter.addAction(MyPolarBleReceiver.ACTION_GATT_CONNECTED);
        intentFilter.addAction(MyPolarBleReceiver.ACTION_GATT_DISCONNECTED);
        intentFilter.addAction(MyPolarBleReceiver.ACTION_HR_DATA_AVAILABLE);
        return intentFilter;
    }

    public void updateTheTextView(final int hr, final int misc, final int nn, final int pnn, final int rr, final int RRvalue) {
        MyPolarActivity.this.runOnUiThread(new Runnable() {
            public void run() {
                EditText HR_Edit = (EditText) findViewById(R.id.HR_value);
                EditText MISC_Edit = (EditText) findViewById(R.id.HR_MISC_value);
                EditText NN_Edit = findViewById(R.id.NN50_Value);
                EditText pNN_Edit = findViewById(R.id.pNN50_value);
                HR_Edit.setText(String.valueOf(hr));
                MISC_Edit.setText("89");
                if(nn!=0)
                    NN_Edit.setText(String.valueOf(nn));
                if(misc!=0)
                    pNN_Edit.setText(String.valueOf(misc)+ "%");

                SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                String format = simpleDateFormat.format(new Date());
                User_data user_data = (User_data) getApplication();
                JSONObject json = new JSONObject();
                try {
                    json.put("USN", user_data.getUSN());
                    json.put("heart_rate", String.valueOf(hr));
                    json.put("RR_interval", "5");
                    json.put("lat", "0");
                    json.put("lng", "0");
                    json.put("heart_timestamp", format);

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                try {
                    result = new PostJSON().execute("http://localhost:8888/data/heartrate/transfer", json.toString()).get();
                } catch (ExecutionException e) {
                    e.printStackTrace();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                Log.d("asdf", "json: " + json.toString());
                Log.d("asdf", "result: " + result);
            }
        });
    }
}
