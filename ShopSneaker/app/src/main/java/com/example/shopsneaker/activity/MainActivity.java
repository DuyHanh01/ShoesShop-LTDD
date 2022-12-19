package com.example.shopsneaker.activity;

import static android.view.View.VISIBLE;

import android.annotation.SuppressLint;
import android.app.SearchManager;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ViewFlipper;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.SearchView;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.viewpager2.widget.ViewPager2;

import com.example.shopsneaker.R;
import com.example.shopsneaker.adapter.BrandAdapter;
import com.example.shopsneaker.adapter.FlashSaleShoesAdapter;
import com.example.shopsneaker.adapter.SalePagerAdapter;
import com.example.shopsneaker.adapter.ShoesAdapter;
import com.example.shopsneaker.model.Brand;
import com.example.shopsneaker.model.Sales;
import com.example.shopsneaker.model.Shoes;
import com.example.shopsneaker.model.User;
import com.example.shopsneaker.retrofit.ApiBanGiay;
import com.example.shopsneaker.retrofit.RetrofitClient;
import com.example.shopsneaker.utils.Utils;
import com.example.shopsneaker.utils.checkconnect;
import com.nex3z.notificationbadge.NotificationBadge;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import io.paperdb.Paper;
import io.reactivex.rxjava3.android.schedulers.AndroidSchedulers;
import io.reactivex.rxjava3.disposables.CompositeDisposable;
import io.reactivex.rxjava3.schedulers.Schedulers;
import me.relex.circleindicator.CircleIndicator3;

public class MainActivity extends AppCompatActivity{
    private Toolbar ToolbarManHinhChinh;
    private RecyclerView recyclerViewNewItems,recyclerViewFlashSaleShoes, recyclerViewSearchHistory;
    private ViewFlipper viewfliperManHinhChinh;
    private ListView ListviewManHinhChinh;
    private ShoesAdapter shoesAdapter;
    private DrawerLayout drawerlayoutManHinhChinh;
    private CompositeDisposable compositeDisposable = new CompositeDisposable();
    private ApiBanGiay apiBanGiay;
    private List<Shoes> mangSanPham;
    private BrandAdapter brandAdapter;
    public List<Brand> mangBrand;
    private FlashSaleShoesAdapter flashSaleShoesAdapter;
    private com.example.shopsneaker.adapter.SearchHistoryAdapter searchHistoryAdapter;
    private TextView txtTBLashSale, txtTBNewShoes,txtflashsaleXemThem,txt_ThongbaoSearhHistory, txtcountsp;
    private ImageView imageViewHotItems,icon_flashsale;
    private NotificationBadge badge;
    private MenuItem menusearch;
    private SearchView searchView;
    public static int id,o;
    private List<Sales> salesList;
    private ProgressBar progressBarSaleMain,progressBarSearchMain,progressBarNewsShoesMain;
    private LinearLayout linearLayoutAdmin;
    private ViewPager2 viewPager2Sale;
    private CircleIndicator3 circleIndicator3;
    private RelativeLayout rl;

