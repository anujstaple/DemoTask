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

         $user = Auth::user();
         $products = Product::select('products.id','products.title','products.status','user_product.qty','user_product.price','user_product.product_id','user_product.user_id')->leftjoin('user_product',function($join)  use ($user)
        {
            
           $join->on('products.id', '=', 'user_product.product_id')->where('user_product.user_id',$user->id);
        })
         ->orderBy('products.id', 'ASC')
         ->get();
         $error =[];
        return view('productlist',compact('products','error'));
    }


      public function attachedProduct(Request $request)
    {

        $request->validate(['qty'=>'required','id'=>'required','price'=>'required']);
           $user = Auth::user();
           $product = Product::find($request->id);

           if($request->qty == 0){
             return redirect('/productlist')->with('error','Please add quantity.');
           }

       
       
           $count  = UserProduct::where('user_id',$user->id)->where('product_id',$request->id)->count();
           if($product && $count ==0){

            UserProduct::create(['user_id'=>$user->id,'product_id'=>$request->id,'qty'=>$request->qty,'price'=>$request->price,'status'=>$product->status]);

           return redirect('/productlist')->with('success','Product Attached.');
         

           } elseif ($product && $count >0) {

            
            UserProduct::where('user_id',$user->id)->where('product_id',$request->id)->update(['qty'=>$request->qty,'price'=>$request->price,'status'=>$product->status]);
            
            return redirect('/productlist')->with('success','Attached Product updated.');
         
           }

           return redirect('/productlist');

          

           
           
        
    }
}
