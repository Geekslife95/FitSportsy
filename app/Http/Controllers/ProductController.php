<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // create permissions add_product,edit_product,delete_product;
        // $permission = Permission::create(['name' => 'add_product']);
        // $permission = Permission::create(['name' => 'edit_product']);
        // $permission = Permission::create(['name' => 'delete_product']);
        // $role->syncPermissions(['add_product','edit_product','delete_product']);
        abort_if(Gate::denies('add_product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $productData = Product::select("id","product_name","product_price","image","quantity","rating","status");
        $search = '';
        if(!empty($request->search)){
            $productData->where("product_name",'like','%'.$request->search.'%');
            $search  = $request->search;
        }
        $productData = $productData->orderBy('status','DESC')->paginate(50);
        return view('admin.product.index',compact("productData",'search')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'bail|required',
            'product_price' => 'bail|required',
            'quantity' => 'bail|required',
        ]);
        $data = $request->all();
        $slug = \Str::slug($request->product_name, '-');
        $checkSlugExist = Product::where('product_slug',$slug)->count();
        if($checkSlugExist){
            $slug = $slug.'-'.($checkSlugExist + 1);
        }
        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $data['product_slug'] = $slug;
        Product::create($data);
        return redirect()->route('products.index')->withStatus(__('Product has added successfully.'));
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
    public function edit(Product $product)
    {
       return view('admin.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new AppHelper)->deleteFile($product->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        Product::find($product->id)->update( $data);
        return redirect()->route('products.index')->withStatus(__('Product has updated successfully.'));
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

    public function changePaymentStatus(Request $request){
        abort_if(Gate::denies('add_product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = $request->status;
        $id = $this->memberObj['id'];
        ProductOrder::where('id',$id)->update(['payment_status'=>$status]);
        return response()->json(['s'=>1]);
    }

    public function changeDeliveryStatus(Request $request){
        abort_if(Gate::denies('add_product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = $request->status;
        $id = $this->memberObj['id'];
        ProductOrder::where('id',$id)->update(['status'=>$status]);
        return response()->json(['s'=>1]);
    }

    public function viewOrderDetails(){
        $orderId = $this->memberObj['id'];
        $orderData = ProductOrder::select('id','order_u_id','pay_type','shipping_details','payment_id','total_paid','payment_status','status','delivery_charge')->with('order_details:id,product_order_id,quantity,unit_price,total_price,product_id')->findorfail($orderId);
        return view('admin.product.order-details',compact('orderData'));
    }

    public function allProducts(){
        $products = Product::select('image','product_name','product_price','rating','product_slug','quantity')->where('status',1)->inRandomOrder()->paginate(50);
        return view("all-products",compact('products'));
    }

}
