package com.example.design;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ForgotActivity extends Activity {
    private static final String TAG = "asdf";
    String input_email = "";
    String input_new_password = "";
    String input_confirm_password = "";
    String result = "";

    public String getInput_email() {
        return input_email;
    }

    public void setInput_email(String input_email) {
        this.input_email = input_email;
    }

    public String getInput_new_password() {
        return input_new_password;
    }

    public void setInput_new_password(String input_new_password) {
        this.input_new_password = input_new_password;
    }

    public String getInput_confirm_password() {
        return input_confirm_password;
    }

    public void setInput_confirm_password(String input_confirm_password) {
        this.input_confirm_password = input_confirm_password;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.forgot_password_update);


        Button complete_button = (Button) findViewById(R.id.F_complete_button);
        Button cancel_button = (Button) findViewById(R.id.F_cancel_button);
        Button check_button = (Button) findViewById(R.id.F_check_button);

        check_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText email_Edit = (EditText) findViewById(R.id.F_Email_Edit);
                setInput_email(email_Edit.getText().toString());

                JSONObject json = new JSONObject();
                try {
                    json.put("e_mail", getInput_email());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                Log.d("asdf", json.toString());
                if (getInput_email().length() > 0) {
                    try {
                        result = new PostJSON().execute("http://teamd-iot.calit2.net/test", json.toString()).get();
                    } catch (ExecutionException e) {
                        e.printStackTrace();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }
                Toast.makeText(ForgotActivity.this, result, Toast.LENGTH_SHORT).show();

            }
        });

        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText new_passwordEdit = (EditText) findViewById(R.id.F_newpass_Edit);
                setInput_new_password(new_passwordEdit.getText().toString());

                EditText confirm_passwordEdit = (EditText) findViewById(R.id.F_confirmpass_Edit);
                setInput_confirm_password(confirm_passwordEdit.getText().toString());

                //password_update(); // Password Update request
            }
        });

        cancel_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
    }

    public static boolean isValidEmail(String email) {
        boolean err = false;
        String regex = "^[_a-z0-9-]+(.[_a-z0-9-]+)*@(?:\\w+\\.)+\\w+$";
        Pattern p = Pattern.compile(regex);
        Matcher m = p.matcher(email);
        if (m.matches()) {
            err = true;
        }
        return err;
    }

    private void setUseableEditText(EditText et, boolean useable) { // 버튼 활성화, 비활성화
        et.setClickable(useable);
        et.setEnabled(useable);
        et.setFocusable(useable);
        et.setFocusableInTouchMode(useable);

        if (useable == false)
            et.setBackgroundColor(Color.GRAY);
        else if (useable == true)
            et.setBackgroundColor(Color.WHITE);
    }
}