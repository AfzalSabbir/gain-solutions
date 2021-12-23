<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

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
</div>

</body>
</html>
