package com.example.shopsneaker.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.example.shopsneaker.R;
import com.example.shopsneaker.retrofit.ApiService;
import com.example.shopsneaker.retrofit.RetrofitClient;
import com.example.shopsneaker.utils.Utils;
import com.google.firebase.FirebaseException;
import com.google.firebase.auth.PhoneAuthProvider;

import java.util.concurrent.TimeUnit;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import io.reactivex.rxjava3.android.schedulers.AndroidSchedulers;
import io.reactivex.rxjava3.disposables.CompositeDisposable;
import io.reactivex.rxjava3.schedulers.Schedulers;

public class RegisterActivity extends AppCompatActivity {

    EditText edtUserName;
    EditText edtPassWord, repass;
    Button btnRegister;
    ProgressBar progressBar;
    ApiService apiBanGiay;
    CompositeDisposable compositeDisposable = new CompositeDisposable();

    @Override
    protected  void onCreate(Bundle saveInstanceState){
        super.onCreate(saveInstanceState);
        setContentView(R.layout.activity_register);
        initView();
        initControl();
    }

    public static boolean isValidPhone(String phone)
    {
        String expression = "^([0-9\\+]|\\(\\d{1,3}\\))[0-9\\-\\. ]{3,15}$";
        CharSequence inputString = phone;
        Pattern pattern = Pattern.compile(expression);
        Matcher matcher = pattern.matcher(inputString);
        return matcher.matches();
    }

    private void initControl() {
        btnRegister.setOnClickListener(v -> registerAccount());
    }

    public static boolean isValidPassword(String password) {
        Matcher matcher = Pattern.compile("((?=.*[a-z])(?=.*\\d)(?=.*[A-Z])(?=.*[@#$%!]).{8,20})").matcher(password);
        return matcher.matches();
    }

    private void registerAccount() {
        String struser = edtUserName.getText().toString().trim();
        String strpass = edtPassWord.getText().toString().trim();
        String strrepass = repass.getText().toString().trim();
        if(TextUtils.isEmpty(struser)){
            Toast.makeText(getApplicationContext(),"Bạn chưa nhập Phone", Toast.LENGTH_LONG).show();
        }
        else if(TextUtils.isEmpty(strpass)){
            Toast.makeText(getApplicationContext(),"Bạn chưa nhập mật khẩu", Toast.LENGTH_LONG).show();
        }
        else if(TextUtils.isEmpty(strrepass)){
            Toast.makeText(getApplicationContext(),"Bạn chưa xác nhận mật khẩu", Toast.LENGTH_LONG).show();
        }
        else if(!isValidPhone(struser)){
            Toast.makeText(getApplicationContext(), "Phone không hợp lệ!", Toast.LENGTH_SHORT).show();
        }
        else if(!isValidPassword(strpass)){
            Toast.makeText(getApplicationContext(), "Mật khẩu phải có 8-20 kí tự gồm chữ hoa,chữ thường, số, kí tự đặc biệt", Toast.LENGTH_SHORT).show();
        }
        else {
            if(strpass.equals(strrepass)){
                String pass = Utils.getMD5(strpass);
                compositeDisposable.add(apiBanGiay.ReGister(struser,pass).subscribeOn(Schedulers.io())
                        .observeOn(AndroidSchedulers.mainThread())
                        .subscribe(
                                userModel -> {
                                    if(userModel.isSuccess()){
                                        progressBar.setVisibility(View.VISIBLE);
                                        btnRegister.setVisibility(View.INVISIBLE);

                                        PhoneAuthProvider.getInstance().verifyPhoneNumber(
                                                "+84" + edtUserName.getText().toString(),
                                                60,
                                                TimeUnit.SECONDS,
                                                RegisterActivity.this,
                                                new PhoneAuthProvider.OnVerificationStateChangedCallbacks() {
                                                    @Override
                                                    public void onVerificationCompleted(@NonNull com.google.firebase.auth.PhoneAuthCredential phoneAuthCredential) {

                                                        progressBar.setVisibility(View.GONE);
                                                        btnRegister.setVisibility(View.VISIBLE);
                                                    }

                                                    @Override
                                                    public void onVerificationFailed(@NonNull FirebaseException e) {

                                                        progressBar.setVisibility(View.GONE);
                                                        btnRegister.setVisibility(View.VISIBLE);
                                                        Toast.makeText(RegisterActivity.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                                                    }

                                                    @Override
                                                    public void onCodeSent(@NonNull String backendotp, @NonNull PhoneAuthProvider.ForceResendingToken forceResendingToken) {

                                                        progressBar.setVisibility(View.GONE);
                                                        btnRegister.setVisibility(View.VISIBLE);

                                                        Intent intent=new Intent(getApplicationContext(),ActivityOTP.class);
                                                        intent.putExtra("mobile",edtUserName.getText().toString());
                                                        intent.putExtra("backendotp",backendotp);
                                                        intent.putExtra("value", 2);
                                                        intent.putExtra("user", struser);
                                                        intent.putExtra("pass", pass);
                                                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                                        startActivity(intent);
                                                    }
                                                }
                                        );
                                    }else {
                                        Toast.makeText(getApplicationContext(),userModel.getMessage(), Toast.LENGTH_LONG).show();
                                    }
                                },
                                throwable -> Toast.makeText(getApplicationContext(),throwable.getMessage(), Toast.LENGTH_LONG).show()
                        ));
            }else {
                Toast.makeText(getApplicationContext(),"Mật khẩu không khớp", Toast.LENGTH_LONG).show();
            }
        }
    }

    private void initView() {
        apiBanGiay = RetrofitClient.getInstance(Utils.BASE_URL).create(ApiService.class);
        edtUserName = findViewById(R.id.txtUserDK);
        edtPassWord = findViewById(R.id.txtPassDK);
        repass = findViewById(R.id.txtrePassDK);
        progressBar = findViewById(R.id.progressbarRegister);
        btnRegister = findViewById(R.id.btnDangkiDK);
    }

    @Override
    protected void onDestroy(){
        compositeDisposable.clear();
        super.onDestroy();
    }

}