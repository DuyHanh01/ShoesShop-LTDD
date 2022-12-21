package com.example.shopsneaker.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.example.shopsneaker.R;
import com.google.firebase.FirebaseException;
import com.google.firebase.auth.PhoneAuthCredential;
import com.google.firebase.auth.PhoneAuthProvider;

import java.util.concurrent.TimeUnit;

public class ActivityForgotPassword extends AppCompatActivity {

    EditText editText1;
    Button sendotp;
    ProgressBar progressBar;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forgotpassword);

        editText1=findViewById(R.id.input_mob_no);
        sendotp=findViewById(R.id.btnsend);
        progressBar=findViewById(R.id.progressbar);

        sendotp.setOnClickListener(view -> {

            if (!editText1.getText().toString().trim().isEmpty()){
                if ((editText1.getText().toString().trim()).length()==10)
                {

                    progressBar.setVisibility(View.VISIBLE);
                    sendotp.setVisibility(View.INVISIBLE);

                    PhoneAuthProvider.getInstance().verifyPhoneNumber(
                            "+84" + editText1.getText().toString(),
                            60,
                            TimeUnit.SECONDS,
                            ActivityForgotPassword.this,
                            new PhoneAuthProvider.OnVerificationStateChangedCallbacks() {
                                @Override
                                public void onVerificationCompleted(@NonNull PhoneAuthCredential phoneAuthCredential) {

                                    progressBar.setVisibility(View.GONE);
                                    sendotp.setVisibility(View.VISIBLE);
                                }

                                @Override
                                public void onVerificationFailed(@NonNull FirebaseException e) {

                                    progressBar.setVisibility(View.GONE);
                                    sendotp.setVisibility(View.VISIBLE);
                                    Toast.makeText(ActivityForgotPassword.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                                }

                                @Override
                                public void onCodeSent(@NonNull String backendotp, @NonNull PhoneAuthProvider.ForceResendingToken forceResendingToken) {

                                    progressBar.setVisibility(View.GONE);
                                    sendotp.setVisibility(View.VISIBLE);

                                    Intent intent=new Intent(getApplicationContext(),ActivityOTP.class);
                                    intent.putExtra("mobile",editText1.getText().toString());
                                    intent.putExtra("backendotp",backendotp);
                                    intent.putExtra("value", 1);
                                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    startActivity(intent);
                                }
                            }
                    );
                }else {
                    Toast.makeText(ActivityForgotPassword.this, "Please enter correct Phone", Toast.LENGTH_SHORT).show();
                }
            }else
            {
                Toast.makeText(ActivityForgotPassword.this, "Enter Phone Number", Toast.LENGTH_SHORT).show();
            }

        });
    }
}
