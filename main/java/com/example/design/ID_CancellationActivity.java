package com.example.design;

import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import androidx.fragment.app.FragmentActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.regex.Pattern;

public class ID_CancellationActivity extends FragmentActivity {
    String Input_password = "";
    String Input_confirm_password = "";

    public String getInput_password() {
        return Input_password;
    }

    public void setInput_password(String input_password) {
        Input_password = input_password;
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
        setContentView(R.layout.id_cancellation_layout);

        Button complete_button = (Button)findViewById(R.id.W_complete_button);
        Button cancel_button = (Button)findViewById(R.id.W_cancel_button);

        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText pass_Edit = (EditText) findViewById(R.id.W_pass_Edit);
                setInput_password(pass_Edit.getText().toString());
                EditText confirmpass_Edit = (EditText) findViewById(R.id.W_confirmpass_Edit);
                setInput_confirm_password(confirmpass_Edit.getText().toString());

                JSONObject json = new JSONObject();
                try {
                    json.put("USN", "100");
                    json.put("password", getInput_password());
                    json.put("confirm_password", getInput_confirm_password());

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                try {
                    new PostJSON().execute("http://teamd-iot.calit2.net/app/idcancellation", json.toString()).get();
                } catch (ExecutionException e) {
                    e.printStackTrace();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                Log.d("asdf", "json: " + json.toString());
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
