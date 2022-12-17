package com.example.shopsneaker.utils;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class AppConfig {
    private static String BASE_URL = "http://192.168.0.15:8080/server/";
    static Gson gson = new GsonBuilder()
            .setLenient()
            .setDateFormat ("yyyy-MM-dd HH:mm:ss")
            .create();
    public static Retrofit getRetrofit() {

        return new Retrofit.Builder()
                .baseUrl(AppConfig.BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
    }
}
