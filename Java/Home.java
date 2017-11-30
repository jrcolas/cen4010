package com.jrcolas.enrollifier;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.support.v4.app.NotificationCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.webkit.JavascriptInterface;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.Toast;

import java.io.InputStream;

public class Home extends MainActivity {

    WebView webView;

    // Notification ----------------------------------------------------------------------------------------------------------
    private int currentNotificationID = 0;
    private Button btnMainSendSimpleNotification;
    private NotificationCompat.Builder notificationBuilder;
    private String notificationTitle;
    private String notificationText;
    private Bitmap icon;
    // Notification End ------------------------------------------------------------------------------------------------------

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
                setContentView(R.layout.activity_home);


        // WebView
        final String url = "http://cen4010.jrcolas.com/app/login.php";
        //final String url = "https://m.fiu.edu/myfiu/student.php?action=viewCart";
        webView = (WebView) this.findViewById(R.id.firstWebView);
        WebSettings webSettings = webView.getSettings();
        webView.setVerticalScrollBarEnabled(false);
        webView.setHorizontalScrollBarEnabled(false);

        // Javascript Injection Part 1 ------------------------------------------------------------------------------------------
        webSettings.setJavaScriptEnabled(true);
        webSettings.setAllowUniversalAccessFromFileURLs(true);
        webView.addJavascriptInterface(new WebViewJavaScriptInterface(this), "Android");
        webView.setWebViewClient(new WebViewClient() {
            @Override
            public void onPageFinished(WebView view, String address) {
                injectJS();
                super.onPageFinished(view, address);
            }
        });
        // END Javascript Injection Part 1 ---------------------------------------------------------------------------------------

        webView.loadUrl(url);
        // END WebView
    }

    // Javascript Injection Part 2 ------------------------------------------------------------------------------------------
    private void injectJS() {
        try {
            InputStream inputStream = getAssets().open("js/script.js");
            byte[] buffer = new byte[inputStream.available()];
            inputStream.read(buffer);
            inputStream.close();
            String encoded = Base64.encodeToString(buffer, Base64.NO_WRAP);
            webView.loadUrl("javascript:(function() {" +
                    "var parent = document.getElementsByTagName('head').item(0);" +
                    "var script = document.createElement('script');" +
                    "script.type = 'text/javascript';" +
                    "script.innerHTML = window.atob('" + encoded + "');" +
                    "parent.appendChild(script)" +
                    "})()");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    // END Javascript Injection Part 2 ---------------------------------------------------------------------------------------

    // Notification Methods --------------------------------------------------------------------------------------------------
    private void sendNotification() {
        NotificationManager mNM = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
        Intent notificationIntent = new Intent(this, MainActivity.class);
        PendingIntent contentIntent = PendingIntent.getActivity(this, 0, notificationIntent, PendingIntent.FLAG_UPDATE_CURRENT);
        notificationBuilder.setContentIntent(contentIntent);
        Notification notification = notificationBuilder.build();
        notification.flags |= Notification.FLAG_AUTO_CANCEL;
        notification.defaults |= Notification.DEFAULT_SOUND;
        currentNotificationID++;
        int notificationId = currentNotificationID;
        if (notificationId == Integer.MAX_VALUE - 1)
            notificationId = 0;
        mNM.notify(notificationId, notification);
    }

    private void setNotificationData() {
        notificationTitle = this.getString(R.string.app_name);
        notificationText = "A course from your cart is open!";
    }
    private void setDataForSimpleNotification() {
        notificationBuilder = new NotificationCompat.Builder(this)
                .setSmallIcon(R.mipmap.ic_launcher_round)
                .setLargeIcon(icon)
                .setStyle(new NotificationCompat.BigTextStyle().bigText(notificationText))
                .setPriority(Notification.PRIORITY_MAX)
                .setContentTitle(notificationTitle)
                .setContentText(notificationText);
        sendNotification();
    }
    // END Notification Methods ---------------------------------------------------------------------------------------------------

    // Javascript Web App Interface -----------------------------------------------------------------------------------------------
    public class WebViewJavaScriptInterface{

        private Context mContext;

        public WebViewJavaScriptInterface(Context context){
            this.mContext = context;
        }

        @JavascriptInterface
        public void showToast(String toast) {
            setNotificationData();
            setDataForSimpleNotification();
        }
    }
    // END Javascript Web App Interface ---------------------------------------------------------------------------------------

}
