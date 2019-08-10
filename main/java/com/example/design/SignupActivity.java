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

import java.util.Calendar;
import java.util.concurrent.ExecutionException;
import java.util.regex.Pattern;

public class SignupActivity extends Activity {
    String input_email = "";
    String input_password = "";
    String input_confirm_password = "";
    String input_First_name = "";
    String input_Last_name = "";
    String input_Birth_Date = "";
    String temp = "";
    String result = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";

    boolean email_Check = false;
    boolean password_Check = false;
    boolean confirm_password_Check = false;
    boolean fname_Check = false;
    boolean lname_Check = false;
    boolean date_Check = false;

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

        final EditText email_Edit = (EditText) findViewById(R.id.U_Email_Edit);
        final EditText pass_Edit = (EditText) findViewById(R.id.U_password_Edit);
        final EditText confirmpass_Edit = (EditText) findViewById(R.id.U_confirmpass_Edit);
        final EditText Fname_Edit = (EditText) findViewById(R.id.U_Fname_Edit);
        final EditText Lname_Edit = (EditText) findViewById(R.id.U_Lname_Edit);
        final EditText Birth_Edit = (EditText) findViewById(R.id.U_Birth_edit);

        email_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = email_Edit.getText().toString();
                if(!isValidEmail(temp)) {
                    email_Edit.setTextColor(Color.RED);
                    email_Check = false;
                    Toast.makeText(SignupActivity.this, "Enter Email Format", Toast.LENGTH_SHORT).show();
                }
                else{
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
                if(!isValidPassword(temp)) {
                    pass_Edit.setTextColor(Color.RED);
                    password_Check = false;
                    Toast.makeText(SignupActivity.this, "Enter the password and it must contain 1 letters, 1 number, 1 special character, between 8-16 long", Toast.LENGTH_SHORT).show();
                }
                else{
                    pass_Edit.setTextColor(Color.BLACK);
                    password_Check = true;
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
                if(!temp.equals(pass_Edit.getText().toString())) {
                    confirmpass_Edit.setTextColor(Color.RED);
                    confirm_password_Check = false;
                    Toast.makeText(SignupActivity.this, "Password doesn't match", Toast.LENGTH_SHORT).show();
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

        Fname_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = Fname_Edit.getText().toString();
                if(!isValidName(temp)) {
                    Fname_Edit.setTextColor(Color.RED);
                    fname_Check = false;
                    Toast.makeText(SignupActivity.this, "Enter your First name", Toast.LENGTH_SHORT).show();
                }
                else{
                    Fname_Edit.setTextColor(Color.BLACK);
                    fname_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        Lname_Edit.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                temp = Lname_Edit.getText().toString();
                if(!isValidName(temp)) {
                    Lname_Edit.setTextColor(Color.RED);
                    lname_Check = false;
                    Toast.makeText(SignupActivity.this, "Enter your First name", Toast.LENGTH_SHORT).show();
                }
                else{
                    Lname_Edit.setTextColor(Color.BLACK);
                    lname_Check = true;
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        Birth_Edit.addTextChangedListener(new TextWatcher(){
            private String current = "";
            private String yyyymmdd = "YYYYMMDD";
            private Calendar cal = Calendar.getInstance();

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                if (!s.toString().equals(current)) {
                    String clean = s.toString().replaceAll("[^\\d.]", "");
                    String cleanC = current.replaceAll("[^\\d.]", "");

                    int cl = clean.length();
                    int sel = cl;
                    for (int i = 2; i <= cl && i < 6; i += 2) {
                        sel++;
                    }
                    //Fix for pressing delete next to a forward slash
                    if (clean.equals(cleanC)) sel--;

                    if (clean.length() < 8){
                        clean = clean + yyyymmdd.substring(clean.length());
                    }else{
                        //This part makes sure that when we finish entering numbers
                        //the date is correct, fixing it otherwise
                        int year = Integer.parseInt(clean.substring(0,4));
                        int mon  = Integer.parseInt(clean.substring(4,6));
                        int day  = Integer.parseInt(clean.substring(6,8));

                        if(mon > 12) mon = 12;
                        cal.set(Calendar.MONTH, mon-1);
                        year = (year<1900)?1900:(year>2100)?2100:year;
                        cal.set(Calendar.YEAR, year);
                        // ^ first set year for the line below to work correctly
                        //with leap years - otherwise, date e.g. 29/02/2012
                        //would be automatically corrected to 28/02/2012

                        day = (day > cal.getActualMaximum(Calendar.DATE))? cal.getActualMaximum(Calendar.DATE):day;
                        clean = String.format("%02d%02d%02d",year, mon, day);
                    }

                    clean = String.format("%s-%s-%s", clean.substring(0, 4),
                            clean.substring(4, 6),
                            clean.substring(6, 8));

                    sel = sel < 0 ? 0 : sel;
                    current = clean;
                    Birth_Edit.setText(current);
                    Birth_Edit.setSelection(sel < current.length() ? sel : current.length());
                }
                temp = Birth_Edit.getText().toString();
                if(!isValidDate(temp)) {
                    Birth_Edit.setTextColor(Color.RED);
                    date_Check = false;
                    Toast.makeText(SignupActivity.this, "Enter correct date", Toast.LENGTH_SHORT).show();
                }
                else{
                    Birth_Edit.setTextColor(Color.BLACK);
                    date_Check = true;
                }
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}

            @Override
            public void afterTextChanged(Editable s) {}
        });


        complete_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(email_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check email text.", Toast.LENGTH_SHORT).show();
                else if (password_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check password text.", Toast.LENGTH_SHORT).show();
                else if (confirm_password_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check confirm_password text.", Toast.LENGTH_SHORT).show();
                else if (fname_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check First name text.", Toast.LENGTH_SHORT).show();
                else if (lname_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check Last name text.", Toast.LENGTH_SHORT).show();
                else if (date_Check == false)
                    Toast.makeText(SignupActivity.this, "Please check date text.", Toast.LENGTH_SHORT).show();
                else{
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
                        json.put("first_name", getInput_First_name());
                        json.put("last_name", getInput_Last_name());
                        json.put("birth_date", getInput_Birth_Date());

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    try {
                        result = new PostJSON().execute("http://teamd-iot.calit2.net/app/signup", json.toString()).get();
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
                        Toast.makeText(SignupActivity.this, success_message, Toast.LENGTH_SHORT).show();
                    }
                    else if(result_code.equals("1")){
                        Toast.makeText(SignupActivity.this, error_message, Toast.LENGTH_SHORT).show();
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

    public static boolean isValidPassword(CharSequence target) {
        Pattern pass_pattern = Pattern.compile("^(?=.*[A-Za-z])(?=.*\\d)(?=.*[$@$!%*#?&])[A-Za-z\\d$@$!%*#?&]{8,16}$");
        return (!TextUtils.isEmpty(target) && pass_pattern.matcher(target).matches());
    }

    public static boolean isValidName(CharSequence target) {
        Pattern pass_pattern = Pattern.compile("^[A-Za-z]*$");
        return (!TextUtils.isEmpty(target) && pass_pattern.matcher(target).matches());
    }

    public static boolean isValidDate(CharSequence target) {
        Pattern pass_pattern = Pattern.compile("^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$");
        return (!TextUtils.isEmpty(target) && pass_pattern.matcher(target).matches());
    }
}
