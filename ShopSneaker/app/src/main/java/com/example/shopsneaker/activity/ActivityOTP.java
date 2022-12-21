package com.example.shopsneaker.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.example.shopsneaker.R;
import com.example.shopsneaker.model.Shoes;
import com.google.firebase.FirebaseException;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.PhoneAuthCredential;
import com.google.firebase.auth.PhoneAuthProvider;

import java.util.concurrent.TimeUnit;

public class ActivityOTP extends AppCompatActivity {
    EditText et1, et2, et3, et4, et5, et6;
    Button btnsubmit;
    String getbackendotp, username, password;
    ProgressBar progressBar;
    Integer value;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_otp);

        et1 = findViewById(R.id.inputotp1);
        et2 = findViewById(R.id.inputotp2);
        et3 = findViewById(R.id.inputotp3);
        et4 = findViewById(R.id.inputotp4);
        et5 = findViewById(R.id.inputotp5);
        et6 = findViewById(R.id.inputotp6);
        value = (Integer) getIntent().getSerializableExtra("value");
        username = getIntent().getStringExtra("user");
        password = getIntent().getStringExtra("pass");

        progressBar = findViewById(R.id.probar2);


        //get mobile number from mainActivty to this
        TextView textView = findViewById(R.id.txtmobileno);

        textView.setText(String.format(
                "+84-%S", getIntent().getStringExtra("mobile")
        ));

        getbackendotp = getIntent().getStringExtra("backendotp");


        btnsubmit = findViewById(R.id.btnsubmit);

        btnsubmit.setOnClickListener(view -> {

            if (!et1.getText().toString().trim().isEmpty() && !et2.getText().toString().trim().isEmpty()
                    && !et3.getText().toString().trim().isEmpty()
                    && !et4.getText().toString().trim().isEmpty()
                    && !et5.getText().toString().trim().isEmpty()
                    && !et6.getText().toString().trim().isEmpty()) {

                // marging user's input in a string
                String getuserotp = et1.getText().toString() +
                        et2.getText().toString() +
                        et3.getText().toString() +
                        et4.getText().toString() +
                        et5.getText().toString() +
                        et6.getText().toString();

                if (getbackendotp != null) {

                    progressBar.setVisibility(View.VISIBLE);
                    btnsubmit.setVisibility(View.INVISIBLE);

                    PhoneAuthCredential phoneAuthCredential = PhoneAuthProvider.getCredential(getbackendotp, getuserotp);
                    FirebaseAuth.getInstance().signInWithCredential(phoneAuthCredential)
                            .addOnCompleteListener(task -> {

                                progressBar.setVisibility(View.GONE);
                                btnsubmit.setVisibility(View.VISIBLE);

                                if (task.isSuccessful()) {
                                    Intent intent;
                                    if(value == 1){
                                        intent = new Intent(getApplicationContext(), ResetPassActivity.class);
                                    }else{
                                        intent = new Intent(getApplicationContext(), AddInforActivity.class);
                                    }
                                    intent.putExtra("user", username);
                                    intent.putExtra("pass", password);
                                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                    startActivity(intent);
                                } else {
                                    Toast.makeText(ActivityOTP.this, "Enter current OTP", Toast.LENGTH_SHORT).show();
                                }
                            });


                } else {
                    Toast.makeText(ActivityOTP.this, "Please check internet", Toast.LENGTH_SHORT).show();
                }

                //Toast.makeText(MainActivity2.this, "OTP Verify", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(ActivityOTP.this, "Please fill all number", Toast.LENGTH_SHORT).show();
            }


            // movenumtonext();



        });

        findViewById(R.id.sendotp_again).setOnClickListener(view -> PhoneAuthProvider.getInstance().verifyPhoneNumber(
                "+84" + getIntent().getStringExtra("mobile"),
                60,
                TimeUnit.SECONDS,
                ActivityOTP.this,
                new PhoneAuthProvider.OnVerificationStateChangedCallbacks() {
                    @Override
                    public void onVerificationCompleted(@NonNull PhoneAuthCredential phoneAuthCredential) {


                    }

                    @Override
                    public void onVerificationFailed(@NonNull FirebaseException e) {


                        Toast.makeText(ActivityOTP.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                    }

                    @Override
                    public void onCodeSent(@NonNull String newbackendotp, @NonNull PhoneAuthProvider.ForceResendingToken forceResendingToken) {


                        getbackendotp = newbackendotp;
                        Toast.makeText(ActivityOTP.this, "OTP Send Successfully", Toast.LENGTH_SHORT).show();


                    }
                }

        ));

        movenumtonext(); //move num to next

    }

    private void movenumtonext() {



        et1.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                if (!charSequence.toString().trim().isEmpty()) {
                    et2.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        et2.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                if (!charSequence.toString().trim().isEmpty()) {
                    et3.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        et3.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                if (!charSequence.toString().trim().isEmpty()) {
                    et4.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        et4.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                if (!charSequence.toString().trim().isEmpty()) {
                    et5.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        et5.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                if (!charSequence.toString().trim().isEmpty()) {
                    et6.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });


    }
}
