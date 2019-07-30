package com.example.design;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import androidx.appcompat.app.AppCompatActivity;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class MainActivity extends AppCompatActivity{
    String input_email = "";
    String input_password = "";

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

                //sign_in_request();

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

    public static void sign_in_request (){ //Sign_in request
        URL url = null;
        try {
            url = new URL("http://teamd-iot.calit2.net/");
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setDoOutput(true);
            conn.setRequestMethod("POST");
            conn.setRequestProperty("Accept-Language", "ko-kr,ko;q=0.8,en-us;q=0.5,en;q=0.3");
            String param = "{\"email_address\": \"asdasd\", \"body\" : \"ddddddddd\"}";

            OutputStreamWriter osw = new OutputStreamWriter(
                    conn.getOutputStream());

            osw.write(param);
            osw.flush();

            BufferedReader br = null;
            br = new BufferedReader(new InputStreamReader(conn.getInputStream(),"UTF-8"));

            String line = null;
            while((line = br.readLine()) != null){ // 여기에
                System.out.println(line);
            }

            osw.close();
            br.close();

        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
