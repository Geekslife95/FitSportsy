<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderDetail;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Session;
use Common,Auth;
use stdClass;

class ProductsController extends Controller
{
    public function productDetails($slug){
        $productdata = Product::where('product_slug',$slug)->first();
        $desctSubstr = substr(strip_tags($productdata->description),0,200);
        $imgOg = $productdata->image;
        SEOTools::setTitle($productdata->product_name);
        SEOTools::setDescription($desctSubstr);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $productdata->product_name
        ]);
        SEOTools::jsonLd()->addImage(asset('images/upload/'. $imgOg));

        OpenGraph::setTitle($productdata->product_name)
        ->setDescription($desctSubstr)
        ->setUrl(url()->current())
        ->addImage(asset('images/upload/'. $imgOg));

        return view("frontend.product.product-details",compact('productdata'));
    }

    public function buyProduct(Request $request , $slug){
        $productData = [];
        if(Session::has('CART_DATA_BMJ')){
            $productData = json_decode(Session::get('CART_DATA_BMJ'),true);
        }
        
        $productdata = Product::select('id','quantity')->where('product_slug',$slug)->first();
        $total = 0;
        $status = 0;
        if($productdata){
            $productData[$productdata->id] = isset($productData[$productdata->id]) ? $productData[$productdata->id] + 1 : 1;
            // array_push($productData,$productdata->id);
            if($productData[$productdata->id] <= $productdata->quantity){
                Session::put('CART_DATA_BMJ',json_encode($productData));
                $total = count(array_keys($productData));
                $status = 1;
            }
        }

        if($request->ajax()){
            return response()->json(['s'=>$status,'total'=>$total]);
        }

        return redirect('my-cart');
    }

    public function myCart(){
        $cartData = [];
        $productArr = [];
        if(Session::has('CART_DATA_BMJ')){
            $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
            $ids = array_keys($productArr);
            $cartData = Product::select('id','product_name','image','quantity','product_price','product_slug')->whereIn('id',$ids)->where('status',1)->get();
        }
        return view('frontend.product.my-cart',compact('cartData','productArr'));
    }

    public function removeFromCart(){
        $id = $this->memberObj['id'];
        if(Session::has('CART_DATA_BMJ')){
            $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
            unset($productArr[$id]);
            if(!empty($productArr)){
                Session::put('CART_DATA_BMJ',json_encode($productArr));
            }else{
                Session::forget('CART_DATA_BMJ');
            }
            
        }
        return redirect('my-cart');
    }

    public function addQuantityToCart(Request $request){
        $id = $this->memberObj['id'];
        $quantity = $request->count > 0 ? $request->count : 0;
        if(Session::has('CART_DATA_BMJ')){
            $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
            $productArr[$id] = $quantity;
            Session::put('CART_DATA_BMJ',json_encode($productArr));
            $ids = array_keys($productArr);
            $cartData = Product::select('id','product_price')->whereIn('id',$ids)->where('status',1)->get();
            $subTotal = 0;$shipping_charge = Common::shippingCharge();$grandTotal = 0;
            foreach($cartData as $item){
                $priceT = $item->product_price * ($productArr[$item->id]);
                $subTotal+=$priceT;
            }
            $grandTotal = $subTotal + $shipping_charge;
            $subTotal = round($subTotal,2);
            $grandTotal = round($grandTotal,2);
            return response()->json(['s'=>1,'sub_total'=>$subTotal,'shipping_charge'=>$shipping_charge,'grand_total'=>$grandTotal]);
        }
        return response()->json(['s'=>1,'msg'=>"invalid input"]);
    }

    public function cartCheckout(){
        if(\Auth::guard('appuser')->check()==false){
            Session::put('LAST_URL_VISITED',url('cart-checkout'));
            return redirect('user-login')->with('warning','Login or register with your account to proceed checkout');
        }
        Session::forget('LAST_URL_VISITED');
        $cartData = [];
        $productArr = [];
        if(Session::has('CART_DATA_BMJ')){
            $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
            $ids = array_keys($productArr);
            $cartData = Product::select('id','product_name','image','quantity','product_price')->whereIn('id',$ids)->where('status',1)->get();
            if(count($cartData)==0){
                return redirect('my-cart');
            }
        }else{
            return redirect('my-cart');
        }
        return view('frontend.product.cart-checkout',compact('cartData','productArr'));
    }

    public function get_curl_handle($razorpay_payment_id, $amount, $currency_code){
        $settingData = Common::paymentKeysAll();
        $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id . '/capture';
        $key_id = $settingData->razorPublishKey;
        $key_secret = $settingData->razorSecretKey;
        $arr = array(
            'amount' => $amount,
            'currency' => $currency_code
        );
        $arr1 = json_encode($arr);
        $fields_string = $arr1;
        $ch = curl_init();
       //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        return $ch;
    }

    public function getRzrTotalProductPay(){
        $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
        $ids = array_keys($productArr);
        $cartData = Product::select('id','product_price')->whereIn('id',$ids)->where('status',1)->get();
        $subTotal = 0;$shipping_charge = Common::shippingCharge();$grandTotal = 0;
        foreach($cartData as $item){
            $priceT = $item->product_price * ($productArr[$item->id]);
            $subTotal+=$priceT;
        }
        $grandTotal = $subTotal + $shipping_charge;
        $grandTotal = round($grandTotal,2);
        return response()->json(['s'=>1,'amount'=>$grandTotal]);
    }

    public function storePaymentDetails(Request $request){
        $shippinData  = [
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'address_two'=>$request->address_two,
            'state'=>$request->state,
            'city'=>$request->city,
            'pin_code'=>$request->pin_code,
        ];
        $merchant_order_id = $request->merchant_order_id;
        if($request->pay_type==1){
            if(!empty($request->razorpay_payment_id) && !empty($request->merchant_order_id)){
                $razorpay_payment_id = $request->razorpay_payment_id;
                $currency_code = $request->currency_code;
                $amount = $request->merchant_total;
                
                $success = false;
                $error = '';
                try{
                    $ch = $this->get_curl_handle($razorpay_payment_id, $amount, $currency_code);
                    $result = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($result === false){
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                    }else{
                        $response_array = json_decode($result, true);
                        if ($http_status === 200 and isset($response_array['error']) === false){
                            $success = true;
                        }else{
                            $success = false;
                            if (!empty($response_array['error']['code'])){
                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            }else{
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }
                    curl_close($ch);
                }catch(\Exception $e){
                    $success = false;
                    $error = 'OPENCART_ERROR:Request to Razorpay Failed';
                }
                if ($success === true){
                    $orderId = $this->saveToOrder($merchant_order_id,$shippinData,$razorpay_payment_id,"Razorpay","Paid");
                    $inputObj = new stdClass();
                    $inputObj->url = url('user-order-details');
                    $inputObj->params = 'order_id='.$orderId;
                    $encLink = Common::encryptLink($inputObj);
                    return redirect($encLink)->with('success','Order Placed Successfully...Order will be delivered to your shipping address');
                }else{
                    return redirect($request->merchant_furl_id);
                }
            }
        }else{
            $razorpay_payment_id = 'cod_'.substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),1,3).rand(111,999);
            $orderId = $this->saveToOrder($merchant_order_id,$shippinData,$razorpay_payment_id,"COD","Pending");
            $inputObj = new stdClass();
            $inputObj->url = url('user-order-details');
            $inputObj->params = 'order_id='.$orderId;
            $encLink = Common::encryptLink($inputObj);
            return redirect($encLink)->with('success','Order Placed Successfully...Order will be delivered to your shipping address');
        }
    }

    public function saveToOrder($merchant_order_id,$shippinData,$razorpay_payment_id,$type,$status){
        $userId = Auth::guard('appuser')->user()->id;
        $today =date("Y-m-d H:i:s");
        $productArr = json_decode(Session::get('CART_DATA_BMJ'),true);
        $ids = array_keys($productArr);
        $cartData = Product::select('id','product_price')->whereIn('id',$ids)->where('status',1)->get();
        $subTotal = 0;$shipping_charge = Common::shippingCharge();$grandTotal = 0;
        $insData = [];
        $orderId = ProductOrder::insertGetId([
            'order_u_id'=>$merchant_order_id,
            'app_user_id'=>$userId,
            'pay_type'=>$type,
            'shipping_details'=>json_encode($shippinData),
            'payment_id'=>$razorpay_payment_id,
            'total_paid'=>0,
            'payment_status'=>$status,
            'status'=>'Pending',
            'created_at'=>$today,
            'updated_at'=>$today,
            'delivery_charge'=>$shipping_charge
        ]);
        foreach($cartData as $item){
            $priceT = $item->product_price * ($productArr[$item->id]);
            $subTotal+=$priceT;
            $insData[] = [
                'product_order_id'=>$orderId,
                'product_id'=>$item->id,
                'quantity'=>$productArr[$item->id],
                'unit_price'=>$item->product_price,
                'total_price'=>round($priceT),
                'created_at'=>$today,
                'updated_at'=>$today,
            ];
        }
        $grandTotal = $subTotal + $shipping_charge;
        ProductOrderDetail::insert($insData);
        ProductOrder::where('id',$orderId)->update(['total_paid'=>$grandTotal]);
        Session::forget('CART_DATA_BMJ');
        return $orderId;
    }

    public function userOrderDetails(){
        $orderId = $this->memberObj['order_id'];
        $orderData = ProductOrder::select('id','order_u_id','pay_type','shipping_details','payment_id','total_paid','payment_status','status','delivery_charge')->with('order_details:id,product_order_id,quantity,unit_price,total_price,product_id')->findorfail($orderId);
        return view('frontend.product.user-order-details',compact('orderData'));
    }

    public function myOrders(){
        $userId = Auth::guard('appuser')->user()->id;
        $orderData = ProductOrder::select('id','order_u_id','pay_type','payment_id','total_paid','payment_status','status')->where('app_user_id',$userId)->paginate(50);
        return view('frontend.product.my-orders',compact('orderData'));
    }


}
