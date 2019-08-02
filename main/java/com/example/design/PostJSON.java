package com.example.design;

import android.os.AsyncTask;
import android.util.Log;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;

public class PostJSON extends AsyncTask<String, Void, String> {
    @Override
    protected String doInBackground(String... params) {
        String ResultStr = "";
        String pageContents = "";
        String email = "";
        String pass = "";
        String confirm_pass = "";

        StringBuilder contents = new StringBuilder();

        HttpURLConnection httpURLConnection = null;
        try {
            URL url = new URL(params[0]);
            httpURLConnection = (HttpURLConnection)url.openConnection();
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setRequestProperty("Content-Type", "application/json");
            httpURLConnection.setRequestProperty("Accept", "application/json");

            try{
                OutputStreamWriter osw = new OutputStreamWriter(httpURLConnection.getOutputStream());
                osw.write(params[1]);
                osw.flush();
                osw.close();
            } catch (Exception e){
                e.printStackTrace();
            }

            try {
                BufferedReader br = null;
                br = new BufferedReader(new InputStreamReader(httpURLConnection.getInputStream(), "UTF-8"));

                while((pageContents = br.readLine())!=null){
                    //System.out.println(pageContents);
                    contents.append(pageContents);
                    //contents.append("\r\n");
                }

                ResultStr = contents.toString();
                Log.d("asdf", "ResultStr: " + ResultStr);

            }catch(Exception e){
                e.printStackTrace();
            }
            /*
            try {
                JSONObject json_data = new JSONObject(ResultStr);
                // add whatever you would like to parse (all values you are
                // sending from PHP)
                Log.d("asdf",json_data.toString());
                email = (json_data.getString("e_mail"));
                pass = (json_data.getString("password"));
                confirm_pass = (json_data.getString("confirm_password"));
                Log.d("asdf", "e_mail:       " + email);
                Log.d("asdf", "pass:       " + pass);
                Log.d("asdf", "conpass:       " + confirm_pass);
            } catch (Exception e) {
                Log.e("Fail 3", e.toString());
            }
            */

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
        Log.d("asdf", "result: " + result);
    }
}