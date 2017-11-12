package com.example.enrollifier;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends AppCompatActivity {

    //private final WebView webView = (WebView)this.findViewById(R.id.firstWebView);
    //private final String url = "sample.html";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        WebView webView = (WebView)this.findViewById(R.id.firstWebView);
        webView.setWebViewClient(new WebViewClient());

        webView.setWebViewClient(new WebViewClient());
        webView.getSettings().setJavaScriptEnabled(true);
        webView.setVerticalScrollBarEnabled(false);
        webView.setHorizontalScrollBarEnabled(false);

        String url = "file:///android_asset/login.html";
        webView.loadUrl(url);

    }
}
