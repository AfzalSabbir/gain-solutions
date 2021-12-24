@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Product Title</th>
            <th>Category</th>
            <th>Variants</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->title}}</td>
                <td>{{$product->category->title}}</td>
                <td>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Barcode</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->productVariants as $productVariant)
                            <tr>
                                <td>{{$productVariant->sku}}</td>
                                <td>{{$productVariant->barcode}}</td>
                                <td>{{$productVariant->price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$products->links()}}
</div>
@endsection
