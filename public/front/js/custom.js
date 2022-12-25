$(document).ready(function () {

    $("#getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product_id");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/get-product-price",
            data: { size: size, product_id: product_id },
            type: "post",
            success: function (resp) {
                // alert(resp);
                if (resp["discount"] > 0) {
                    $(".getAttributePrice").html(`
                        <div class="price">
                            <h4 style="font-weight: 700">Tk. ${resp["final_price"]} </h4>
                        </div>
                        <div style="font-size: 12px" class="original-price">
                            <span>Original Price:</span>
                            <del>Tk. ${resp["product_price"]}</del>
                        </div>
                    `);
                } else {
                    $(".getAttributePrice").html(
                        `<div class="price"><h4 style="font-weight: 700">Tk. ${resp["final_price"]} </h4></div>`
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //  Update Cart Items Qty
    $(document).on('click', '.updateCartItem', function () {
        //  Get Qty 
        // var quantity = $(this).data('qty');

        if ($(this).hasClass('plus-a')) {
            //  Get Qty 
            var quantity = $(this).data('qty');
            //  Increase the qty by 1
            var new_qty = parseInt(quantity) + 1;
            // alert(new_qty);
        }
        if ($(this).hasClass('minus-a')) {
            //  Get Qty 
            var quantity = $(this).data('qty');
            if (quantity <= 1) {
                alert('Item quantity must be 1 or greater!')
                return false;
            }
            //  Decrease the qty by 1
            var new_qty = parseInt(quantity) - 1;
            // alert(new_qty);
        }

        var cartid = $(this).data('cartid');
        // alert(cartid);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { cartid: cartid, qty: new_qty },
            type: 'POST',
            url: '/cart/update',
            success: function (resp) {
                if (resp.status == false) {
                    alert(resp.message);
                }
                $('#appendCartItems').html(resp.view)
            },
            error: function () {
                alert('Error');
            },
        });
    });

    //  Delete Cart Item 
    $(document).on('click', '.deleteCartItem', function () {
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this Cart Item?");
        if (result) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: { cartid: cartid },
                type: 'POST',
                url: '/cart/delete',
                success: function (resp) {
                    $('#appendCartItems').html(resp.view);
                },
                error: function () {
                    alert('Error');
                },
            });    
        }
    });

    //  Register Form Validation 
    $('#userRegistrationForm').submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/register',
            type: 'POST',
            data: formdata,
            success: function(resp){
                // alert(resp);
                if (resp.type == 'error') {
                    $.each(resp.errors, function(i, error){
                        $("#register-"+i).attr('style', 'color:red');
                        $("#register-"+i).html(error);
                        setTimeout(function(){
                            $('#register-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                if (resp.type == 'success') {
                    window.location.href = resp.url;                    
                }
            },
            error: function () {
                alert('Error');
            }       

        });
    });
        


});

function get_filter(class_name) {
    var filter = [];
    $("." + class_name + ":checked").each(function () {
        filter.push($(this).val());
    });
    return filter;
}
