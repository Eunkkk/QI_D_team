package com.example.design;

import android.content.DialogInterface;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Location;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.places.GeoDataClient;
import com.google.android.gms.location.places.PlaceDetectionClient;
import com.google.android.gms.location.places.PlaceLikelihood;
import com.google.android.gms.location.places.PlaceLikelihoodBufferResponse;
import com.google.android.gms.location.places.Places;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Locale;
import java.util.concurrent.ExecutionException;

public class MyMapActivity extends AppCompatActivity implements OnMapReadyCallback, GoogleMap.OnMapLongClickListener{

    private static MyMapActivity ins;
    private AppCompatActivity mActivity;
    boolean askPermissionOnceAgain = false;
    boolean mRequestingLocationUpdates = false;
    Location mCurrentLocatiion;
    LatLng currentPosition;
    private GoogleMap mMap;

    private static final String TAG = MyMapActivity.class.getSimpleName();
    private CameraPosition mCameraPosition;

    // The entry points to the Places API.
    private GeoDataClient mGeoDataClient;
    private PlaceDetectionClient mPlaceDetectionClient;

    // The entry point to the Fused Location Provider.
    private FusedLocationProviderClient mFusedLocationProviderClient;

    // A default location (Sydney, Australia) and default zoom to use when location permission is
    // not granted.
    private final LatLng mDefaultLocation = new LatLng(-33.8523341, 151.2106085);
    private static final int DEFAULT_ZOOM = 18;
    private static final int PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION = 1;
    private boolean mLocationPermissionGranted;

    // The geographical location where the device is currently located. That is, the last-known
    // location retrieved by the Fused Location Provider.
    private Location mLastKnownLocation;

    // Keys for storing activity state.
    private static final String KEY_CAMERA_POSITION = "camera_position";
    private static final String KEY_LOCATION = "location";

    // Used for selecting the current place.
    private static final int M_MAX_ENTRIES = 5;
    private String[] mLikelyPlaceNames;
    private String[] mLikelyPlaceAddresses;
    private String[] mLikelyPlaceAttributions;
    private LatLng[] mLikelyPlaceLatLngs;

    TextView heart_Text;
    TextView lat_Text;
    TextView lng_Text;

    LatLng upper_left;
    LatLng bottom_left;
    LatLng upper_right;
    LatLng bottom_right;
    LatLng destination;

    boolean all_check = true;
    boolean CO_check = false;
    boolean NO2_check = false;
    boolean O3_check = false;
    boolean SO2_check = false;
    boolean PM_check = false;
    boolean CO_AQI_check = false;
    boolean NO_AQI_check = false;
    boolean O3_AQI_check = false;
    boolean SO2_AQI_check = false;
    boolean PM_AQI_check = false;

    String result = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";
    String sensor_name = "";
    String CO = "";
    String NO2 = "";
    String O3 = "";
    String SO2 = "";
    String PM = "";
    String CO_AQI = "";
    String NO2_AQI = "";
    String O3_AQI = "";
    String SO2_AQI = "";
    String PM_AQI = "";
    String temperature = "";
    String total_AQI_name = "";
    String total_AQI_value = "";
    String timestamp = "";
    String air_timestamp = "";
    String lat = "";
    String lng = "";

    private final MyPolarBleReceiver mPolarBleUpdateReceiver = new MyPolarBleReceiver() {};

    protected void activatePolar() {
        Log.w(this.getClass().getName(), "activatePolar()");
        registerReceiver(mPolarBleUpdateReceiver, makePolarGattUpdateIntentFilter());
    }

    private static IntentFilter makePolarGattUpdateIntentFilter() {
        final IntentFilter intentFilter = new IntentFilter();
        intentFilter.addAction(MyPolarBleReceiver.ACTION_GATT_CONNECTED);
        intentFilter.addAction(MyPolarBleReceiver.ACTION_GATT_DISCONNECTED);
        intentFilter.addAction(MyPolarBleReceiver.ACTION_HR_DATA_AVAILABLE);
        return intentFilter;
    }

    public static MyMapActivity getInstance(){
        return ins;
    }

