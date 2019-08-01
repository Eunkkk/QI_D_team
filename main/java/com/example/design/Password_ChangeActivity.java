package com.example.design;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import androidx.fragment.app.FragmentActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.concurrent.ExecutionException;

public class Password_ChangeActivity extends FragmentActivity {
    String Input_password = "";
    String Input_new_password = "";
    String Input_confirm_password = "";

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

        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText pass_Edit = (EditText) findViewById(R.id.C_currentpass_Edit);
                setInput_password(pass_Edit.getText().toString());
                EditText new_pass_Edit = (EditText) findViewById(R.id.C_newpass_Edit);
                setInput_new_password(new_pass_Edit.getText().toString());
                EditText confirm_pass_Edit = (EditText) findViewById(R.id.C_confirmpass_Edit);
                setInput_confirm_password(confirm_pass_Edit.getText().toString());

                JSONObject json = new JSONObject();
                try {
                    json.put("USN", "100");
                    json.put("password", getInput_password());
                    json.put("new_password", getInput_new_password());
                    json.put("confirm_password", getInput_confirm_password());

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                try {
                    new PostJSON().execute("http://teamd-iot.calit2.net/app/pwchange", json.toString()).get();
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
}
