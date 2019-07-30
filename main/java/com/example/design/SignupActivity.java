package com.example.design;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;

public class SignupActivity extends Activity {
    String input_email;
    String input_password;
    String input_confirm_password;
    String input_First_name;
    String input_Last_name;
    String input_Birth_Date;

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

    public String getInput_confirm_password() {
        return input_confirm_password;
    }

    public void setInput_confirm_password(String input_confirm_password) {
        this.input_confirm_password = input_confirm_password;
    }

    public String getInput_First_name() {
        return input_First_name;
    }

    public void setInput_First_name(String input_First_name) {
        this.input_First_name = input_First_name;
    }

    public String getInput_Last_name() {
        return input_Last_name;
    }

    public void setInput_Last_name(String input_Last_name) {
        this.input_Last_name = input_Last_name;
    }

    public String getInput_Birth_Date() {
        return input_Birth_Date;
    }

    public void setInput_Birth_Date(String input_Birth_Date) {
        this.input_Birth_Date = input_Birth_Date;
    }

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.sign_up_layout);

        Button complete_button = (Button)findViewById(R.id.U_complete_button);
        Button cancel_button = (Button)findViewById(R.id.U_cancel_button);

        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText email_Edit = (EditText) findViewById(R.id.U_Email_Edit);
                setInput_email(email_Edit.getText().toString());
                EditText pass_Edit = (EditText) findViewById(R.id.U_password_Edit);
                setInput_password(pass_Edit.getText().toString());
                EditText confirmpass_Edit = (EditText) findViewById(R.id.U_confirmpass_Edit);
                setInput_confirm_password(confirmpass_Edit.getText().toString());
                EditText Fname_Edit = (EditText) findViewById(R.id.U_Fname_Edit);
                setInput_First_name(Fname_Edit.getText().toString());
                EditText Lname_Edit = (EditText) findViewById(R.id.U_Lname_Edit);
                setInput_Last_name(Lname_Edit.getText().toString());
                EditText Birth_Edit = (EditText) findViewById(R.id.U_Birth_edit);
                setInput_Birth_Date(Birth_Edit.getText().toString());

                JSONObject json = new JSONObject();
                try {
                    json.put("e_mail", getInput_email());
                    json.put("password", getInput_password());
                    json.put("confirm_password", getInput_confirm_password());
                    json.put("First_name", getInput_First_name());
                    json.put("Last_name", getInput_Last_name());
                    json.put("Birth_Date", getInput_Birth_Date());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                if (getInput_email().length() > 0) {
                    try {
                        new PostJSON().execute("http://teamd-iot.calit2.net/test", json.toString()).get();
                    } catch (ExecutionException e) {
                        e.printStackTrace();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }
                Log.d("asdf", json.toString());
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
