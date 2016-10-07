package com.wys.android.wys;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;


public class WYSActivity extends AppCompatActivity {

    public static final int REQUEST_CODE_ASK_WRITE_EXTERNAL_STORAGE_PERMISSIONS = 1;
    public static final int REQUEST_CODE_ASK_CAMERA_PERMISSIONS = 2;
    public static final String ARG_REPORT_DETAIL_ID = "report_detail_id";

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_frame);

        if (savedInstanceState == null) {
            getSupportFragmentManager().beginTransaction()
                  .replace(R.id.content_frame, WYSFragment.newInstance())
                  .commit();


        }
    }

}
