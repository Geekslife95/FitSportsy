<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductOrder;
class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $search = $request->search;
        $productData = ProductOrder::select('id','app_user_id','order_u_id','pay_type','payment_id','total_paid','payment_status','status','created_at')
                                    ->with('user:id,name,last_name');
        if(!empty($request->search)){
            $search = $request->search;
            $productData = $productData->where('order_u_id','like','%'.$request->search.'%')
                                        ->orWhere('payment_id','like','%'.$request->search.'%')
                                        ->orwhereHas('user',function($a) use($search){
                                            $a->where('name', 'LIKE', '%' . $search . '%');
                                            $a->orwhere('last_name', 'LIKE', '%' . $search . '%');
                                        });
        }
        $productData  = $productData->orderBy('status')->paginate(50);
        return view('admin.product.product-orders',compact('productData'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
