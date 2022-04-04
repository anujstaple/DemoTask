<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserProduct;
use Auth;
class HomeController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }



     public function productlist()
    {
         $products = Product::get();
         $error =[];
        return view('productlist',compact('products','error'));
    }


      public function attachedProduct(Request $request)
    {



           $request->validate(['qty'=>'required','id'=>'required']);
           $user = Auth::user();
           $product = Product::find($request->id);

       
         if($product->total_qty >= $request->qty){


           $count  = UserProduct::where('user_id',$user->id)->where('product_id',$request->id)->count();
           if($product && $count ==0){

            UserProduct::create(['user_id'=>$user->id,'product_id'=>$request->id,'qty'=>$request->qty,'status'=>$product->status]);

           $total_qty = $product->total_qty-$request->qty;

           $product->total_qty = $total_qty;
           $product->save();

           } elseif ($product && $count >0) {

            $UserProduct  = UserProduct::where('user_id',$user->id)->where('product_id',$request->id)->first();
            $qty = $UserProduct->qty+$request->qty;
           
            UserProduct::where('user_id',$user->id)->where('product_id',$request->id)->update(['qty'=>$qty]);
             $product->total_qty = $qty;

              $product->save();

           }
          return redirect('/productlist')->with('success','Product Attached.');;
         }else{

          return  redirect('/productlist')->with('error','Product stock not availble.');
         }

           
           
        
    }
}
