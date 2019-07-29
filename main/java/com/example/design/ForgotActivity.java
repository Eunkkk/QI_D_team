package com.example.design;

import android.app.Activity;
import android.content.ContentValues;
import android.content.pm.ApplicationInfo;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.security.NetworkSecurityPolicy;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.DataOutput;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.Writer;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.concurrent.ExecutionException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.xml.transform.Result;

public class ForgotActivity extends Activity {
    private static final String TAG = "asdf";
    String input_email = "";
    String input_new_password = "";
    String input_confirm_password = "";
    String urlStr = "";
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

    public ForgotActivity() throws MalformedURLException {
        urlStr = "http://teamd-iot.calit2.net/test";
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.forgot_password_update);

        Button check_button = (Button) findViewById(R.id.F_check_button);
        Button complete_button = (Button) findViewById(R.id.F_complete_button);
        Button cancel_button = (Button) findViewById(R.id.F_cancel_button);

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
                        new PostJSON().execute(urlStr, json.toString()).get();
                        //Log.d("asdf", result);
                    } catch (ExecutionException e) {
                        e.printStackTrace();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }


                //setUseableEditText(emailEdit, false);

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

    public class PostJSON extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            String ResultStr = "";
            String pageContents = "";
            StringBuilder contents = new StringBuilder();

            HttpURLConnection httpURLConnection = null;
            try {
                URL url = new URL("http://teamd-iot.calit2.net/test");
                httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setRequestProperty("Content-Type", "application/json");
                httpURLConnection.setRequestProperty("Accept", "application/json");

                try{
                    Log.d("asdf", "out start");
                    OutputStreamWriter osw = new OutputStreamWriter(httpURLConnection.getOutputStream());
                    osw.write(params[1]);
                    osw.flush();
                    osw.close();
                    Log.d("asdf", "out end");
                } catch (Exception e){
                    Log.d("asdf",e.toString());
                    e.printStackTrace();
                }

                try {
                    Log.d("asdf", "In Start");
                    BufferedReader br = null;
                    br = new BufferedReader(new InputStreamReader(httpURLConnection.getInputStream(), "UTF-8"));

                    while((pageContents = br.readLine())!=null){
                        //System.out.println(pageContents);
                        contents.append(pageContents);
                        contents.append("\r\n");
                    }

                    ResultStr = contents.toString();
                    Log.d("asdf", "In End");

                }catch(Exception e){
                    Log.d("asdf",e.toString());
                    e.printStackTrace();
                }

                Log.d("asdf", ResultStr);

            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                if (httpURLConnection != null) {
                    httpURLConnection.disconnect();
                }
            }

            return ResultStr;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            Log.d("asdf", result); // this is expecting a response code to be sent from your server upon receiving the POST data
        }

    }
}
