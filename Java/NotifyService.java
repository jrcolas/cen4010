package com.jrcolas.enrollifier;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.IBinder;

import com.jrcolas.enrollifier.MainActivity;
import com.jrcolas.enrollifier.NotifTest;
import com.jrcolas.enrollifier.R;

/**
 * Created by jrcol on 11/25/2017.
 */

public class NotifyService extends Service {
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onCreate() {
        Uri sound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

        NotificationManager mNM = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
        Intent intent1 = new Intent(this.getApplicationContext(), MainActivity.class);
        PendingIntent pIntent = PendingIntent.getActivity(this, 0, intent1, 0);

        Notification mNotify = new Notification.Builder(this)
                .setContentTitle("Class Open!")
                .setContentText("A class from your cart is open. Enroll now!")
                .setSmallIcon(R.drawable.ic_menu_manage)
                .setContentIntent(pIntent)
                .setSound(sound)
                .addAction(0, "Enroll", pIntent)
                .build();

        mNM.notify(1, mNotify);
    }
}
