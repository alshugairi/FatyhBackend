@section('title'){{ !blank($product->meta_title) ? $product->meta_title : $product->name }} - {{ get_setting('company_name', 'Shopifyze') }}@endsection

@section('meta')
    <meta name="description" content="{{ !blank($product->meta_description) ? $product->meta_description : str_limit(strip_tags($product->description), 160) }}">
    <meta name="keywords" content="{{ is_array($product->meta_keywords) ? implode(', ', $product->meta_keywords) : $product->meta_keywords }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ !blank($product->meta_title) ? $product->meta_title : $product->name }}">
    <meta property="og:description" content="{{ !blank($product->meta_description) ? $product->meta_description : str_limit(strip_tags($product->description), 160) }}">
    @if($product->defaultImage)
        <meta property="og:image" content="{{ get_full_image_url($product->defaultImage->image_path) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="product">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ !blank($product->meta_title) ? $product->meta_title : $product->name }}">
    <meta property="twitter:description" content="{{ !blank($product->meta_description) ? $product->meta_description : str_limit(strip_tags($product->description), 160) }}">
    @if($product->defaultImage)
        <meta property="twitter:image" content="{{ get_full_image_url($product->defaultImage->image_path) }}">
    @endif

    <!-- Product specific -->
    <meta property="product:price:amount" content="{{ $product->sell_price }}">
    <meta property="product:price:currency" content="{{ default_currency()->symbol }}">
    @if($product->stock_quantity > 0)
        <meta property="product:availability" content="in stock">
    @else
        <meta property="product:availability" content="out of stock">
    @endif

    <!-- JSON-LD Schema Markup -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "{{ $product->name }}",
            "description": "{{ str_limit(strip_tags($product->description), 160) }}",
            "image": "{{ $product->defaultImage ? get_full_image_url($product->defaultImage->image_path) : '' }}",
            "sku": "{{ $product->sku }}",
            "brand": {
                "@type": "Brand",
                "name": "{{ $product->brand ? $product->brand->name : get_setting('company_name', 'Shopifyze') }}"
            },
            "offers": {
                "@type": "Offer",
                "url": "{{ url()->current() }}",
                "priceCurrency": "{{ default_currency()->symbol }}",
                "price": "{{ $product->sell_price }}",
                "availability": "{{ $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ $product->rating }}",
                "reviewCount": "{{ $product->reviewsCount() }}"
            }
        }
    </script>
@endsection
