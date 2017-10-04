<div class="alert alert-warning" style="margin-top: 20px">
    <strong>Product Details</strong>
    <div>
        <strong>Full Name: </strong>{{ $product->name }}
    </div>
    <div>
        <strong>Short Name: </strong>{{ $product->short_name }}
    </div>
    <div>
        <strong>Category: </strong>{{ $product->category->name }}
    </div>
    <div>
        <strong>Price: </strong>
        <div>
            {!! $product->price_long !!}
        </div>
    </div>
</div>
