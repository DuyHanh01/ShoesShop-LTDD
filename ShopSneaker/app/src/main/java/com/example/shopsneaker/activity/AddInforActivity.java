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
import java.util.regex.Pattern;

import io.reactivex.rxjava3.android.schedulers.AndroidSchedulers;
import io.reactivex.rxjava3.disposables.CompositeDisposable;
import io.reactivex.rxjava3.schedulers.Schedulers;

public class AddInforActivity extends AppCompatActivity {

    EditText edtName, edtAddress, edtEmail;
    Button btnConfirm;
    ApiService apiService;
    String username, password;
    CompositeDisposable compositeDisposable = new CompositeDisposable();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_information);
        initControll();
        initView();

    }

    private boolean isValidEmailId(String email){

        return Pattern.compile("^(([\\w-]+\\.)+[\\w-]+|([a-zA-Z]{1}|[\\w-]{2,}))@"
                + "((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\\.([0-1]?"
                + "[0-9]{1,2}|25[0-5]|2[0-4][0-9])\\."
                + "([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\\.([0-1]?"
                + "[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|"
                + "([a-zA-Z]+[\\w-]+\\.)+[a-zA-Z]{2,4})$").matcher(email).matches();
    }

    private void initView() {
        btnConfirm.setOnClickListener(v -> ReGisterInfor());
    }

    private void ReGisterInfor() {
        String strname = edtName.getText().toString().trim();
        String straddress = edtAddress.getText().toString().trim();
        String strEmail = edtEmail.getText().toString().trim();
        if(TextUtils.isEmpty(strname)){
            Toast.makeText(getApplicationContext(),"Bạn chưa nhập họ tên", Toast.LENGTH_LONG).show();
        }
        else if(TextUtils.isEmpty(strEmail)){
            Toast.makeText(getApplicationContext(),"Bạn chưa nhập email", Toast.LENGTH_LONG).show();
        }
        if(TextUtils.isEmpty(strEmail)){
            Toast.makeText(getApplicationContext(),"Bạn chưa nhập email", Toast.LENGTH_LONG).show();
        }
        else if(!isValidEmailId(strEmail)){
            Toast.makeText(getApplicationContext(),"Email không đúng", Toast.LENGTH_LONG).show();
        }
        else {
                compositeDisposable.add(apiService.AddInfor(username,password, strname,straddress,strEmail).subscribeOn(Schedulers.io())
                        .observeOn(AndroidSchedulers.mainThread())
                        .subscribe(
                                userModel -> {
                                    if(userModel.isSuccess()){
                                        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                                        startActivity(intent);
                                        finish();
                                    }else {
                                        Toast.makeText(getApplicationContext(),"Thất bại", Toast.LENGTH_LONG).show();
                                    }
                                },
                                throwable -> {
                                    Toast.makeText(getApplicationContext(),"Không kết nối được server", Toast.LENGTH_LONG).show();
                                }
                        ));
        }
    }

    private void initControll() {
        username = getIntent().getStringExtra("user");
        password = getIntent().getStringExtra("pass");
        apiService = RetrofitClient.getInstance(Utils.BASE_URL).create(ApiService.class);
        edtName = findViewById(R.id.edtname);
        edtAddress = findViewById(R.id.edtaddress);
        edtEmail = findViewById(R.id.edtemail);
        btnConfirm = findViewById(R.id.buttonxacnhan);
    }

    @Override
    protected void onDestroy(){
        compositeDisposable.clear();
        super.onDestroy();
    }
}
