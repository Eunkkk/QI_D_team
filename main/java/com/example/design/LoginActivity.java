package com.example.design;

import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.FragmentTransaction;

import com.google.android.material.navigation.NavigationView;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;

public class LoginActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener{

    private static final String TAG = "asdf";
    String result = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.menu_layout);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        NavigationView navigationView = findViewById(R.id.nav_view);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();
        navigationView.setNavigationItemSelectedListener(this);
        navigationView.bringToFront();

        if (savedInstanceState == null) {
            FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
            BluetoothFragment fragment = new BluetoothFragment();
            transaction.replace(R.id.sample_content_fragment, fragment);
            transaction.commit();
        }

        activatePolar();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        JSONObject json = new JSONObject();
        User_data user_data = (User_data) getApplication();
        try {
            json.put("USN", user_data.getUSN());
        } catch (JSONException e) {
            e.printStackTrace();
        }
        Log.d("asdf", "json: " + json.toString());
        try {
            result = new PostJSON().execute("http://teamd-iot.calit2.net/app/signout", json.toString()).get();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
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
            Log.d("asdf", "User_data: USN: " + user_data.getUSN());
            Toast.makeText(LoginActivity.this, success_message, Toast.LENGTH_SHORT).show();
            try {
                TimeUnit.SECONDS.sleep(1);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            finish();
        }
        else if(result_code.equals("1")){
            Toast.makeText(LoginActivity.this, error_message, Toast.LENGTH_SHORT).show();
        }
    }


    @Override
    public void onBackPressed() {
    DrawerLayout drawer = findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds sitems to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        item.setChecked(true);

        if(id == R.id.myMap) {
            Intent intent = new Intent(
                    getApplicationContext(),
                    MyMapActivity.class);
            startActivity(intent);
            return true;
        }
        else if(id == R.id.mySensorList) {
            Intent intent = new Intent(
                    getApplicationContext(),
                    SensorListActivity.class);
            startActivity(intent);
                return true;
        }
        else if(id == R.id.sensor_register) {
            Intent intent = new Intent(
                    getApplicationContext(),
                    Sensor_Regist_Activity.class);
            startActivity(intent);
            return true;
        }
        else if(id == R.id.logout) {
            JSONObject json = new JSONObject();
            User_data user_data = (User_data) getApplication();
            try {
                json.put("USN", user_data.getUSN());
            } catch (JSONException e) {
                e.printStackTrace();
            }
            Log.d("asdf", "json: " + json.toString());
            try {
                result = new PostJSON().execute("http://teamd-iot.calit2.net/app/signout", json.toString()).get();
            } catch (ExecutionException e) {
                e.printStackTrace();
            } catch (InterruptedException e) {
                e.printStackTrace();
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
                Log.d("asdf", "User_data: USN: " + user_data.getUSN());
                Toast.makeText(LoginActivity.this, success_message, Toast.LENGTH_SHORT).show();
                try {
                    TimeUnit.SECONDS.sleep(1);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                finish();
            }
            else if(result_code.equals("1")){
                Toast.makeText(LoginActivity.this, error_message, Toast.LENGTH_SHORT).show();
            }
                return true;
        }
        else if(id == R.id.Password_change) {
            // Ensure this device is discoverable by others
            Intent intent = new Intent(
                    getApplicationContext(),
                    Password_ChangeActivity.class);
            startActivity(intent);
            return true;
        }
        else if(id == R.id.ID_cancellation) {
            // Ensure this device is discoverable by others
            Intent intent = new Intent(
                    getApplicationContext(),
                    ID_CancellationActivity.class);
            startActivity(intent);
            return true;
        }
        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
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
}