    public void updateTheTextView(final int heart) {
        MyMapActivity.this.runOnUiThread(new Runnable() {
            public void run() {
                EditText map_heart = (EditText) findViewById(R.id.map_heart_view);
                map_heart.setText(String.valueOf(heart));
            }
        });
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Locale.setDefault(new Locale("en"));
        setContentView(R.layout.my_map);

        heart_Text = (TextView)findViewById(R.id.map_heart_view);
        lat_Text = (TextView)findViewById(R.id.map_lat);
        lng_Text = (TextView)findViewById(R.id.map_lng);

        Button all = (Button)findViewById(R.id.map_all_button);
        Button CO = (Button)findViewById(R.id.map_co_button);
        Button NO2 = (Button)findViewById(R.id.map_no_button);
        Button O3 = (Button)findViewById(R.id.map_o3_button);
        Button SO2 = (Button)findViewById(R.id.map_so_button);
        Button PM = (Button)findViewById(R.id.map_pm_button);
        Button CO_AQI = (Button)findViewById(R.id.map_coaqi_button);
        Button NO_AQI = (Button)findViewById(R.id.map_noaqi_button);
        Button O3_AQI = (Button)findViewById(R.id.map_o3aqi_button);
        Button SO2_AQI = (Button)findViewById(R.id.map_soaqi_button);
        Button PM_AQI = (Button)findViewById(R.id.map_pmaqi_button);

        all.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by All", Toast.LENGTH_SHORT).show();
                button_false();
                all_check = true;
            }
        });

        CO.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by CO", Toast.LENGTH_SHORT).show();
                button_false();
                CO_check = true;
            }
        });

        NO2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by NO2", Toast.LENGTH_SHORT).show();
                button_false();
                NO2_check = true;
            }
        });

        O3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by O3", Toast.LENGTH_SHORT).show();
                button_false();
                O3_check = true;
            }
        });

        SO2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by SO2", Toast.LENGTH_SHORT).show();
                button_false();
                SO2_check = true;
            }
        });

        PM.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by PM2.5", Toast.LENGTH_SHORT).show();
                button_false();
                PM_check = true;
            }
        });

        CO_AQI.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by CO_AQI", Toast.LENGTH_SHORT).show();
                button_false();
                CO_AQI_check = true;
            }
        });

        NO_AQI.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by NO_AQI", Toast.LENGTH_SHORT).show();
                button_false();
                NO_AQI_check = true;
            }
        });

        O3_AQI.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by O3_AQI", Toast.LENGTH_SHORT).show();
                button_false();
                O3_AQI_check = true;
            }
        });

        SO2_AQI.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by SO2_AQI", Toast.LENGTH_SHORT).show();
                button_false();
                SO2_AQI_check = true;
            }
        });

        PM_AQI.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mMap.clear();
                Toast.makeText(MyMapActivity.this, "filter by PM2.5_AQI", Toast.LENGTH_SHORT).show();
                button_false();
                PM_AQI_check = true;
            }
        });

        ins = this;
        // Retrieve location and camera position from saved instance state.
        if (savedInstanceState != null) {
            mLastKnownLocation = savedInstanceState.getParcelable(KEY_LOCATION);
            mCameraPosition = savedInstanceState.getParcelable(KEY_CAMERA_POSITION);
        }

        // Construct a GeoDataClient.
        mGeoDataClient = Places.getGeoDataClient(this, null);

        // Construct a PlaceDetectionClient.
        mPlaceDetectionClient = Places.getPlaceDetectionClient(this, null);

        // Construct a FusedLocationProviderClient.
        mFusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);

        // Build the map.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        activatePolar();

    }

    /**
     * Saves the state of the map when the activity is paused.
     */
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        if (mMap != null) {
            outState.putParcelable(KEY_CAMERA_POSITION, mMap.getCameraPosition());
            outState.putParcelable(KEY_LOCATION, mLastKnownLocation);
            super.onSaveInstanceState(outState);
        }
    }

    /**
     * Sets up the options menu.
     * @param menu The options menu.
     * @return Boolean.
     */
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.current_place_menu, menu);
        return true;
    }

    /**
     * Handles a click on the menu option to get a place.
     * @param item The menu item to handle.
     * @return Boolean.
     */
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == R.id.option_get_place) {
            showCurrentPlace();
        }
        return true;
    }

    @Override
    public void onMapReady(GoogleMap map) {
        mMap = map;
        mMap.setOnMapLongClickListener(this);
        // Use a custom info window adapter to handle multiple lines of text in the
        // info window contents.
        mMap.setInfoWindowAdapter(new GoogleMap.InfoWindowAdapter() {

            @Override
            // Return null here, so that getInfoContents() is called next.
            public View getInfoWindow(Marker arg0) {
                return null;
            }

            @Override
            public View getInfoContents(Marker marker) {
                // Inflate the layouts for the info window, title and snippet.
                View infoWindow = getLayoutInflater().inflate(R.layout.custom_info_contents,
                        (FrameLayout) findViewById(R.id.map), false);

                TextView title = ((TextView) infoWindow.findViewById(R.id.title));
                title.setText(marker.getTitle());

                TextView snippet = ((TextView) infoWindow.findViewById(R.id.snippet));
                snippet.setText(marker.getSnippet());

                return infoWindow;
            }
        });

        // Prompt the user for permission.
        getLocationPermission();

        // Turn on the My Location layer and the related control on the map.
        updateLocationUI();

        // Get the current location of the device and set the position of the map.
        getDeviceLocation();

        mMap.setOnCameraMoveStartedListener(new GoogleMap.OnCameraMoveStartedListener() {
            @Override
            public void onCameraMoveStarted(int i) {
                LatLngBounds bounds = mMap.getProjection().getVisibleRegion().latLngBounds;
                upper_right = bounds.northeast;
                upper_left = new LatLng(bounds.northeast.latitude, bounds.southwest.longitude);
                bottom_left = bounds.southwest;
                bottom_right = new LatLng(bounds.southwest.latitude, bounds.northeast.longitude);

                realtimeJSON(upper_left.latitude, bottom_right.latitude, upper_left.longitude, bottom_right.longitude);
                Log.d("asdf", upper_left.latitude + " / " + bottom_right.latitude + " / " + upper_left.longitude+ " / " + bottom_right.longitude);
            }
        });
    }

    public void getDeviceLocation() {
        /*
         * Get the best and most recent location of the device, which may be null in rare
         * cases when a location is not available.
         */
        final User_data user_data = (User_data) getApplication();
        try {
            if (mLocationPermissionGranted) {
                Task<Location> locationResult = mFusedLocationProviderClient.getLastLocation();
                locationResult.addOnCompleteListener(this, new OnCompleteListener<Location>() {
                    @Override
                    public void onComplete(@NonNull Task<Location> task) {
                        if (task.isSuccessful()) {
                            // Set the map's camera position to the current location of the device.
                            mLastKnownLocation = task.getResult();
                            mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(
                                    new LatLng(mLastKnownLocation.getLatitude(),
                                            mLastKnownLocation.getLongitude()), DEFAULT_ZOOM));
                            user_data.setLat(String.valueOf(mLastKnownLocation.getLatitude()));
                            user_data.setLng(String.valueOf(mLastKnownLocation.getLongitude()));

                            lat_Text.setText("Lat: " + user_data.getLat());
                            lng_Text.setText("lng: " + user_data.getLng());

                            Log.d("asdf", user_data.getLat() + " / " + user_data.getLng());

                            LatLngBounds bounds = mMap.getProjection().getVisibleRegion().latLngBounds;
                            upper_right = bounds.northeast;
                            Log.d("asdf", "northeast: " +String.valueOf(bounds.northeast));
                            upper_left = new LatLng(bounds.northeast.latitude, bounds.southwest.longitude);
                            bottom_left = bounds.southwest;
                            bottom_right = new LatLng(bounds.southwest.latitude, bounds.northeast.longitude);

                            //realtimeJSON(upper_left.latitude, bottom_right.latitude, upper_left.longitude, bottom_right.longitude);

                            Log.d("asdf", upper_right + " / " + upper_left + " / " + bottom_left + " / " + bottom_right);

                        } else {
                            Log.d(TAG, "Current location is null. Using defaults.");
                            Log.e(TAG, "Exception: %s", task.getException());
                            mMap.moveCamera(CameraUpdateFactory
                                    .newLatLngZoom(mDefaultLocation, DEFAULT_ZOOM));
                            mMap.getUiSettings().setMyLocationButtonEnabled(false);
                        }
                    }
                });
            }
        } catch (SecurityException e)  {
            Log.e("Exception: %s", e.getMessage());
        }
    }

    /**
     * Prompts the user for permission to use the device location.
     */
    private void getLocationPermission() {
        /*
         * Request location permission, so that we can get the location of the
         * device. The result of the permission request is handled by a callback,
         * onRequestPermissionsResult.
         */
        if (ContextCompat.checkSelfPermission(this.getApplicationContext(),
                android.Manifest.permission.ACCESS_FINE_LOCATION)
                == PackageManager.PERMISSION_GRANTED) {
            mLocationPermissionGranted = true;
        } else {
            ActivityCompat.requestPermissions(this,
                    new String[]{android.Manifest.permission.ACCESS_FINE_LOCATION},
                    PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION);
        }
    }

    /**
     * Handles the result of the request for location permissions.
     */
    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           @NonNull String permissions[],
                                           @NonNull int[] grantResults) {
        mLocationPermissionGranted = false;
        switch (requestCode) {
            case PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    mLocationPermissionGranted = true;
                }
            }
        }
        updateLocationUI();
    }

    /**
     * Prompts the user to select the current place from a list of likely places, and shows the
     * current place on the map - provided the user has granted location permission.
     */
    private void showCurrentPlace() {
        if (mMap == null) {
            return;
        }

        if (mLocationPermissionGranted) {
            // Get the likely places - that is, the businesses and other points of interest that
            // are the best match for the device's current location.
            @SuppressWarnings("MissingPermission") final
            Task<PlaceLikelihoodBufferResponse> placeResult =
                    mPlaceDetectionClient.getCurrentPlace(null);
            placeResult.addOnCompleteListener
                    (new OnCompleteListener<PlaceLikelihoodBufferResponse>() {
                        @Override
                        public void onComplete(@NonNull Task<PlaceLikelihoodBufferResponse> task) {
                            if (task.isSuccessful() && task.getResult() != null) {
                                PlaceLikelihoodBufferResponse likelyPlaces = task.getResult();

                                // Set the count, handling cases where less than 5 entries are returned.
                                int count;
                                if (likelyPlaces.getCount() < M_MAX_ENTRIES) {
                                    count = likelyPlaces.getCount();
                                } else {
                                    count = M_MAX_ENTRIES;
                                }

                                int i = 0;
                                mLikelyPlaceNames = new String[count];
                                mLikelyPlaceAddresses = new String[count];
                                mLikelyPlaceAttributions = new String[count];
                                mLikelyPlaceLatLngs = new LatLng[count];

                                for (PlaceLikelihood placeLikelihood : likelyPlaces) {
                                    // Build a list of likely places to show the user.
                                    mLikelyPlaceNames[i] = (String) placeLikelihood.getPlace().getName();
                                    mLikelyPlaceAddresses[i] = (String) placeLikelihood.getPlace()
                                            .getAddress();
                                    mLikelyPlaceAttributions[i] = (String) placeLikelihood.getPlace()
                                            .getAttributions();
                                    mLikelyPlaceLatLngs[i] = placeLikelihood.getPlace().getLatLng();

                                    i++;
                                    if (i > (count - 1)) {
                                        break;
                                    }
                                }

                                // Release the place likelihood buffer, to avoid memory leaks.
                                likelyPlaces.release();

                                // Show a dialog offering the user the list of likely places, and add a
                                // marker at the selected place.
                                openPlacesDialog();

                            } else {
                                Log.e(TAG, "Exception: %s", task.getException());
                            }
                        }
                    });
        } else {
            // The user has not granted permission.
            Log.i(TAG, "The user did not grant location permission.");

            // Add a default marker, because the user hasn't selected a place.
            mMap.addMarker(new MarkerOptions()
                    .title(getString(R.string.default_info_title))
                    .position(mDefaultLocation)
                    .snippet(getString(R.string.default_info_snippet)));

            // Prompt the user for permission.
            getLocationPermission();
        }
    }

    /**
     * Displays a form allowing the user to select a place from a list of likely places.
     */
    private void openPlacesDialog() {
        // Ask the user to choose the place where they are now.
        DialogInterface.OnClickListener listener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                // The "which" argument contains the position of the selected item.
                LatLng markerLatLng = mLikelyPlaceLatLngs[which];
                String markerSnippet = mLikelyPlaceAddresses[which];
                if (mLikelyPlaceAttributions[which] != null) {
                    markerSnippet = markerSnippet + "\n" + mLikelyPlaceAttributions[which];
                }

                // Add a marker for the selected place, with an info window
                // showing information about that place.
                mMap.addMarker(new MarkerOptions()
                        .title(mLikelyPlaceNames[which])
                        .position(markerLatLng)
                        .snippet(markerSnippet));

                // Position the map's camera at the location of the marker.
                mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(markerLatLng,
                        DEFAULT_ZOOM));
            }
        };

        // Display the dialog.
        AlertDialog dialog = new AlertDialog.Builder(this)
                .setTitle(R.string.pick_place)
                .setItems(mLikelyPlaceNames, listener)
                .show();
    }

    /**
     * Updates the map's UI settings based on whether the user has granted location permission.
     */
    private void updateLocationUI() {
        if (mMap == null) {
            return;
        }
        try {
            if (mLocationPermissionGranted) {
                mMap.setMyLocationEnabled(true);
                mMap.getUiSettings().setMyLocationButtonEnabled(true);
            } else {
                mMap.setMyLocationEnabled(false);
                mMap.getUiSettings().setMyLocationButtonEnabled(false);
                mLastKnownLocation = null;
                getLocationPermission();
            }
        } catch (SecurityException e)  {
            Log.e("Exception: %s", e.getMessage());
        }
    }

    @Override
    public void onMapLongClick(LatLng latLng) {
        mMap.clear();
        destination = latLng;
        mMap.addMarker(new MarkerOptions().position(latLng));

    }

    public void realtimeJSON(double north, double south, double west, double east){

        JSONObject json = new JSONObject();
        try {
            json.put("north", north);
            json.put("west", west);
            json.put("south", south);
            json.put("east", east);
            json.put("value", button_true());
        } catch (JSONException e) {
            e.printStackTrace();
        }
        Log.d("asdf", "json: " + json.toString());
        try {
            result = new PostJSON().execute("http://teamd-iot.calit2.net/app/data/get/real/airquality", json.toString()).get();
            Log.d("asdf", "IN:" + result);
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
        try {
            JSONObject jsonObject = new JSONObject(result);
            Log.d("asdf", "real time receive json: " + jsonObject.toString());
            result_code = (jsonObject.optString("result_code"));
            success_message = (jsonObject.optString("success_message"));
            error_message = (jsonObject.optString("error_message"));
            sensor_name = jsonObject.optString("sensor_name");
            Log.d("asdf", "result_code: " + result_code);
            Log.d("asdf", "success_message: " + success_message);
            Log.d("asdf", "error_message: " + error_message);

            if (result_code.equals("0")) {
                Toast.makeText(MyMapActivity.this, success_message, Toast.LENGTH_SHORT).show();
            } else if (result_code.equals("1")) {
                Toast.makeText(MyMapActivity.this, error_message, Toast.LENGTH_SHORT).show();
            }
            Log.d("asdf", "result_code: " + result_code);
            Log.d("asdf", "success_message: " + success_message);
            Log.d("asdf", "error_message: " + error_message);
            init_sensor();
        } catch (Exception e) {
            Log.e("Fail 3", e.toString());
        }
        try {
            JSONArray jsonArray = new JSONArray(result);
            Log.d("asdf", String.valueOf(jsonArray));
            String fix = button_true();
            //String temp_total = "";
            for (int i = 0 ; i< jsonArray.length(); i++){
                JSONObject json_data = jsonArray.getJSONObject(i);
                sensor_name = json_data.optString("sensor_name");
                CO = json_data.optString("CO");
                NO2 = json_data.optString("NO2");
                O3 = json_data.optString("O3");
                SO2 = json_data.optString("SO2");
                PM = json_data.optString("PM2_5");
                CO_AQI = json_data.optString("CO_AQI");
                NO2_AQI = json_data.optString("NO2_AQI");
                O3_AQI = json_data.optString("O3_AQI");
                SO2_AQI = json_data.optString("SO2_AQI");
                PM_AQI = json_data.optString("PM2_5_AQI");
                temperature = json_data.optString("temperature");
                total_AQI_name = json_data.optString("total_AQI_name");
                total_AQI_value = json_data.optString("total_AQI_value");
                timestamp = json_data.optString("timestamp");
                air_timestamp = json_data.optString("air_timestamp");
                lat = json_data.optString("lat");
                lng = json_data.optString("lng");

                MarkerOptions markerOptions = new MarkerOptions();
                //markerOptions.icon(getMarkerIcon("#000000"));
                markerOptions.position(new LatLng(Double.valueOf(lat), Double.valueOf(lng)));
                if(fix.equals("All"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nCO: " + CO + "\nNO2: " + NO2 + "\nO3: " + O3 + "\nSO2: " + SO2 + "\nPM2.5: " + PM +
                        "\nCO_AQI: " + CO_AQI + "\nNO2_AQI: " + NO2_AQI + "\nO3_AQI: " + O3_AQI + "\nSO2_AQI: " + SO2_AQI + "\nPM2.5_AQI: " + PM_AQI +
                        "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntotal_AQI_name(" + total_AQI_name + ": " + total_AQI_value + ")"
                    + "\ntimestamp: " + timestamp);
                else if(fix.equals("CO"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nCO: " + CO + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("NO2"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nNO2: " + NO2 + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("SO2"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nSO2: " + SO2 + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("PM2_5"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nPM2.5: " + PM + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("CO_AQI"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nCO_AQI: " + CO_AQI + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("NO2_AQI"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nNO2_AQI: " + NO2_AQI + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("O3_AQI"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nO3_AQI: " + O3_AQI + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("SO2_AQI"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nSO2_AQI: " + SO2_AQI + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);
                else if(fix.equals("PM2_5_AQI"))
                    markerOptions.snippet("sensor name:" + sensor_name + "\nPM2.5_AQI: " + PM_AQI + "\ntemperature: " + temperature + "\nLocation: " + lat + " ," + lng + "\ntimestamp: " + air_timestamp);

                mMap.addMarker(markerOptions);
                init_sensor();
            }
        } catch (Exception e) {
            Log.e("Fail 3", e.toString());
        }
    }

    public void button_false(){
        all_check = false;
        CO_check = false;
        NO2_check = false;
        O3_check = false;
        SO2_check = false;
        PM_check = false;
        CO_AQI_check = false;
        NO_AQI_check = false;
        O3_AQI_check = false;
        SO2_AQI_check = false;
        PM_AQI_check = false;
    }

    public String button_true(){
        if(all_check == true)
            return "All";
        else if(CO_check == true)
            return "CO";
        else if(NO2_check == true)
            return "NO2";
        else if(O3_check == true)
            return "O3";
        else if(SO2_check == true)
            return "SO2";
        else if(PM_check == true)
            return "PM2_5";
        else if(CO_AQI_check == true)
            return "CO_AQI";
        else if(NO_AQI_check == true)
            return "NO2_AQI";
        else if(O3_AQI_check == true)
            return "O3_AQI";
        else if(SO2_AQI_check == true)
            return "SO2_AQI";
        else if(PM_AQI_check == true)
            return "PM2_5_AQI";

        return "";
    }

    // method definition
    public BitmapDescriptor getMarkerIcon(String color) {
        float[] hsv = new float[3];
        Color.colorToHSV(Color.parseColor(color), hsv);
        return BitmapDescriptorFactory.defaultMarker(hsv[0]);
    }

    public void init_sensor(){
        sensor_name = "";
        CO = "";
        NO2 = "";
        O3 = "";
        SO2 = "";
        PM = "";
        CO_AQI = "";
        NO2_AQI = "";
        O3_AQI = "";
        SO2_AQI = "";
        PM_AQI = "";
        temperature = "";
        total_AQI_name = "";
        total_AQI_value = "";
        timestamp = "";
        lat = "";
        lng = "";
        air_timestamp = "";
    }

    public String getColor(double value){
        String color = "";
        if(value < 50)
            color = "#00E400";
        else if(value < 100)
            color = "#FFFF00";
        else if(value < 150)
            color = "#FF7E00";
        else if(value < 200)
            color = "FF0000";
        else if(value < 300)
            color = "#99004C";
        else if(value >= 300)
            color = "#4C0026";
        else
            color = "#FFFFFF";
        Log.d("asdf", "getColor" + color);
        return color;
    }
}
