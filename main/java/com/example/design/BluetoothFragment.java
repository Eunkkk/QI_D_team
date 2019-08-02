
package com.example.design;

import android.app.ActionBar;
import android.app.Activity;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.concurrent.ExecutionException;

/*
 * Copyright (C) 2014 The Android Open Source Project
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * This fragment controls Bluetooth to communicate with other devices.
 */
public class BluetoothFragment extends Fragment {

    private static final String TAG = "BluetoothChatFragment";

    // Intent request codes
    private static final int REQUEST_CONNECT_DEVICE_SECURE = 1;
    private static final int REQUEST_CONNECT_DEVICE_INSECURE = 2;
    private static final int REQUEST_ENABLE_BT = 3;

    /**
     * Name of the connected device
     */
    private String mConnectedDeviceName = null;

    /**
     * String buffer for outgoing messages
     */
    private StringBuffer mOutStringBuffer;

    /**
     * Local Bluetooth adapter
     */
    private BluetoothAdapter mBluetoothAdapter = null;

    /**
     * Member object for the chat services
     */
    private BluetoothService mChatService = null;
    EditText O3_Edit;
    EditText O3AQI_Edit;
    EditText NO2_Edit;
    EditText NO2AQI_Edit;
    EditText CO_Edit;
    EditText COAQI_Edit;
    EditText SO2_Edit;
    EditText SO2AQI_Edit;
    EditText PM_Edit;
    EditText PMAQI_Edit;
    EditText temperature_Edit;
    EditText MAC_Edit;
    Button Save_Button;
    public String result = "";
    String result_code;
    String success_message;
    String error_message;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
        // Get local Bluetooth adapter

        mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();

