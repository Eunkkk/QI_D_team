package com.example.design;

import android.app.Activity;
import android.graphics.Color;
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

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;

public class ForgotActivity extends Activity {
    private static final String TAG = "asdf";
    String input_email = "";
    String result = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";
    String temp = "";

    EditText email_Edit;
    boolean email_format = false;

    public String getInput_email() {
        return input_email;
    }

    public void setInput_email(String input_email) {
        this.input_email = input_email;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.forgot_password_update);

        Button complete_button = (Button) findViewById(R.id.F_complete_button);
        Button cancel_button = (Button) findViewById(R.id.F_cancel_button);
        Button check_button = (Button) findViewById(R.id.F_check_button);

        email_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = email_Edit.getText().toString();
                if(!isValidEmail(temp)) {
                    email_Edit.setTextColor(Color.RED);
                    email_format = false;
                    Toast.makeText(ForgotActivity.this, "Enter Email Format", Toast.LENGTH_SHORT).show();
                }
                else{
                    email_Edit.setTextColor(Color.BLACK);
                    email_format = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        check_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(email_format == false)
                    Toast.makeText(ForgotActivity.this, "Please check email text.", Toast.LENGTH_SHORT).show();
                else{
                    EditText email_Edit = (EditText) findViewById(R.id.F_Email_Edit);
                    setInput_email(email_Edit.getText().toString());
                    if (!isValidEmail(getInput_email()))
                        Toast.makeText(ForgotActivity.this, "Your email is invalid", Toast.LENGTH_SHORT).show();

                    JSONObject json = new JSONObject();
                    try {
                        json.put("e_mail", getInput_email());
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    Log.d("asdf", "json: " + json.toString());
                    if (getInput_email().length() > 0) {
                        try {
                            result = new PostJSON().execute("http://teamd-iot.calit2.net/app/fpwchange", json.toString()).get();
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
                        Log.d("asdf", "result_code: " + result_code);
                        Log.d("asdf", "success_message: " + success_message);
                        Log.d("asdf", "error_message: " + error_message);
                    } catch (Exception e) {
                        Log.e("Fail 3", e.toString());
                    }

                    if(result_code.equals("0")){
                        Toast.makeText(ForgotActivity.this, success_message, Toast.LENGTH_SHORT).show();
                        try {
                            TimeUnit.SECONDS.sleep(1);
                        } catch (InterruptedException e) {
                            e.printStackTrace();
                        }
                        finish();
                    }
                    else if(result_code.equals("1")){
                        Toast.makeText(ForgotActivity.this, error_message, Toast.LENGTH_SHORT).show();
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

    public static boolean isValidEmail(CharSequence target) {
        return (!TextUtils.isEmpty(target) && Patterns.EMAIL_ADDRESS.matcher(target).matches());
    }
}