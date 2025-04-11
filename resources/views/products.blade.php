<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Product List</h1>

        <a href="/fetch-products" class="btn btn-primary mb-4">Fetch Products</a>

        <div id="product-list" class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4 product-item">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="text-muted">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Initialize Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        // Subscribe to the channel
        const channel = pusher.subscribe('products');

        // Listen for the event
        channel.bind('product.updated', function(data) {
            // Fetch updated products
            fetch('/')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProductList = doc.getElementById('product-list').innerHTML;
                    document.getElementById('product-list').innerHTML = newProductList;
                });
        });
    </script>
</body>
</html>
