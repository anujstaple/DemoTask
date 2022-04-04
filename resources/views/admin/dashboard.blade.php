@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                   
<div>All Active: {{ $totals->active }}</div>
<div>All Verified: {{ $totals->verified }}</div>
<div>All deactive: {{ $totals->deactive }}</div>

<div>Total Active Product: {{ $CountactiveProduct }}</div>
<div>Count of active and verified users who have attached active products: {{ $CountactiveVerifiedAttachUser }}</div>

<div>Total Active Product without attached user: {{ $CountactiveProduct_withoutAttach }}</div>

<div>Total count qty of all active attached products: {{ $AmountactiveAttachedProduct }}</div>

<div>Price of all active attached products: {{ $PriceActiveAttachedProduct }}</div>


   <table>
  <tr>
  <th>User Name</th><th>Product</th><th>Product Qty</th><th>Product price</th>
                    <th>Total Amount</th>
                   
  </tr>
                    @if($userSummarizedPrice)
                    @foreach($userSummarizedPrice as $val)
                    
                    <tr> <td>{{$val->name}}</td>
                        <td>{{$val->title}}</td>
                        <td> {{$val->qty}}</td>
                        <td> {{$val->price}}</td>
                         <td> {{$val->totalAmount}}</td>
                      
                       
                       

                    </tr>
                  

                   
                     @endforeach
                     @endif
   
</table>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
