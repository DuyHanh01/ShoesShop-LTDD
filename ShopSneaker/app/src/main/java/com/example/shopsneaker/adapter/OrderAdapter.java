package com.example.shopsneaker.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.example.shopsneaker.R;
import com.example.shopsneaker.activity.OrderDetailsActivity;
import com.example.shopsneaker.model.Order;
import com.example.shopsneaker.utils.checkconnect;
import java.util.List;

public class OrderAdapter extends RecyclerView.Adapter<OrderAdapter.MyViewHolder> {
    Context context;
    List<Order> array;

    public OrderAdapter(Context context, List<Order> array) {
        this.context = context;
        this.array = array;
    }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int i) {
        View item = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_order, parent, false);
        return new OrderAdapter.MyViewHolder(item);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int i) {
        Order shoes = array.get(i);
        holder.textviewDate.setText("Ngày đặt: "+ shoes.getBookingdate());
        holder.textviewTotal.setText("Tổng tiền: " + shoes.getTotal() + "USD");
        holder.textviewOrderId.setText("Đơn đặt hàng: "+shoes.getOrderid());
        holder.textviewStatusId.setText("Tình trạng: "+shoes.getStatusname());
    }

    @Override
    public int getItemCount() {
        return array.size();
    }


    public class MyViewHolder extends RecyclerView.ViewHolder {
        public TextView textviewOrderId, textviewDate, textviewTotal, textviewStatusId;
        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            textviewOrderId = itemView.findViewById(R.id.textviewOrderId);
            textviewDate = itemView.findViewById(R.id.textviewDate);
            textviewTotal = itemView.findViewById(R.id.textviewTotal);
            textviewStatusId = itemView.findViewById(R.id.textviewStatusId);
            itemView.setOnClickListener(v -> {
                Intent intent=new Intent(context,OrderDetailsActivity.class);
                intent.putExtra("iddh", array.get(getAdapterPosition()).getOrderid());
                intent.putExtra("statusid", array.get(getAdapterPosition()).getStatusid());
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                checkconnect.ShowToast_Short(context,array.get(getAdapterPosition()).getOrderid().toString());
                context.startActivity(intent);
            });
        }
    }
}
