package com.jrcolas.enrollifier;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.menu_home:
                // Red item was selected
                startActivity(new Intent(this, Home.class));
                overridePendingTransition(0, 0);
                return true;
            case R.id.menu_settings:
                // Green item was selected
                startActivity(new Intent(this, Settings.class));
                overridePendingTransition(0, 0);
                return true;

            case R.id.menu_help:
                // Help item selected
                startActivity(new Intent(this, Help.class));
                overridePendingTransition(0, 0);
                return true;

            case R.id.menu_test1:
                // Help item selected
                startActivity(new Intent(this, NotifTest.class));
                overridePendingTransition(0, 0);
                return true;

            case R.id.menu_test2:
                // Help item selected
                startActivity(new Intent(this, Test2.class));
                overridePendingTransition(0, 0);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
