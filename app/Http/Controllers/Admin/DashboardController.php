<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use DB;
use App\Models\UserProduct;
use Helper;
class DashboardController extends Controller
{

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    
    {
        $this->middleware(['auth','admin']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
           
         //Count of all active and verified users.
          $totals = User::selectRaw("count(case when status = 'active' then 1 end) as active")
            ->selectRaw("count(case when email_verified_at  != '' then 1 end) as verified")
            ->selectRaw("count(case when status = 'deactive' then 1 end) as deactive")
         
            ->where('role','user')
            ->first();


           //Count of all active products
            $CountactiveProduct = Product::where('status','active')->count();

            $UserProducts = UserProduct::select('product_id','user_id')->where('status','active')->get();

             $PrIds=[];
            $userIds=[];

            if($UserProducts){
                foreach ($UserProducts as $key => $pro) {
                    $PrIds[]=$pro->product_id;
                    $userIds[]=$pro->user_id;
                }
            }

            //Count of active and verified users who have attached active products.

            $CountactiveVerifiedAttachUser =  User::where('status','active')->whereNotNull('email_verified_at')->whereIn('id',[$userIds])->count();
             


           // Count of active products which don't belong to any user.

              if($PrIds){
                $CountactiveProduct_withoutAttach = Product::where('status','active')->whereNotIn('id',[$PrIds])->count();
             }

             //Amount of all active attached products 

             $AmountactiveAttachedProduct = UserProduct::select('products.price','products.id as product_id','user_product.qty','products.status')
             ->join('products','products.id','=','user_product.product_id')->where('products.status','active')->sum(DB::raw('user_product.qty'));



            // Currency update rate
             $symbol ="€";
             $currencyPrice =1; // Defualt price of euro

             if(isset($request->currency_code) && $request->currency_code !=''){

                if($request->currency_code == 'RON'){
                    $symbol ="lei";
                }
                if($request->currency_code == 'USD'){
                    $symbol ="$";
                }

               if($request->currency_code != 'EURO'){
                $rate = Helper::exchange_rates($request->currency_code);
                $currencyPrice = $rate;
                 }

             }
            

            
            //Summarized price of all active attached products (from the previous subpoint if prod1 price is 100$, prod2 price is 120$, prod3 price is 200$, the summarized price will be 3 x 100 + 9 x 120 = 1380).

             $PriceActiveAttachedProduct = UserProduct::select('products.price','products.id as product_id','user_product.qty','products.status')
             ->join('products','products.id','=','user_product.product_id')->where('products.status','active')->sum(DB::raw('products.price * user_product.qty * '.$currencyPrice));

             $PriceActiveAttachedProduct  = round($PriceActiveAttachedProduct,2);


            // Summarized prices of all active products per user. For example - John Summer - 85$, Lennon Green - 107$.

              $userSummarizedPrice = UserProduct::select('products.price','products.title','products.id as product_id','user_product.qty','products.status','users.id as user_id','users.name',DB::raw('products.price * user_product.qty * '.$currencyPrice.' as totalAmount'))
             ->join('products','products.id','=','user_product.product_id')
              ->join('users','users.id','=','user_product.user_id')
             ->where('products.status','active')->get();

            
      return view('admin.dashboard', compact('totals','CountactiveProduct','CountactiveVerifiedAttachUser','CountactiveProduct_withoutAttach','AmountactiveAttachedProduct','PriceActiveAttachedProduct','userSummarizedPrice','symbol'));
    }

   
}
