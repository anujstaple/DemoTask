@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
<br><br>
                <div> Currency Change
                  <form method="post" action="{{route('admin_dashborad')}}">
                    @csrf
                    <select name="currency_code" onchange="this.form.submit()">

                        <option value="">Please Select Currency</option>
                         <option value="EURO" {{request('currency_code')== 'EURO' ? 'selected' : '' }}> Default EURO</option>

                        <option value="USD" {{request('currency_code')== 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="RON" {{request('currency_code')== 'RON' ? 'selected' : '' }}>RON</option>
                    </select>
                      

                  </form>  

                </div>
                <br><br>

                <div class="card-body">

                   
<div>All Active: {{ $totals->active }}</div><br>
<div>All Verified: {{ $totals->verified }}</div><br>
<div>All deactive: {{ $totals->deactive }}</div><br>

<div>Total Active Product: {{ $CountactiveProduct }}</div><br>
<div>Count of active and verified users who have attached active products: {{ $CountactiveVerifiedAttachUser }}</div><br>

<div>Total Active Product without attached user: {{ $CountactiveProduct_withoutAttach }}</div><br>

<div>Total count qty of all active attached products: {{ $AmountactiveAttachedProduct }}</div><br>

<div>Price of all active attached products: {{$symbol}} {{ $PriceActiveAttachedProduct }}</div>

<br><br>
   <table>
  <tr>
  <th>User Name</th><th>Product</th><th>Product Qty</th>
                    <th>Total Amount</th>
                   
  </tr>
                    @if($userSummarizedPrice)
                    @foreach($userSummarizedPrice as $val)
                    
                    <tr> <td>{{$val->name}}</td>
                        <td>{{$val->title}}</td>
                        <td> {{$val->qty}}</td>
                        
                         <td> {{$symbol}} {{round($val->totalAmount,2)}}</td>
                      
                       
                       

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