    @android.annotation.SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        apiBanGiay = RetrofitClient.getInstance(Utils.BASE_URL).create(ApiBanGiay.class);
        Paper.init(this);
        if(Paper.book().read("user")!=null){
            User user = Paper.book().read("user");
            Utils.user_current = user;
        }
        initUi();
        rl= findViewById(R.id.rl_Sale);
        if(checkconnect.isNetworkAvailable(getApplicationContext())){
            ActionBar();
            getSale();
           // ActionViewFlipper();


            getBrand();
            getSearchHistoryShoes();
            getNewShoes();
            getFlashSaleShoes();

            getEventClick();

        }else{
            checkconnect.ShowToast_Short(getApplicationContext(),"Bạn kiểm tra lại kết nối ");
            finish();
        }
    }

    private void getSale() {

        compositeDisposable.add(apiBanGiay.getSales()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        salesModel -> {
                            if (salesModel.isSuccess()){
                                salesList = salesModel.getResult();
                                if (!salesList.isEmpty()){
                                    List<Sales> ls= new ArrayList<>();
                                    Date date = new Date();
                                    for (int i=0;i<salesList.size();i++){
                                        if ( salesList.get(i).getStartday().before(date)&& salesList.get(i).getEndday().after(date)){
                                            ls.add(salesList.get(i));
                                        }
                                    }

                                    salesList=ls;
                                    o=salesList.size();
                                    SalePagerAdapter salePagerAdapter = new SalePagerAdapter(this,salesList);
                                    viewPager2Sale.setAdapter(salePagerAdapter);
                                    circleIndicator3.setViewPager(viewPager2Sale);


                                }else {
                                    o=0;
                                }

                            }
                            else {
                                o=0;
                            }
                        },
                        throwable -> {

                            Toast.makeText(getApplicationContext(), "Khong ket noi duoc voi server", Toast.LENGTH_LONG).show();
                        }
                ));
    }

    public void initUi() {
        //Sale
        viewPager2Sale= findViewById(R.id.viewpager2Sale);
        circleIndicator3= findViewById(R.id.indicatorSale);
        salesList = new ArrayList<>();
        //ProgessBar
        progressBarSaleMain = findViewById(R.id.progessbarSaleMain);
        progressBarSearchMain = findViewById(R.id.progessbarSearchMain);
        progressBarNewsShoesMain = findViewById(R.id.progessbarNewsShoesMain);
        //
        ToolbarManHinhChinh = findViewById(R.id.ToolbarManHinhChinh);
       // viewfliperManHinhChinh = findViewById(R.id.viewfliperManHinhChinh);
        ListviewManHinhChinh = findViewById(R.id.ListviewManHinhChinh);
        drawerlayoutManHinhChinh = findViewById(R.id.drawerlayoutManHinhChinh);
        //
        recyclerViewNewItems = findViewById(R.id.recyclerViewNewItems);
        RecyclerView.LayoutManager layoutManager = new androidx.recyclerview.widget.GridLayoutManager(this,2);
        recyclerViewNewItems.setLayoutManager(layoutManager);
        recyclerViewNewItems.setHasFixedSize(true);
        //
        recyclerViewFlashSaleShoes = findViewById(R.id.recyclerViewHotItems);
        recyclerViewFlashSaleShoes.setLayoutManager(new LinearLayoutManager(getApplicationContext(), LinearLayoutManager.HORIZONTAL,false));
        recyclerViewFlashSaleShoes.setHasFixedSize(true);
        //
        recyclerViewSearchHistory = findViewById(R.id.recyclerViewSearchHistory);
        recyclerViewSearchHistory.setLayoutManager(new LinearLayoutManager(getApplicationContext(), LinearLayoutManager.HORIZONTAL,false));
        recyclerViewSearchHistory.setHasFixedSize(true);
        //
        mangSanPham = new ArrayList<>();
        mangBrand = new ArrayList<>();
        shoesAdapter =new ShoesAdapter(getApplicationContext(),mangSanPham);
        recyclerViewNewItems.setAdapter(shoesAdapter);
        //
        imageViewHotItems = findViewById(R.id.imageViewHotItems);
        imageViewHotItems.setImageResource(R.drawable.flashsale);
        imageViewHotItems.setScaleType(ImageView.ScaleType.FIT_START);
        //
        txtflashsaleXemThem=findViewById(R.id.txt_flashsale_XemThem);
        txtTBLashSale=findViewById(R.id.txt_ThongbaoFlashSale);
        txtTBNewShoes=findViewById(R.id.txt_ThongbaoNewShoes);
        txt_ThongbaoSearhHistory = findViewById(R.id.txt_ThongbaoSearhHistory);
        icon_flashsale= findViewById(R.id.iconFlashsale);
        txtcountsp= findViewById(R.id.txtcountsp);

        if(Utils.manggiohang!=null){
            //badge.setText(String.valueOf(Utils.manggiohang.size()));
        }
        else {
            Utils.manggiohang = new ArrayList<>();
        }
        linearLayoutAdmin=findViewById(R.id.linearLayoutAdmin);
        if (com.example.shopsneaker.utils.Utils.user_current.getRolesid()==1 || com.example.shopsneaker.utils.Utils.user_current.getRolesid()==2){

            linearLayoutAdmin.setVisibility(View.VISIBLE);
        }else {
            linearLayoutAdmin.setVisibility(View.INVISIBLE);
        }
    }

    private void ActionBar(){
        setSupportActionBar(ToolbarManHinhChinh);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        ToolbarManHinhChinh.setNavigationIcon(android.R.drawable.ic_menu_sort_by_size);
        ToolbarManHinhChinh.setNavigationOnClickListener(v -> drawerlayoutManHinhChinh.openDrawer(GravityCompat.START));
    }

    /*private ArrayList<String> mangQuangCao(){
        ArrayList<String> mangQuangCao = new ArrayList<>();
        mangQuangCao.add(getString(R.string.anhQuangCao1));
        mangQuangCao.add(getString(R.string.anhQuangCao2));
        mangQuangCao.add(getString(R.string.anhQuangCao3));
        mangQuangCao.add(getString(R.string.anhQuangCao4));
        return mangQuangCao;
    }*/

    /*private void SetAnimationForViewFlipper(ViewFlipper viewFlipper){
        Animation slide_in_right = AnimationUtils.loadAnimation(this,R.anim.slide_in_right);
        Animation slide_out_right = AnimationUtils.loadAnimation(this,R.anim.slide_out_right);
        viewFlipper.setOutAnimation(slide_out_right);
        viewFlipper.setInAnimation(slide_in_right);
    }*/

   /* private float oldX,newX;
    private boolean checkTouch = false;
    @SuppressLint("ClickableViewAccessibility")
    private void TouchMoveForViewFlipper(final ViewFlipper viewFlipper){
        viewFlipper.setOnTouchListener((v, event) -> {

            if(event.getAction()==MotionEvent.ACTION_DOWN){
                oldX=event.getX();
                Log.d("touch", "down");
            }
            if(event.getAction()==MotionEvent.ACTION_UP){
                newX=event.getX();
                Log.d("touch", "up");
                checkTouch=true;
            }
            if(checkTouch==true){
                if(oldX<newX ){
                    if(viewFlipper.isAutoStart()){
                        viewFlipper.stopFlipping();
                        viewFlipper.showPrevious();
                        viewFlipper.startFlipping();
                        viewFlipper.setAutoStart(true);

                    }

                }else{
                    viewFlipper.stopFlipping();
                    viewFlipper.showNext();
                    viewFlipper.startFlipping();
                    viewFlipper.setAutoStart(true);
                }
                checkTouch=false;
                oldX = 0;
                newX = 0;
            }
            return true;
        });

    }*/

    /*private void ActionViewFlipper() {
        for(int i=0;i<this.mangQuangCao().size();i++){
            ImageView imageView = new ImageView(this);
            Picasso.get().load(this.mangQuangCao().get(i)).into(imageView);
            imageView.setScaleType(ImageView.ScaleType.FIT_XY);
            viewfliperManHinhChinh.addView(imageView);
        }
        viewfliperManHinhChinh.setFlipInterval(7000);
        viewfliperManHinhChinh.setAutoStart(true);
        this.SetAnimationForViewFlipper(viewfliperManHinhChinh);
        this.TouchMoveForViewFlipper(viewfliperManHinhChinh);

    }*/

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu,menu);
        SearchManager searchManager =(SearchManager) getSystemService(android.content.Context.SEARCH_SERVICE);
        searchView = (SearchView) menu.findItem(R.id.menuSearch).getActionView();
        searchView.setSearchableInfo(searchManager.getSearchableInfo(getComponentName()));
        searchView.setMaxWidth(Integer.MAX_VALUE);
        MenuItem item = menu.findItem(R.id.menuSearch);
        menu.findItem(R.id.menuSearch).setVisible(false);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()){
            case R.id.menugiohang:
                Intent intent =new Intent(getApplicationContext(),GioHangActivity.class);
                startActivity(intent);
                break;
            case R.id.profile:
                Intent intentLogout =new Intent(getApplicationContext(),ProfileActivity.class);
                startActivity(intentLogout);
                break;
        }
        return super.onOptionsItemSelected(item);
    }
    @Override
    public void onBackPressed() {
        if(drawerlayoutManHinhChinh.isDrawerOpen(GravityCompat.START)) drawerlayoutManHinhChinh.closeDrawer(GravityCompat.START);
        else super.onBackPressed();
    }

    private void getNewShoes() {
        progressBarNewsShoesMain.setVisibility(View.VISIBLE);
        txtTBNewShoes.setVisibility(View.INVISIBLE);
        compositeDisposable.add(apiBanGiay.getSanPhamMoi()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        sanPhamMoiModel -> {
                            if (sanPhamMoiModel.isSuccess()){
                                mangSanPham = sanPhamMoiModel.getResult();
                                if (!mangSanPham.isEmpty()){
                                    txtTBNewShoes.setVisibility(View.INVISIBLE);
                                    shoesAdapter = new com.example.shopsneaker.adapter.ShoesAdapter(getApplicationContext(),mangSanPham);
                                    recyclerViewNewItems.setAdapter(shoesAdapter);
                                    int countSP= mangSanPham.size();
                                    txtcountsp.setText("("+countSP+" sản phẩm)");
                                }else {
                                    txtTBNewShoes.setVisibility(View.VISIBLE);
                                }
                                progressBarNewsShoesMain.setVisibility(View.INVISIBLE);
                            }
                        },
                        throwable -> {
                            txtTBNewShoes.setVisibility(View.VISIBLE);
                            progressBarNewsShoesMain.setVisibility(View.INVISIBLE);
                            Toast.makeText(getApplicationContext(), "Khong ket noi duoc voi server", Toast.LENGTH_LONG).show();
                        }
                ));
    }

    private void getFlashSaleShoes() {
        progressBarSaleMain.setVisibility(View.VISIBLE);
        txtTBLashSale.setVisibility(View.INVISIBLE);
        compositeDisposable.add(apiBanGiay.getFlashSaleShoes()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        sanPhamMoiModel -> {
                            if (sanPhamMoiModel.isSuccess()){
                                mangSanPham = sanPhamMoiModel.getResult();
                                if (!mangSanPham.isEmpty()){
                                    flashSaleShoesAdapter = new com.example.shopsneaker.adapter.FlashSaleShoesAdapter(getApplicationContext(),mangSanPham);
                                    recyclerViewFlashSaleShoes.setAdapter(flashSaleShoesAdapter);
                                    txtTBLashSale.setVisibility(View.INVISIBLE);
                                }else {
                                    txtTBLashSale.setVisibility(View.VISIBLE);
                                }
                                progressBarSaleMain.setVisibility(View.INVISIBLE);


                            }
                        },
                        throwable -> {
                            Toast.makeText(getApplicationContext(),"Load Flash Sale Shoes That bai", Toast.LENGTH_LONG).show();
                            progressBarSaleMain.setVisibility(View.INVISIBLE);
                            txtTBLashSale.setVisibility(View.VISIBLE);
                        }
                ));
    }
    private void getSearchHistoryShoes() {
        int accountid = Utils.user_current.getAccountid();
        progressBarSearchMain.setVisibility(View.VISIBLE);
        txt_ThongbaoSearhHistory.setVisibility(View.INVISIBLE);
        compositeDisposable.add(apiBanGiay.getSearchHistoryShoes(accountid)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        sanPhamMoiModel -> {
                            if (sanPhamMoiModel.isSuccess()){
                                mangSanPham = sanPhamMoiModel.getResult();
                                if (!mangSanPham.isEmpty()){
                                    txt_ThongbaoSearhHistory.setVisibility(View.INVISIBLE);
                                    searchHistoryAdapter = new com.example.shopsneaker.adapter.SearchHistoryAdapter(getApplicationContext(),mangSanPham);
                                    recyclerViewSearchHistory.setAdapter(searchHistoryAdapter);
                                }else {
                                    txt_ThongbaoSearhHistory.setVisibility(View.VISIBLE);
                                }
                                progressBarSearchMain.setVisibility(View.INVISIBLE);
                            }
                        },
                        throwable -> {
                            progressBarSearchMain.setVisibility(View.INVISIBLE);
                            txt_ThongbaoSearhHistory.setVisibility(View.VISIBLE);
                        }
                ));
    }
    public void getBrand() {
        compositeDisposable.add(apiBanGiay.getBrand()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(
                        brandModel -> {
                            if(brandModel.isSuccess()){
                                mangBrand = brandModel.getResult();
                                mangBrand.add(0, new Brand(0,"Tất cả sản phẩm","",""));
                                mangBrand.add( mangBrand.size(),new Brand(0,"Liên hệ","Đây là trang lien he","https://sv3.anh365.com/images/2022/04/18/imaged7179bbdfb64d3a1.png"));
                                mangBrand.add(mangBrand.size(), new Brand(0,"MarketPlace","Đây là trang giao dịch","https://img.icons8.com/external-becris-flat-becris/344/external-market-business-world-becris-flat-becris.png"));
                                brandAdapter=new com.example.shopsneaker.adapter.BrandAdapter(getApplicationContext(),mangBrand);
                                ListviewManHinhChinh.setAdapter(brandAdapter);
                            }
                        },
                        throwable -> {
                            Toast.makeText(getApplicationContext(), "Khong ket noi duoc voi server", Toast.LENGTH_LONG).show();
                        }
                ));
    }



    private void getEventClick() {
        ListviewManHinhChinh.setOnItemClickListener((adapterView, view, i, l) -> {
            drawerlayoutManHinhChinh.closeDrawer(GravityCompat.START);
            if (i == 0 ) {
                Intent intent= new Intent(getApplicationContext(), ShoesActivity.class);
                Bundle bundle = new Bundle();
                Brand sv = new Brand (0,"Tất cả sản phẩm");
                bundle.putSerializable("KEY_SER_SV",  sv);
                intent.putExtras(bundle);
                id=0;
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                startActivity(intent);
            }else if (i== mangBrand.size()-1) {
                Intent intent = new android.content.Intent(getApplicationContext(), MarketPlaceActivity.class);
                startActivity(intent);
                drawerlayoutManHinhChinh.closeDrawer(GravityCompat.START);
            }else if (i== mangBrand.size()-2){
                Intent intent = new android.content.Intent(getApplicationContext(), ContactActivity.class);
                startActivity(intent);
            }
            else {
                Intent intent= new Intent(getApplicationContext(), ShoesActivity.class);
                Bundle bundle = new Bundle();
                Brand sv = new Brand (mangBrand.get(i).getBrandid(),mangBrand.get(i).getBrandname());
                bundle.putSerializable("KEY_SER_SV",  sv);
                intent.putExtras(bundle);
                id=mangBrand.get(i).getBrandid();
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                startActivity(intent);
            }
        });

        txtflashsaleXemThem.setOnClickListener(view -> {
            Intent intent = new Intent(getApplicationContext(),SaleShoesActivity.class);
            startActivity(intent);
        });
        linearLayoutAdmin.setOnClickListener(view -> {
            drawerlayoutManHinhChinh.closeDrawer(GravityCompat.START);
            Intent intent = new android.content.Intent(getApplicationContext(), AdminActivity.class);
            startActivity(intent);

        });
    }
}
