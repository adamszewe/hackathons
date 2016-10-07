package com.wys.android.wys;


import java.util.List;

import retrofit2.adapter.rxjava.Result;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.Query;
import rx.Observable;

public interface RetrofitApiInterface {

    String CONTENT_TYPE_JSON = "Content-Type: application/json";
    String AUTH_HEADER = "Authorization";



/*    @POST("donate")
    @Headers(CONTENT_TYPE_JSON)*/
//    Observable<Result<Object>> donate(@Body LoginParams loginParams);


}
