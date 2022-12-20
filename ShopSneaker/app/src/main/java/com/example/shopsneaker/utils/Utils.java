package com.example.shopsneaker.utils;

import com.example.shopsneaker.model.GioHang;
import com.example.shopsneaker.model.SaleDetails;
import com.example.shopsneaker.model.User;

import java.util.ArrayList;
import java.util.List;

public class Utils {
    //public static final String BASE_URL = "http://vlthsneakers.000webhostapp.com/server/";
    public static final String BASE_URL = "http://192.168.1.10:8080/server/";
    public static List<GioHang> manggiohang;
    public static User user_current = new User();
    public static ArrayList<SaleDetails> ListSaleDetails = new ArrayList<>();
    public static ArrayList<SaleDetails> ListSaleDetailsDelete = new ArrayList<>();


}
