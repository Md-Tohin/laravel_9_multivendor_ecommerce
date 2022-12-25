@php
use App\Models\ProductsFilter;
$productFilters = ProductsFilter::productFilters();
@endphp
<script>
    $(document).ready(function() {
        //  Sort By Filter
        $("#sort").on("change", function() {
            // this.form.submit();
            var brand = get_filter('brand');
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            // alert(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'Post',
                data: {
                    brand: brand,
                    price: price,
                    color: color,
                    size: size,
                    sort: sort,
                    url: url,
                    @foreach ($productFilters as $filters)
                        {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                },
                success: function(data) {
                    $(".filter_products").html(data);
                },
                error: function() {
                    alert("Error");
                }

            });
        });

        //  Size By Filter
        $(".size").on("change", function() {
            // this.form.submit();
            var brand = get_filter('brand');
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            // alert(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'Post',
                data: {
                    brand: brand,
                    price: price,
                    color: color,
                    size: size,
                    sort: sort,
                    url: url,
                    @foreach ($productFilters as $filters)
                        {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                },
                success: function(data) {
                    $(".filter_products").html(data);
                },
                error: function() {
                    alert("Error");
                }

            });
        });

        //  Color By Filter
        $(".color").on("change", function() {
            // this.form.submit();
            var brand = get_filter('brand');
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            // alert(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'Post',
                data: {
                    brand: brand,
                    price: price,
                    color: color,
                    size: size,
                    sort: sort,
                    url: url,
                    @foreach ($productFilters as $filters)
                        {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                },
                success: function(data) {
                    $(".filter_products").html(data);
                },
                error: function() {
                    alert("Error");
                }

            });
        });

        //  Brand By Filter
        $(".brand").on("change", function() {
            // this.form.submit();
            var brand = get_filter('brand');
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var sort = $("#sort").val();
            var url = $("#url").val();            
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            // alert(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'Post',
                data: {
                    brand: brand,
                    price: price,
                    color: color,
                    size: size,
                    sort: sort,
                    url: url,
                    @foreach ($productFilters as $filters)
                        {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                },
                success: function(data) {
                    $(".filter_products").html(data);
                },
                error: function() {
                    alert("Error");
                }

            });
        });

        //  Price By Filter
        $(".price").on("change", function() {
            // this.form.submit();
            var brand = get_filter('brand');
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var sort = $("#sort").val();            
            var url = $("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            // alert(sort);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'Post',
                data: {
                    brand: brand,
                    price: price,
                    color: color,
                    size: size,
                    sort: sort,
                    url: url,
                    @foreach ($productFilters as $filters)
                        {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                    @endforeach
                },
                success: function(data) {
                    $(".filter_products").html(data);
                },
                error: function() {
                    alert("Error");
                }

            });
        });

        //  Dynamic Filter
        @foreach ($productFilters as $filter)
            $('.{{ $filter['filter_column'] }}').on('click', function() {
                var brand = get_filter('brand');
                var price = get_filter('price');
                var color = get_filter('color');
                var size = get_filter('size');
                var url = $("#url").val();
                var sort = $("#sort option:selected").val();
                @foreach ($productFilters as $filters)
                    var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
                @endforeach
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    method: 'Post',
                    data: {
                        brand: brand,
                        price: price,
                        color: color,
                        size: size,
                        sort: sort,
                        url: url,
                        @foreach ($productFilters as $filters)
                            {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
                        @endforeach
                    },
                    success: function(data) {
                        $(".filter_products").html(data);
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            });
        @endforeach

    });
</script>