        // If the adapter is null, then Bluetooth is not supported
        if (mBluetoothAdapter == null) {
            FragmentActivity activity = getActivity();
            Toast.makeText(activity, "Bluetooth is not available", Toast.LENGTH_LONG).show();
            activity.finish();
        }

    }

    public View onCreateView(LayoutInflater inflater, ViewGroup parent,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.content_main, parent, false);
        O3_Edit = (EditText) view.findViewById(R.id.S_O3_value);
        O3AQI_Edit = (EditText) view.findViewById(R.id.S_O3_AQI);
        NO2_Edit = (EditText) view.findViewById(R.id.S_NO_value);
        NO2AQI_Edit = (EditText) view.findViewById(R.id.S_NO_AQI);
        CO_Edit = (EditText) view.findViewById(R.id.S_CO_value);
        COAQI_Edit = (EditText) view.findViewById(R.id.S_CO_AQI);
        SO2_Edit = (EditText) view.findViewById(R.id.S_SO_value);
        SO2AQI_Edit = (EditText) view.findViewById(R.id.S_SO_AQI);
        PM_Edit = (EditText) view.findViewById(R.id.S_PM_value);
        PMAQI_Edit = (EditText) view.findViewById(R.id.S_PM_AQI);
        temperature_Edit = (EditText) view.findViewById(R.id.S_temprature_value);
        MAC_Edit = (EditText)view.findViewById(R.id.S_MAC_address);
        Save_Button = (Button)view.findViewById(R.id.s_save_button);

        Save_Button.setOnClickListener(new View.OnClickListener()
        {
           @Override
           public void onClick(View v){

               SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd-MM-hh-mm-ss");
               String format = simpleDateFormat.format(new Date());
               Log.d("asdf", "Current Timestamp: " + format);

               JSONObject json = new JSONObject();
               try {
                   json.put("SSN", "100");
                   json.put("O3", O3_Edit.getText().toString());
                   json.put("NO2", NO2_Edit.getText().toString());
                   json.put("CO", CO_Edit.getText().toString());
                   json.put("SO2", SO2_Edit.getText().toString());
                   json.put("temperature", temperature_Edit.getText().toString());
                   json.put("PM2_5", PM_Edit.getText().toString());
                   json.put("O3_AQI", O3AQI_Edit.getText().toString());
                   json.put("NO2_AQI", NO2AQI_Edit.getText().toString());
                   json.put("CO_AQI", COAQI_Edit.getText().toString());
                   json.put("SO2_AQI", SO2AQI_Edit.getText().toString());
                   json.put("PM2_5_AQI", PMAQI_Edit.getText().toString());
                   json.put("lat", "0");
                   json.put("lng", "0");
                   json.put("timestamp", format);

               } catch (JSONException e) {
                   e.printStackTrace();
               }
               try {
                   result = new PostJSON().execute("http://teamd-iot.calit2.net/data/transfer", json.toString()).get();
               } catch (ExecutionException e) {
                   e.printStackTrace();
               } catch (InterruptedException e) {
                   e.printStackTrace();
               }
               Log.d("asdf", "json: " + json.toString());
               Log.d("asdf", "result: " + result);

               try {
                   JSONObject json_data = new JSONObject(result);
                   Toast.makeText(getActivity(), result, Toast.LENGTH_SHORT).show();
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
           }
        });

        SharedPreferences settings = this.getActivity().getSharedPreferences("PREFS", 0);

        return view;
    }

    @Override
    public void onStart() {
        super.onStart();
        // If BT is not on, request that it be enabled.
        // setupChat() will then be called during onActivityResult
        if (!mBluetoothAdapter.isEnabled()) {
            Intent enableIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(enableIntent, REQUEST_ENABLE_BT);
            // Otherwise, setup the chat session
        } else if (mChatService == null) {
            setupChat();
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        if (mChatService != null) {
            mChatService.stop();
        }
    }

    @Override
    public void onResume() {
        super.onResume();

        // Performing this check in onResume() covers the case in which BT was
        // not enabled during onStart(), so we were paused to enable it...
        // onResume() will be called when ACTION_REQUEST_ENABLE activity returns.
        if (mChatService != null) {
            // Only if the state is STATE_NONE, do we know that we haven't started already
            if (mChatService.getState() == BluetoothService.STATE_NONE) {
                // Start the Bluetooth chat services
                mChatService.start();
            }
        }
    }

    /**
     * Set up the UI and background operations for chat.
     */
    private void setupChat() {
        // Initialize the BluetoothChatService to perform bluetooth connections
        mChatService = new BluetoothService(getActivity(), mHandler);

        // Initialize the buffer for outgoing messages
        mOutStringBuffer = new StringBuffer("");
    }

    /**
     * Makes this device discoverable for 300 seconds (5 minutes).
     */
    private void ensureDiscoverable() {
        if (mBluetoothAdapter.getScanMode() !=
                BluetoothAdapter.SCAN_MODE_CONNECTABLE_DISCOVERABLE) {
            Intent discoverableIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_DISCOVERABLE);
            discoverableIntent.putExtra(BluetoothAdapter.EXTRA_DISCOVERABLE_DURATION, 300);
            startActivity(discoverableIntent);
        }
    }

    /**
     * Updates the status on the action bar.
     *
     * @param resId a string resource ID
     */
    private void setStatus(int resId) {
        FragmentActivity activity = getActivity();
        if (null == activity) {
            return;
        }
        final ActionBar actionBar = activity.getActionBar();
        if (null == actionBar) {
            return;
        }
        actionBar.setSubtitle(resId);
    }

    /**
     * Updates the status on the action bar.
     *
     * @param subTitle status
     */
    private void setStatus(CharSequence subTitle) {
        FragmentActivity activity = getActivity();
        if (null == activity) {
            return;
        }
        final ActionBar actionBar = activity.getActionBar();
        if (null == actionBar) {
            return;
        }
        actionBar.setSubtitle(subTitle);
    }

    /**
     * The Handler that gets information back from the BluetoothChatService
     */
    private final Handler mHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            FragmentActivity activity = getActivity();
            switch (msg.what) {
                case Constants.MESSAGE_STATE_CHANGE:
                    switch (msg.arg1) {
                        case BluetoothService.STATE_CONNECTED:
                            setStatus(getString(R.string.title_connected_to, mConnectedDeviceName));
                            break;
                        case BluetoothService.STATE_CONNECTING:
                            setStatus(R.string.title_connecting);
                            break;
                        case BluetoothService.STATE_LISTEN:
                        case BluetoothService.STATE_NONE:
                            setStatus(R.string.title_not_connected);
                            break;
                    }
                    break;
                case Constants.MESSAGE_READ:
                    byte[] readBuf = (byte[]) msg.obj;
                    // construct a string from the valid bytes in the buffer
                    String readMessage = new String(readBuf, 0, msg.arg1);
                    if (readMessage!=null) {

                        try {
                            JSONObject json_data = new JSONObject(readMessage);
                            Log.d("asdf", "receive json: " + json_data.toString());
                            temperature_Edit.setText(json_data.optString("temperature"));
                            CO_Edit.setText(json_data.optString("CO"));
                            COAQI_Edit.setText(json_data.optString("CO_AQI"));
                            PM_Edit.setText(json_data.optString("PM2_5"));
                            PMAQI_Edit.setText(json_data.optString("PM2_5_AQI"));
                            NO2_Edit.setText(json_data.optString("NO2"));
                            NO2AQI_Edit.setText(json_data.optString("NO2_AQI"));
                            SO2_Edit.setText(json_data.optString("SO2"));
                            SO2AQI_Edit.setText(json_data.optString("SO2_AQI"));
                            O3_Edit.setText(json_data.optString("O3"));
                            O3AQI_Edit.setText(json_data.optString("O3_AQI"));
                        } catch (Exception e) {
                            Log.e("Fail 3", e.toString());
                        }

                    }

                    //Toast.makeText(activity, readMessage, Toast.LENGTH_SHORT).show();
                    //mConversationArrayAdapter.add(mConnectedDeviceName + ":  " + readMessage);
                    break;
                case Constants.MESSAGE_DEVICE_NAME:
                    // save the connected device's name
                    mConnectedDeviceName = msg.getData().getString(Constants.DEVICE_NAME);
                    if (null != activity) {
                        Toast.makeText(activity, "Connected to "
                                + mConnectedDeviceName, Toast.LENGTH_SHORT).show();
                    }
                    break;
                case Constants.MESSAGE_TOAST:
                    if (null != activity) {
                        Toast.makeText(activity, msg.getData().getString(Constants.TOAST),
                                Toast.LENGTH_SHORT).show();
                    }
                    break;
            }
        }
    };

    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        switch (requestCode) {
            case REQUEST_CONNECT_DEVICE_SECURE:
                // When DeviceListActivity returns with a device to connect
                if (resultCode == Activity.RESULT_OK) {
                    connectDevice(data, true);
                }
                break;
            case REQUEST_CONNECT_DEVICE_INSECURE:
                // When DeviceListActivity returns with a device to connect
                if (resultCode == Activity.RESULT_OK) {
                    connectDevice(data, false);
                }
                break;
            case REQUEST_ENABLE_BT:
                // When the request to enable Bluetooth returns
                if (resultCode == Activity.RESULT_OK) {
                    // Bluetooth is now enabled, so set up a chat session
                    setupChat();
                } else {
                    getActivity().finish();
                }
        }
    }

    /**
     * Establish connection with other device
     *
     * @param data   An {@link Intent} with {@link DeviceListActivity#EXTRA_DEVICE_ADDRESS} extra.
     * @param secure Socket Security type - Secure (true) , Insecure (false)
     */
    private void connectDevice(Intent data, boolean secure) {
        // Get the device MAC address
        String address = data.getExtras()
                .getString(DeviceListActivity.EXTRA_DEVICE_ADDRESS);
        if(DeviceListActivity.EXTRA_DEVICE_ADDRESS != "device_address")
            MAC_Edit.setText(DeviceListActivity.EXTRA_DEVICE_ADDRESS); //////////////////// instance data
        // Get the BluetoothDevice object
        BluetoothDevice device = mBluetoothAdapter.getRemoteDevice(address);
        // Attempt to connect to the device
        mChatService.connect(device, secure);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.bluetooth_button: {
                // Launch the DeviceListActivity to see devices and do scan
                Intent serverIntent = new Intent(getActivity(), DeviceListActivity.class);
                startActivityForResult(serverIntent, REQUEST_CONNECT_DEVICE_SECURE);
                return true;
            }
            case R.id.insecure_connect_scan: {
                // Launch the DeviceListActivity to see devices and do scan
                Intent serverIntent = new Intent(getActivity(), DeviceListActivity.class);
                startActivityForResult(serverIntent, REQUEST_CONNECT_DEVICE_INSECURE);
                return true;
            }
            case R.id.discoverable: {
                // Ensure this device is discoverable by others
                ensureDiscoverable();
                return true;
            }
        }
        return false;
    }

}