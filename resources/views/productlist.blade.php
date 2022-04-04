@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Products List') }}</div>

                @if(session()->has('error'))
                  <p style="color: red">  {{session()->get('error')}}</p>
               @endif

   @if(session()->has('success'))
                  <p style="color: green">  {{session()->get('success')}}</p>
               @endif


             <table>
  <tr>
  <th>Name</th><th>Price</th>
                    <th>Add quantity</th>
                    <th>Action</th>
  </tr>
                    @if($products)
                    @foreach($products as $pro)
                    <form action="{{route('attached')}}" method="post">
                        @csrf
                    <tr> <td>{{$pro->title}}</td>
                        <td> {{$pro->price}}</td>
                        <td> <input type="number" name="qty" min="1"></td>

                        <input type="hidden" name="id" value="{{$pro->id}}">

                        <td><input type="submit" name="submit" value="attach"></td>

                        </form>

                    </tr>
                  

                   
                     @endforeach
                     @endif
   
</table>


                   
               
            </div>
        </div>
    </div>
</div>
@endsection
