package com.jrcolas.enrollifier;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.view.LayoutInflater;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.EditText;

import java.util.Timer;
import java.util.TimerTask;

public class Navigation extends MainActivity {

    private int currentNotificationID = 0;
    //private EditText etMainNotificationText, etMainNotificationTitle;
    //private Button btnMainSendSimpleNotification, btnMainSendExpandLayoutNotification, btnMainSendNotificationActionBtn, btnMainSendMaxPriorityNotification, btnMainSendMinPriorityNotification, btnMainSendCombinedNotification, btnMainClearAllNotification;
    private NotificationManager notificationManager;
    private NotificationCompat.Builder notificationBuilder;
    private String notificationTitle;
    private String notificationText;
    private Bitmap icon;
    private int combinedNotificationCounter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        LayoutInflater inflater = (LayoutInflater) this
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View contentView = inflater.inflate(R.layout.activity_settings, null, false);

        //mDrawerLayout.addView(contentView, 0);
/*
        // Main interface area
        final String url = "http://cen4010.jrcolas.com/app/notif.html";
        // final String url2 = "https://m.fiu.edu/myfiu/student.php?action=viewCart";
        final WebView webView = (WebView) this.findViewById(R.id.firstWebView);

        webView.setWebViewClient(new WebViewClient());
        webView.getSettings().setJavaScriptEnabled(true);
        webView.setVerticalScrollBarEnabled(false);
        webView.setHorizontalScrollBarEnabled(false);
        webView.loadUrl(url);*/

        setNotificationData();
        setDataForSimpleNotification();



    }



    public void sendMessage(View view) {
        setNotificationData();
        setDataForSimpleNotification();
    }

    private void setNotificationData() {
        notificationTitle = "Enrollifier Notification";
        notificationText = "Hello..This is a Notification Test for our Enrollifier App";
    }

    private void sendNotification() {
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
        notificationManager.notify(notificationId, notification);
    }

    private void setDataForSimpleNotification() {
        notificationBuilder = new NotificationCompat.Builder(this)
                .setSmallIcon(R.mipmap.ic_launcher)
                .setLargeIcon(icon)
                .setContentTitle(notificationTitle)
                .setContentText(notificationText);
        sendNotification();
    }

}


