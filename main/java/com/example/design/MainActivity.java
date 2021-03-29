package com.example.design;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.google.android.gms.maps.model.LatLng;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.regex.Pattern;

public class MainActivity extends AppCompatActivity {
    String input_email = "";
    String input_password = "";
    String result = "";
    String temp = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";
    String get_USN = "";

    boolean email_Check = false;
    boolean password_Check = false;

    private static final int REQUEST_CODE_LOCATION = 2;

    private LocationManager locationManager;

    public String getInput_email() {
        return input_email;
    }

    public void setInput_email(String input_email) {
        this.input_email = input_email;
    }

    public String getInput_password() {
        return input_password;
    }

    public void setInput_password(String input_password) {
        this.input_password = input_password;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        final EditText email_Edit = (EditText) findViewById(R.id.A_Email_Edit);
        final EditText pass_Edit = (EditText) findViewById(R.id.A_Pass_Edit);
        Button sign_up_button = (Button) findViewById(R.id.A_signup_button);
        Button forgot_button = (Button) findViewById(R.id.A_forgot_button);
        final Button sign_in_button = (Button) findViewById(R.id.A_signin_button);

        locationManager = (LocationManager)getSystemService(Context.LOCATION_SERVICE);

        Location userLocation = getMyLocation();
        User_data user_data = (User_data)getApplicationContext();
        if( userLocation != null ) {
            double latitude = userLocation.getLatitude();
            double longitude = userLocation.getLongitude();
            LatLng latlng = new LatLng(latitude, longitude);
            user_data.setLat(String.valueOf(latlng.latitude));
            user_data.setLng(String.valueOf(latlng.longitude));

            Log.d("asdf", user_data.getLat() + " / " + user_data.getLng());
        }
        Log.d("asdf", user_data.getLat() + " / " + user_data.getLng());

        email_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = email_Edit.getText().toString();
                if (!isValidEmail(temp)) {
                    email_Edit.setTextColor(Color.RED);
                    email_Check = false;
                    Toast.makeText(MainActivity.this, "Enter Email Format", Toast.LENGTH_SHORT).show();
                } else {
                    email_Edit.setTextColor(Color.BLACK);
                    email_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        pass_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = pass_Edit.getText().toString();
                if (!isValidPassword(temp)) {
                    pass_Edit.setTextColor(Color.RED);
                    password_Check = false;
                    Toast.makeText(MainActivity.this, "Enter the password and it must contain 1 letters, 1 number, 1 special character, between 8-16 long", Toast.LENGTH_SHORT).show();
                } else {
                    pass_Edit.setTextColor(Color.BLACK);
                    password_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        sign_up_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(
                        getApplicationContext(),
                        SignupActivity.class);
                startActivity(intent);
            }
        });

        forgot_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(
                        getApplicationContext(),
                        ForgotActivity.class);
                startActivity(intent);
            }
        });

        sign_in_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if(email_Check == false)
                    Toast.makeText(MainActivity.this, "Please check email text.", Toast.LENGTH_SHORT).show();
                else if (password_Check == false)
                    Toast.makeText(MainActivity.this, "Please check Password text.", Toast.LENGTH_SHORT).show();
                else{
                    EditText emailEdit = (EditText)findViewById(R.id.A_Email_Edit);
                    setInput_email(emailEdit.getText().toString());
                    EditText password_Edit = (EditText)findViewById(R.id.A_Pass_Edit);
                    setInput_password(password_Edit.getText().toString());

                    JSONObject json = new JSONObject();
                    try {
                        json.put("e_mail", getInput_email());
                        json.put("password",getInput_password());
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    Log.d("asdf", "json: " + json.toString());
                    if (getInput_email().length() > 0) {
                        try {
                            result = new PostJSON().execute("http://localhost:8888/app/signin", json.toString()).get();
                        } catch (ExecutionException e) {
                            e.printStackTrace();
                        } catch (InterruptedException e) {
                            e.printStackTrace();
                        }
                    }
                    try {
                        JSONObject json_data = new JSONObject(result);
                        Log.d("asdf", "receive json: " + json_data.toString());
                        result_code = (json_data.optString("result_code"));
                        success_message = (json_data.optString("success_message"));
                        error_message = (json_data.optString("error_message"));
                        get_USN = (json_data.optString("USN"));

                        Log.d("asdf", "result_code: " + result_code);
                        Log.d("asdf", "success_message: " + success_message);
                        Log.d("asdf", "error_message: " + error_message);
                        Log.d("asdf", "USN: " + get_USN);

                    } catch (Exception e) {
                        Log.e("Fail 3", e.toString());
                    }

                    if(result_code.equals("0")){
                        Log.d("asdf", "USN: " + get_USN);
                        User_data user_data = (User_data) getApplication();
                        user_data.setUSN(get_USN);
                        Log.d("asdf", "User_data: USN: " + user_data.getUSN());
                        Toast.makeText(MainActivity.this, success_message, Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(
                                getApplicationContext(),
                                LoginActivity.class);
                        startActivity(intent);
                    }
                    else if(result_code.equals("1")){
                        Toast.makeText(MainActivity.this, error_message, Toast.LENGTH_SHORT).show();
                    }
                }
            }
        });
    }

    public static boolean isValidEmail(CharSequence target) {
        return (!TextUtils.isEmpty(target) && Patterns.EMAIL_ADDRESS.matcher(target).matches());
    }

    public static boolean isValidPassword(CharSequence target) {
        Pattern pass_pattern = Pattern.compile("^(?=.*[A-Za-z])(?=.*\\d)(?=.*[$@$!%*#?&])[A-Za-z\\d$@$!%*#?&]{8,16}$");
        return (!TextUtils.isEmpty(target) && pass_pattern.matcher(target).matches());
    }

    private Location getMyLocation() {
        Location currentLocation = null;
        // Register the listener with the Location Manager to receive location updates
        if (ActivityCompat.checkSelfPermission(getApplicationContext(), Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getApplication(), Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            getMyLocation();
        }
        else {
            String locationProvider = LocationManager.GPS_PROVIDER;
            currentLocation = locationManager.getLastKnownLocation(locationProvider);
            if (currentLocation != null) {
                double lng = currentLocation.getLongitude();
                double lat = currentLocation.getLatitude();
            }
        }
        return currentLocation;
    }
}
