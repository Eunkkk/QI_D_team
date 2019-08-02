package com.example.design;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class MainActivity extends AppCompatActivity{
    String input_email = "";
    String input_password = "";
    String result = "";

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

        Button sign_up_button = (Button)findViewById(R.id.A_signup_button);
        Button forgot_button = (Button)findViewById(R.id.A_forgot_button);
        final Button sign_in_button = (Button)findViewById(R.id.A_signin_button);

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
                EditText emailEdit = (EditText)findViewById(R.id.A_Email_Edit);
                setInput_email(emailEdit.getText().toString());
                EditText password_Edit = (EditText)findViewById(R.id.A_Pass_Edit);
                setInput_password(password_Edit.getText().toString());

                if (!isValidEmail(getInput_email()))
                    Toast.makeText(MainActivity.this, "Your email is invalid", Toast.LENGTH_SHORT).show();

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
                        result = new PostJSON().execute("http://teamd-iot.calit2.net/app/signin", json.toString()).get();
                    } catch (ExecutionException e) {
                        e.printStackTrace();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }
                Intent intent = new Intent(
                        getApplicationContext(),
                        LoginActivity.class);
                startActivity(intent);
            }
        });

    }

    public static boolean isValidEmail(String email) {
        boolean err = false;
        String regex = "^[_a-z0-9-]+(.[_a-z0-9-]+)*@(?:\\w+\\.)+\\w+$";
        Pattern p = Pattern.compile(regex);
        Matcher m = p.matcher(email);
        if(m.matches()) {
            err = true;
        }
        return err;
    }


}
