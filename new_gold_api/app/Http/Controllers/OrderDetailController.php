<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    public function fetchingDetails(Request $request)
    {
        $data=OrderDetail::select('order_details.status_id','order_details.material_id','order_details.id','order_details.order_master_id','order_details.price','order_details.size','order_details.approx_gold','order_details.p_loss','order_details.quantity','products.model_number',DB::raw("price_codes.price_code_name as price_code"),DB::raw("products.id as product_id"),DB::raw("order_details.quantity * order_details.price as  amount"))
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('price_codes', 'price_codes.id', '=', 'products.price_code_id')
//            ->join('rates', 'rates.price_code_id', '=', 'price_codes.id')
            ->where('order_master_id',$request->input('orderMasterId'))
            ->get();
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }


    public function deleteOrder($id)
    {
        $orderDetail = new OrderDetail();
        $orderDetail = OrderDetail::find($id);
        $orderDetail->delete();
        return response()->json(['success'=>1,'data'=>$orderDetail], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
}
