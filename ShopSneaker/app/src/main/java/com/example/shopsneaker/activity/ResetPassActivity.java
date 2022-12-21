package com.example.shopsneaker.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.shopsneaker.R;
import com.example.shopsneaker.retrofit.ApiService;
import com.example.shopsneaker.retrofit.RetrofitClient;
import com.example.shopsneaker.utils.Utils;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

import io.reactivex.rxjava3.android.schedulers.AndroidSchedulers;
import io.reactivex.rxjava3.disposables.CompositeDisposable;
import io.reactivex.rxjava3.schedulers.Schedulers;

public class ResetPassActivity extends AppCompatActivity {

    EditText edtPassWord, repass;
    String username;
    Button btnRegister;
    ApiService apiBanGiay;
    CompositeDisposable compositeDisposable = new CompositeDisposable();

    @Override
    protected void onCreate(Bundle SaveInstanceState){
        super.onCreate(SaveInstanceState);
        setContentView(R.layout.activity_resetpass);
        initView();
        initControll();
    }

    public static boolean isValidPassword(String password) {
        Matcher matcher = Pattern.compile("((?=.*[a-z])(?=.*\\d)(?=.*[A-Z])(?=.*[@#$%!]).{8,20})").matcher(password);
        return matcher.matches();
    }

    private void initControll() {
        String strpass = edtPassWord.getText().toString().trim();
        btnRegister.setOnClickListener(v -> {
            String pass = Utils.getMD5(strpass);
            compositeDisposable.add(apiBanGiay.resetPass(username, pass).subscribeOn(Schedulers.io())
                    .observeOn(AndroidSchedulers.mainThread())
                    .subscribe(
                            userModel -> {
                                if(userModel.isSuccess()){
                                    Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                                    startActivity(intent);
                                    finish();
                                }else {
                                    Toast.makeText(getApplicationContext(),userModel.getMessage(), Toast.LENGTH_LONG).show();
                                }
                            },
                            throwable -> Toast.makeText(getApplicationContext(),throwable.getMessage(), Toast.LENGTH_LONG).show()
                    ));
        });
    }

    private void initView() {
        apiBanGiay = RetrofitClient.getInstance(Utils.BASE_URL).create(ApiService.class);
        username = getIntent().getStringExtra("mobile");
        edtPassWord = findViewById(R.id.txtPassDK);
        repass = findViewById(R.id.txtrePassDK);
        btnRegister = findViewById(R.id.btnXacNhan);
    }

    @Override
    protected void onDestroy(){
        compositeDisposable.clear();
        super.onDestroy();
    }
}
