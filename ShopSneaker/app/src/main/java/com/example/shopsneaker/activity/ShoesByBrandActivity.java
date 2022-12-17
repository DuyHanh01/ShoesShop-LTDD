package com.example.shopsneaker.activity;

import android.app.SearchManager;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.SearchView;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.shopsneaker.R;
import com.example.shopsneaker.model.Shoes;
import com.example.shopsneaker.retrofit.ApiBanGiay;
import com.example.shopsneaker.retrofit.RetrofitClient;
import com.example.shopsneaker.utils.Utils;
import com.example.shopsneaker.adapter.ShoesAdapter;


import java.util.Collections;
import java.util.Comparator;
import java.util.List;

import io.reactivex.rxjava3.android.schedulers.AndroidSchedulers;
import io.reactivex.rxjava3.disposables.CompositeDisposable;
import io.reactivex.rxjava3.schedulers.Schedulers;

public class ShoesByBrandActivity extends AppCompatActivity {
    Toolbar toolbar;
    RecyclerView recyclerView;
    ApiBanGiay apiBanGiay;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ImageView img_newShoesByBrand;
    int page=1;
    int brandid;
    String sortid;
    String brandname;
    boolean banchay=false, moinhat=false,gia=false;
    List<Shoes> shoesList;
    com.example.shopsneaker.model.SearchHistoryModel searchHistoryModel;
    TextView txt_sortBanChay,txt_sortMoiNhat,txt_sortGia,txtcountsp;
    SearchView searchView;
    LinearLayout linearLayoutSort;
    ImageView imageThemgiohang;
    com.example.shopsneaker.model.Shoes shoes;
    com.nex3z.notificationbadge.NotificationBadge badge;
    private ShoesAdapter shoesAdapter;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_shoes_by_brand);
        apiBanGiay = RetrofitClient.getInstance(Utils.BASE_URL).create(ApiBanGiay.class);
        brandid = getIntent().getIntExtra("brandid",1);
        brandname = getIntent().getStringExtra("brandname");
        sortid=getIntent().getStringExtra("sortid");
        Init();
        ActionToolBar();
        getData("0");
        getEventClick();
    }
    private void getEventClick() {

        txt_sortBanChay.setOnClickListener(view -> {
            if(banchay ==false){
                txt_sortBanChay.setTextColor(android.graphics.Color.rgb(224,67,54));
                txt_sortMoiNhat.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortGia.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortBanChay.setBackgroundResource(R.drawable.textlines);
                txt_sortMoiNhat.setBackgroundResource(R.color.white);
                txt_sortGia.setBackgroundResource(R.color.white);

                Collections.sort(shoesList, (o1, o2) -> o2.getPurchased()-o1.getPurchased());
                //getData("banchay");
                shoesAdapter = new ShoesAdapter(getApplicationContext(),shoesList);
                recyclerView.setAdapter(shoesAdapter);
                banchay=true;
                moinhat=gia=false;
            }else {
                txt_sortBanChay.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortBanChay.setBackgroundResource(R.color.white);
                getData("0");
                banchay=false;
            }
        });
        txt_sortMoiNhat.setOnClickListener(view -> {
            if(moinhat ==false){
                txt_sortMoiNhat.setTextColor(android.graphics.Color.rgb(224,67,54));
                txt_sortGia.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortBanChay.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortMoiNhat.setBackgroundResource(R.drawable.textlines);
                txt_sortBanChay.setBackgroundResource(R.color.white);
                txt_sortGia.setBackgroundResource(R.color.white);
                Collections.sort(shoesList, (o1, o2) -> o2.getShoesNew()-o1.getShoesNew());
                shoesAdapter = new ShoesAdapter(getApplicationContext(),shoesList);
                recyclerView.setAdapter(shoesAdapter);
                //getData("moinhat");
                moinhat=true;
                banchay=gia=false;
            }else {
                txt_sortMoiNhat.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortMoiNhat.setBackgroundResource(R.color.white);
                getData("0");
                moinhat=false;
            }
        });
        txt_sortGia.setOnClickListener(view -> {
            if(gia ==false){
                txt_sortGia.setTextColor(android.graphics.Color.rgb(224,67,54));
                txt_sortMoiNhat.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortBanChay.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortGia.setBackgroundResource(R.drawable.textlines);
                txt_sortBanChay.setBackgroundResource(R.color.white);
                txt_sortMoiNhat.setBackgroundResource(R.color.white);
                Collections.sort(shoesList, (o1, o2) -> {
                    if (o1.getSaleprice() != 0 && o2.getSaleprice() != 0) {
                        return o1.getSaleprice() - o2.getSaleprice();
                    } else if (o1.getSaleprice() == 0 && o2.getSaleprice() != 0) {
                        return o1.getPrice() - o2.getSaleprice();
                    } else if (o1.getSaleprice() != 0 && o2.getSaleprice() == 0) {
                        return o1.getSaleprice() - o2.getPrice();
                    } else {
                        return o1.getPrice() - o2.getPrice();
                    }
                });
                shoesAdapter = new ShoesAdapter(getApplicationContext(),shoesList);
                recyclerView.setAdapter(shoesAdapter);
                //getData("giathapdencao");
                gia=true;
                banchay=moinhat=false;
            }else {
                txt_sortGia.setTextColor(android.graphics.Color.rgb(110,108,108));
                txt_sortGia.setBackgroundResource(R.color.white);
                getData("0");
                gia=false;
            }

        });

    }




    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu,menu);
        SearchManager searchManager =(SearchManager) getSystemService(android.content.Context.SEARCH_SERVICE);
        searchView = (SearchView) menu.findItem(R.id.menuSearch).getActionView();
        searchView.setSearchableInfo(searchManager.getSearchableInfo(getComponentName()));
        searchView.setMaxWidth(Integer.MAX_VALUE);
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                linearLayoutSort.setVisibility(View.INVISIBLE);
                shoesAdapter.getFilter().filter(query);
                int countSP= shoesAdapter.getItemCount();
                txtcountsp.setText("("+countSP+" sản phẩm)");
                String keyword = query.toString();
                if (shoesAdapter.getItemCount()>0) {
                    int accountid = Utils.user_current.getAccountid();
                    compositeDisposable.add(apiBanGiay.SearchHistory(accountid,keyword).subscribeOn(Schedulers.io())
                            .observeOn(AndroidSchedulers.mainThread())
                            .subscribe(searchHistoryModel -> {

                                    },
                                    throwable -> {
                                        Toast.makeText(getApplicationContext(),searchHistoryModel.getMessage(), Toast.LENGTH_LONG).show();
                                    }

                            ));
                }
                return false;

            }

            @Override
            public boolean onQueryTextChange(String newText) {
                linearLayoutSort.setVisibility(View.INVISIBLE);
                shoesAdapter.getFilter().filter(newText);
                int countSP= shoesAdapter.getItemCount();
                txtcountsp.setText("("+countSP+" sản phẩm)");
                return false;
            }
        });
        return true;
    }
    private void getData(String sort) {
        compositeDisposable.add(apiBanGiay.getShoesByBrand(page,brandid,sortid = sort)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        shoesModel -> {
                            if (shoesModel.isSuccess()){
                                shoesList = shoesModel.getResult();
                                shoesAdapter = new com.example.shopsneaker.adapter.ShoesAdapter(getApplicationContext(),shoesList);
                                recyclerView.setAdapter(shoesAdapter);
                                int countSP= shoesList.size();
                                txtcountsp.setText("("+countSP+" sản phẩm)");
                            }

                        },
                        throwable -> {
                            Toast.makeText(getApplicationContext(),"Load san pham theo hang that bai", Toast.LENGTH_LONG).show();

                        }
                ));
    }
    private void ActionToolBar() {
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setTitle(brandname);
        toolbar.setNavigationOnClickListener(view -> {
            Intent intent =new Intent(getApplicationContext(),MainActivity.class);
            startActivity(intent);
            finish();
        });

    }
    private void Init() {
        toolbar = findViewById(R.id.Toolbar);
        recyclerView=findViewById(R.id.recycleviewShoesByBrand);
        //
        RecyclerView.LayoutManager layoutManager = new androidx.recyclerview.widget.GridLayoutManager(this,2);
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setHasFixedSize(true);
        shoesList = new java.util.ArrayList<>();
        txt_sortBanChay=findViewById(R.id.banchay);
        txt_sortMoiNhat=findViewById(R.id.moinhat);
        txt_sortGia=findViewById(R.id.giathapdencao);
        linearLayoutSort = findViewById(R.id.linearlayoutSort);
        txtcountsp= findViewById(com.example.shopsneaker.R.id.txtcountsp);
    }
    @Override
    public boolean onOptionsItemSelected(@androidx.annotation.NonNull android.view.MenuItem item) {
        switch (item.getItemId()){
            case R.id.menugiohang:
                android.content.Intent intent =new android.content.Intent(getApplicationContext(),GioHangActivity.class);
                startActivity(intent);
                break;
            case R.id.profile:
                android.content.Intent intentLogout =new android.content.Intent(getApplicationContext(),ProfileActivity.class);
                startActivity(intentLogout);
                break;
        }
        return super.onOptionsItemSelected(item);
    }
    @Override
    public void onBackPressed() {
        if (!searchView.isIconified()){
            searchView.setIconified(true);
            linearLayoutSort.setVisibility(View.VISIBLE);
            return;
        }
        super.onBackPressed();
    }

    @Override
    protected void onDestroy() {
        compositeDisposable.clear();
        super.onDestroy();
    }
}
