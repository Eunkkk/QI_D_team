package com.example.design;

import android.graphics.Color;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.fragment.app.FragmentActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.regex.Pattern;

public class Password_ChangeActivity extends FragmentActivity {
    String Input_password = "";
    String Input_new_password = "";
    String Input_confirm_password = "";
    String temp;
    String result;
    String result_code;
    String success_message;
    String error_message;
    boolean current_password_check;
    boolean new_password_Check;
    boolean confirm_password_Check;

    public String getInput_password() {
        return Input_password;
    }

    public void setInput_password(String input_password) {
        Input_password = input_password;
    }

    public String getInput_new_password() {
        return Input_new_password;
    }

    public void setInput_new_password(String input_new_password) {
        Input_new_password = input_new_password;
    }

    public String getInput_confirm_password() {
        return Input_confirm_password;
    }

    public void setInput_confirm_password(String input_confirm_password) {
        Input_confirm_password = input_confirm_password;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.user_password_change);

        Button complete_button = (Button)findViewById(R.id.C_complete_button);
        Button cancel_button = (Button)findViewById(R.id.C_cancel_button);

        final EditText current_pass_Edit = (EditText) findViewById(R.id.C_currentpass_Edit);
        final EditText new_pass_Edit = (EditText) findViewById(R.id.C_newpass_Edit);
        final EditText confirmpass_Edit = (EditText) findViewById(R.id.C_confirmpass_Edit);

        current_pass_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = current_pass_Edit.getText().toString();
                if(!isValidPassword(temp)) {
                    current_pass_Edit.setTextColor(Color.RED);
                    current_password_check = false;
                    Toast.makeText(Password_ChangeActivity.this, " Must contain 1 letters, 1 number, 1 special character, between 8-16 long", Toast.LENGTH_SHORT).show();
                }
                else{
                    current_pass_Edit.setTextColor(Color.BLACK);
                    current_password_check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        new_pass_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = new_pass_Edit.getText().toString();
                if(!isValidPassword(temp)) {
                    new_pass_Edit.setTextColor(Color.RED);
                    new_password_Check = false;
                    Toast.makeText(Password_ChangeActivity.this, " Must contain 1 letters, 1 number, 1 special character, between 8-16 long", Toast.LENGTH_SHORT).show();
                }
                else{
                    new_pass_Edit.setTextColor(Color.BLACK);
                    new_password_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        confirmpass_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = confirmpass_Edit.getText().toString();
                if(!temp.equals(new_pass_Edit.getText().toString())) {
                    confirmpass_Edit.setTextColor(Color.RED);
                    confirm_password_Check = false;
                    Toast.makeText(Password_ChangeActivity.this, "Password doesn't match", Toast.LENGTH_SHORT).show();
                }
                else{
                    confirmpass_Edit.setTextColor(Color.BLACK);
                    confirm_password_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(current_password_check == false)
                    Toast.makeText(Password_ChangeActivity.this, "Please check current password text.", Toast.LENGTH_SHORT).show();
                else if(new_password_Check == false)
                    Toast.makeText(Password_ChangeActivity.this, "Please check new password text.", Toast.LENGTH_SHORT).show();
                else if (confirm_password_Check)
                    Toast.makeText(Password_ChangeActivity.this, "Please check new confirm password text.", Toast.LENGTH_SHORT).show();
                else{
                    EditText pass_Edit = (EditText) findViewById(R.id.C_currentpass_Edit);
                    setInput_password(pass_Edit.getText().toString());
                    EditText new_pass_Edit = (EditText) findViewById(R.id.C_newpass_Edit);
                    setInput_new_password(new_pass_Edit.getText().toString());
                    EditText confirm_pass_Edit = (EditText) findViewById(R.id.C_confirmpass_Edit);
                    setInput_confirm_password(confirm_pass_Edit.getText().toString());

                    JSONObject json = new JSONObject();
                    User_data user_data = (User_data) getApplication();
                    try {
                        json.put("USN", user_data.getUSN());
                        json.put("password", getInput_password());
                        json.put("new_password", getInput_new_password());
                        json.put("confirm_new_password", getInput_confirm_password());

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    try {
                        result = new PostJSON().execute("http://teamd-iot.calit2.net/app/pwchange", json.toString()).get();
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
                        Toast.makeText(Password_ChangeActivity.this, success_message, Toast.LENGTH_SHORT).show();
                    }
                    else if(result_code.equals("1")){
                        Toast.makeText(Password_ChangeActivity.this, error_message, Toast.LENGTH_SHORT).show();
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

    public static boolean isValidPassword(CharSequence target) {
        Pattern pass_pattern = Pattern.compile("^(?=.*[A-Za-z])(?=.*\\d)(?=.*[$@$!%*#?&])[A-Za-z\\d$@$!%*#?&]{8,16}$");
        return (!TextUtils.isEmpty(target) && pass_pattern.matcher(target).matches());
    }
}