package com.wys.android.wys;


public interface WYSInterface {


    void showReportTitle(String title);
    void showReportNote(String note);
    void showImage(String reportImageUrl);

    void hideDeleteButton();
    void showDeleteButton();
    void emptyReportImage();
    void hideReportImage();
}
