package com.wys.android.wys;

import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.provider.Telephony;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;

import com.jakewharton.picasso.OkHttp3Downloader;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
import okhttp3.OkHttpClient;


public class WYSFragment extends Fragment {

    private static final String TAG = WYSFragment.class.getSimpleName();

    private String mImagePath;
    private File mImageFile;

    private Context mContext;

    public static final String ARG_REPORT_DETAIL_ID = "report_detail_id";
    private static final int REQUEST_IMAGE_CAPTURE = 1;
    public static final String REPORT_DETAIL_RESULT_KEY = "report_detail_result_key";

    private boolean mHasCameraPermission;
    private boolean mHasStorageAccessPermission;

    private boolean mWasLaunchingCamera = false;
    private Uri mPhotoFileUri;

    @BindView(R.id.report_iv)
    public ImageView mReportIv;


    @BindView(R.id.report_image_container)
    public RelativeLayout mReportImageContainer;

    @BindView(R.id.image_preview)
    public ImageView mImagePreview;


    public static WYSFragment newInstance() {
        WYSFragment fragment = new WYSFragment();
        return fragment;
    }


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mContext = getActivity().getApplicationContext();
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_report_detail, null);
        ButterKnife.bind(this, view);

        return view;
    }


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

    }

    @OnClick(R.id.photo_selector)
    void onSelectorClick() {
        mWasLaunchingCamera = true;
        launchCameraIntent();
    }



    @OnClick(R.id.save_btn)
    void onSaveClick() {
        // todo send this shit
    }


    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == REQUEST_IMAGE_CAPTURE) {
            if (resultCode == Activity.RESULT_OK) {
                Log.d(TAG, "we have the image now!" + mPhotoFileUri);
//                Utils.addFileToGallery(mContext, mPhotoFileUri);
//                mPresenter.addImageToReport(mPhotoFileUri.getPath());
                showImage(mImageFile.getPath());
            } else {
                if (mPhotoFileUri != null) {
                    File file = new File(mPhotoFileUri.getPath());
                    file.delete();
                }
            }
        }
    }



    public void showImage(String reportImageUrl) {
        Log.d(TAG, "image file is: " + mImageFile);
        Picasso pinstance = (new Picasso.Builder(mContext)).downloader(new OkHttp3Downloader(new OkHttpClient())).build();
        pinstance.with(mContext)
                .load(mImageFile)
//                .load("https://support.files.wordpress.com/2009/07/pigeony.jpg?w=688")
//                .transform(new RoundedCornersTransformation(HdxUiUtility.fromDptoPx(mContext, 15), 0))
                .fit()
                .centerCrop()
                .into(mImagePreview);
    }

    public void hideDeleteButton() {
//        mDelete.setVisibility(View.GONE);
    }

    public void showDeleteButton() {
//        mDelete.setVisibility(View.VISIBLE);
    }



    public File createImageFile() throws IOException {
        // Create an image file name
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = timeStamp;
        File storageDir = Environment.getExternalStorageDirectory();
        File image = new File (storageDir, imageFileName + ".jpg");
        return image;
    }


    private void launchCameraIntent() {
        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        // Ensure that there's a camera activity to handle the intent
        if (intent.resolveActivity(mContext.getPackageManager()) != null) {
            // Create the File where the photo should go

            try {
                mImageFile = createImageFile();
                mPhotoFileUri = Uri.fromFile(mImageFile);
            } catch (Exception e) {

            }
            // Continue only if the File was successfully created
                intent.putExtra(MediaStore.EXTRA_OUTPUT, mPhotoFileUri);
                startActivityForResult(intent, REQUEST_IMAGE_CAPTURE);
        }
    }
}
