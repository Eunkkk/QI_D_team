package com.example.design;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.widget.Button;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        Button sign_up_button = (Button)findViewById(R.id.A_signup_button);
        Button forgot_button = (Button)findViewById(R.id.A_forgot_button);
        Button sign_in_button = (Button)findViewById(R.id.A_signin_button);

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
                Intent intent = new Intent(
                        getApplicationContext(),
                        LoginActivity.class);
                startActivity(intent);
            }
        });
    }
}
