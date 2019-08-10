package com.example.design;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.github.mikephil.charting.animation.Easing;
import com.github.mikephil.charting.charts.LineChart;
import com.github.mikephil.charting.components.Legend;
import com.github.mikephil.charting.components.LimitLine;
import com.github.mikephil.charting.components.YAxis;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.LineData;
import com.github.mikephil.charting.data.LineDataSet;
import com.github.mikephil.charting.highlight.Highlight;
import com.github.mikephil.charting.interfaces.datasets.ILineDataSet;
import com.github.mikephil.charting.listener.ChartTouchListener;
import com.github.mikephil.charting.listener.OnChartGestureListener;
import com.github.mikephil.charting.listener.OnChartValueSelectedListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;

//https://www.studytutorial.in/android-line-chart-or-line-graph-using-mpandroid-library-tutorial
public class chart_activity extends AppCompatActivity implements OnChartGestureListener,
        OnChartValueSelectedListener {

    TextView sensor_name;
    TextView chart_date;

    Button allButton;
    Button coButton;
    Button noButton;
    Button o3Button;
    Button pmButton;
    Button soButton;
    Button temperButton;
    Button calendarButton;
    Button searchButton;

    String get_SSN = "";
    String result = "";
    String result_code = "";
    String success_message = "";
    String error_message = "";
    public LineChart mChart;

    LineDataSet CO;
    LineDataSet NO2;
    LineDataSet O3;
    LineDataSet PM;
    LineDataSet SO2;
    LineDataSet temperature;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // To make full screen layout
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        setContentView(R.layout.chart_layout);

        Intent intent = getIntent();
        get_SSN = intent.getStringExtra("SSN");
        final String get_Sensor = intent.getStringExtra("Sensor");
        Log.d("asdf", "message: " + get_Sensor);
        sensor_name = (TextView) findViewById(R.id.chart_sensor);
        sensor_name.setText(get_Sensor);

        allButton = (Button)findViewById(R.id.chart_all_button);
        coButton = (Button)findViewById(R.id.chart_co_button);
        noButton = (Button)findViewById(R.id.chart_no_button);
        o3Button = (Button)findViewById(R.id.chart_o3_button);
        pmButton = (Button)findViewById(R.id.chart_pm_button);
        soButton = (Button)findViewById(R.id.chart_so2_button);
        temperButton = (Button)findViewById(R.id.chart_temp_button);
        calendarButton = (Button)findViewById(R.id.chart_calendar_button);
        searchButton = (Button)findViewById(R.id.chart_search_button);
        chart_date = (TextView)findViewById(R.id.chart_date);

        mChart = (LineChart) findViewById(R.id.linechart);
        mChart.setBackgroundColor(Color.rgb(214,248,184));
        mChart.setDrawGridBackground(true);
        mChart.setOnChartValueSelectedListener(this);
        mChart.setDrawGridBackground(false);

        calendarButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Calendar calendar = Calendar.getInstance();
                int year = calendar.get(Calendar.YEAR);
                int monthOfYear = calendar.get(Calendar.MONTH);
                int dayOfMonth = calendar.get(Calendar.DAY_OF_MONTH);
                DatePickerDialog dialog = new DatePickerDialog(chart_activity.this, dateOnDateSetListener, year, monthOfYear, dayOfMonth);
                dialog.getDatePicker().setMaxDate(new Date().getTime());
                dialog.getDatePicker().setMinDate(1564642800000L);

                dialog.show();
            }

        });

        searchButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                User_data user_data = (User_data) getApplication();

                JSONObject json = new JSONObject();
                try {
                    json.put("SSN", get_SSN);
                    json.put("USN", user_data.getUSN());
                    json.put("historical_interval", chart_date.getText());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                Log.d("asdf", "json: " + json.toString());
                try {
                    result = new PostJSON().execute("http://teamd-iot.calit2.net/app/data/get/historical/airquality", json.toString()).get();
                } catch (ExecutionException e) {
                    e.printStackTrace();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                try {
                    JSONArray json_array = new JSONArray(result);
                    ArrayList<String> xVals = new ArrayList<String>();
                    ArrayList<Entry> COVals = new ArrayList<Entry>();
                    ArrayList<Entry> NO2Vals = new ArrayList<Entry>();
                    ArrayList<Entry> O3Vals = new ArrayList<Entry>();
                    ArrayList<Entry> SO2Vals = new ArrayList<Entry>();
                    ArrayList<Entry> PMVals = new ArrayList<Entry>();
                    ArrayList<Entry> temperatureVals = new ArrayList<Entry>();

                    for (int i = 0 ; i< json_array.length(); i++){
                        JSONObject json_data = json_array.getJSONObject(i);
                        Log.d("asdf", "json:" + json_data);
                        String CO = json_data.optString("CO");
                        COVals.add(new Entry(Float.valueOf(CO), i));
                        String NO2 = json_data.optString("NO2");
                        NO2Vals.add(new Entry(Float.valueOf(NO2), i));
                        String O3 = json_data.optString("O3");
                        O3Vals.add(new Entry(Float.valueOf(O3), i));
                        String SO2 = json_data.optString("SO2");
                        SO2Vals.add(new Entry(Float.valueOf(SO2), i));
                        String PM = json_data.optString("PM2_5");
                        PMVals.add(new Entry(Float.valueOf(PM), i));
                        String temperature = json_data.optString("temperature");
                        temperatureVals.add(new Entry(Float.valueOf(temperature), i));
                        String air_timestamp = json_data.optString("air_timestamp");
                        xVals.add(air_timestamp);
                    }

                    CO = new LineDataSet(COVals, "CO");
                    NO2 = new LineDataSet(NO2Vals, "NO2");
                    O3 = new LineDataSet(O3Vals, "O3");
                    PM = new LineDataSet(PMVals, "PM2.5");
                    SO2 = new LineDataSet(SO2Vals, "SO2");
                    temperature = new LineDataSet(temperatureVals, "temperature");

                    // create a dataset and give it a type
                    CO.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    CO.setColor(Color.rgb(210,9,98));
                    CO.setCircleColor(Color.rgb(210,9,98));
                    CO.setLineWidth(1f);
                    CO.setCircleRadius(3f);
                    CO.setDrawCircleHole(false);
                    CO.setValueTextSize(9f);
                    CO.setDrawFilled(true);
                    CO.setFillColor(Color.rgb(210,9,98));

                    NO2.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    NO2.setColor(Color.rgb(244,119,33));
                    NO2.setCircleColor(Color.rgb(244,119,33));
                    NO2.setLineWidth(1f);
                    NO2.setCircleRadius(3f);
                    NO2.setDrawCircleHole(false);
                    NO2.setValueTextSize(9f);
                    NO2.setDrawFilled(true);
                    NO2.setFillColor(Color.rgb(244,119,33));

                    O3.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    O3.setColor(Color.rgb(122,193,67));
                    O3.setCircleColor(Color.rgb(122,193,67));
                    O3.setLineWidth(1f);
                    O3.setCircleRadius(3f);
                    O3.setDrawCircleHole(false);
                    O3.setValueTextSize(9f);
                    O3.setDrawFilled(true);
                    O3.setFillColor(Color.rgb(122,193,67));

                    PM.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    PM.setColor(Color.rgb(0,167,142));
                    PM.setCircleColor(Color.rgb(0,167,142));
                    PM.setLineWidth(1f);
                    PM.setCircleRadius(3f);
                    PM.setDrawCircleHole(false);
                    PM.setValueTextSize(9f);
                    PM.setDrawFilled(true);
                    PM.setFillColor(Color.rgb(0,167,142));

                    SO2.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    SO2.setColor(Color.rgb(0,188,228));
                    SO2.setCircleColor(Color.rgb(0,188,228));
                    SO2.setLineWidth(1f);
                    SO2.setCircleRadius(3f);
                    SO2.setDrawCircleHole(false);
                    SO2.setValueTextSize(9f);
                    SO2.setDrawFilled(true);
                    SO2.setFillColor(Color.rgb(0,188,228));

                    temperature.setFillAlpha(110);
                    // set1.setFillColor(Color.RED);

                    // set the line to be drawn like this "- - - - - -"
                    //   set1.enableDashedLine(10f, 5f, 0f);
                    // set1.enableDashedHighlightLine(10f, 5f, 0f);
                    temperature.setColor(Color.rgb(125,63,152));
                    temperature.setCircleColor(Color.rgb(125,63,152));
                    temperature.setLineWidth(1f);
                    temperature.setCircleRadius(3f);
                    temperature.setDrawCircleHole(false);
                    temperature.setValueTextSize(9f);
                    temperature.setDrawFilled(true);
                    temperature.setFillColor(Color.rgb(125,63,152));

                    ArrayList<ILineDataSet> dataSets = new ArrayList<ILineDataSet>();
                    dataSets.add(CO); // add the datasets
                    dataSets.add(NO2); // add the datasets
                    dataSets.add(O3); // add the datasets
                    dataSets.add(PM); // add the datasets
                    dataSets.add(SO2); // add the datasets
                    dataSets.add(temperature); // add the datasets

                    // create a data object with the datasets
                    LineData data = new LineData(xVals, dataSets);

                    // set data
                    mChart.setData(data);

                } catch (Exception e) {
                    Log.e("Fail 3", e.toString());
                }
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
                    Toast.makeText(chart_activity.this, success_message, Toast.LENGTH_SHORT).show();
                    try {
                        TimeUnit.SECONDS.sleep(1);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    finish();
                }
                else if(result_code.equals("1")){
                    Toast.makeText(chart_activity.this, error_message, Toast.LENGTH_SHORT).show();
                }

                // get the legend (only possible after setting data)
                Legend l = mChart.getLegend();

                // modify the legend ...
                // l.setPosition(LegendPosition.LEFT_OF_CHART);
                l.setForm(Legend.LegendForm.LINE);

                // no description text
                mChart.setDescription(get_Sensor + "Chart");
                mChart.setNoDataTextDescription("You need to provide data for the chart.");

                // enable touch gestures
                mChart.setTouchEnabled(true);

                // enable scaling and dragging
                mChart.setDragEnabled(true);
                mChart.setScaleEnabled(true);
                // mChart.setScaleXEnabled(true);
                // mChart.setScaleYEnabled(true);

                LimitLine upper_limit = new LimitLine(130f, "Upper Limit");
                upper_limit.setLineWidth(4f);
                upper_limit.enableDashedLine(10f, 10f, 0f);
                upper_limit.setLabelPosition(LimitLine.LimitLabelPosition.RIGHT_TOP);
                upper_limit.setTextSize(10f);

                LimitLine lower_limit = new LimitLine(-30f, "Lower Limit");
                lower_limit.setLineWidth(4f);
                lower_limit.enableDashedLine(10f, 10f, 0f);
                lower_limit.setLabelPosition(LimitLine.LimitLabelPosition.RIGHT_BOTTOM);
                lower_limit.setTextSize(10f);

                YAxis leftAxis = mChart.getAxisLeft();
                leftAxis.removeAllLimitLines(); // reset all limit lines to avoid overlapping lines
                leftAxis.addLimitLine(upper_limit);
                leftAxis.addLimitLine(lower_limit);
                leftAxis.setAxisMaxValue(50f);
                leftAxis.setAxisMinValue(0f);
                //leftAxis.setYOffset(20f);
                leftAxis.enableGridDashedLine(10f, 10f, 0f);
                leftAxis.setDrawZeroLine(false);

                // limit lines are drawn behind data (and not on top)
                leftAxis.setDrawLimitLinesBehindData(true);

                mChart.getAxisRight().setEnabled(false);

                //mChart.getViewPortHandler().setMaximumScaleY(2f);
                //mChart.getViewPortHandler().setMaximumScaleX(2f);

                mChart.animateX(2500, Easing.EasingOption.EaseInOutQuart);

                //  dont forget to refresh the drawing
                mChart.invalidate();
            }
        });

        allButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by All", Toast.LENGTH_SHORT).show();
            }
        });
        coButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by CO", Toast.LENGTH_SHORT).show();
            }
        });
        noButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by NO2", Toast.LENGTH_SHORT).show();
            }
        });
        pmButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by PM2.5", Toast.LENGTH_SHORT).show();
            }
        });
        soButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by SO", Toast.LENGTH_SHORT).show();
            }
        });
        temperButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(chart_activity.this, "filter by temperature", Toast.LENGTH_SHORT).show();
            }
        });


    }


    @Override
    public void onChartGestureStart(MotionEvent me,
                                    ChartTouchListener.ChartGesture
                                            lastPerformedGesture) {

        Log.i("Gesture", "START, x: " + me.getX() + ", y: " + me.getY());
    }

    @Override
    public void onChartGestureEnd(MotionEvent me,
                                  ChartTouchListener.ChartGesture
                                          lastPerformedGesture) {

        Log.i("Gesture", "END, lastGesture: " + lastPerformedGesture);

        // un-highlight values after the gesture is finished and no single-tap
        if(lastPerformedGesture != ChartTouchListener.ChartGesture.SINGLE_TAP)
            // or highlightTouch(null) for callback to onNothingSelected(...)
            mChart.highlightValues(null);
    }

    @Override
    public void onChartLongPressed(MotionEvent me) {
        Log.i("LongPress", "Chart longpressed.");
    }

    @Override
    public void onChartDoubleTapped(MotionEvent me) {
        Log.i("DoubleTap", "Chart double-tapped.");
    }

    @Override
    public void onChartSingleTapped(MotionEvent me) {
        Log.i("SingleTap", "Chart single-tapped.");
    }

    @Override
    public void onChartFling(MotionEvent me1, MotionEvent me2,
                             float velocityX, float velocityY) {
        Log.i("Fling", "Chart flinged. VeloX: "
                + velocityX + ", VeloY: " + velocityY);
    }

    @Override
    public void onChartScale(MotionEvent me, float scaleX, float scaleY) {
        Log.i("Scale / Zoom", "ScaleX: " + scaleX + ", ScaleY: " + scaleY);
    }

    @Override
    public void onChartTranslate(MotionEvent me, float dX, float dY) {
        Log.i("Translate / Move", "dX: " + dX + ", dY: " + dY);
    }

    @Override
    public void onValueSelected(Entry e, int dataSetIndex, Highlight h) {
        Log.i("Entry selected", e.toString());
        Log.i("LOWHIGH", "low: " + mChart.getLowestVisibleXIndex()
                + ", high: " + mChart.getHighestVisibleXIndex());

        Log.i("MIN MAX", "xmin: " + mChart.getXChartMin()
                + ", xmax: " + mChart.getXChartMax()
                + ", ymin: " + mChart.getYChartMin()
                + ", ymax: " + mChart.getYChartMax());
    }

    @Override
    public void onNothingSelected() {
        Log.i("Nothing selected", "Nothing selected.");
    }

    private DatePickerDialog.OnDateSetListener dateOnDateSetListener = new DatePickerDialog.OnDateSetListener() {

        @Override
        public void onDateSet(DatePicker view, int selectedYear, int selectedMonth, int selectedDay) {
            chart_date.setText(selectedYear + "-" + (selectedMonth + 1) + "-" + selectedDay + " 00:00:00");
        }
    };
}