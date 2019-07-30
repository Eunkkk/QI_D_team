package com.example.design;

import android.app.Activity;
import android.os.Bundle;
import android.widget.Button;

public class MySensorActivity extends Activity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.my_sensor_list);

        Button save_button = (Button)findViewById(R.id.A_signup_button);

        /*
        save_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(
                        getApplicationContext(),
                        SignupActivity.class);
                startActivity(intent);
            }
        });
        */

    }
}
