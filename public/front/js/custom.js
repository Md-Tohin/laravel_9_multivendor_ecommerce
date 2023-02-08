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
                $('.totalCartItems').html(resp.totalCartItems);
                if (resp.status == false) {
                    alert(resp.message);
                }
                $('#appendCartItems').html(resp.view);
                $('#appendHeaderCartItems').html(resp.headerView);
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
                    $('.totalCartItems').html(resp.totalCartItems);
                    $('#appendHeaderCartItems').html(resp.headerView);
                    $('#appendCartItems').html(resp.view);
                },
                error: function () {
                    alert('Error');
                },
            });    
        }
    });

    //  Account Update Details  
    $('#accountForm').submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/account',
            type: 'POST',
            data: formdata,
            success: function(resp){
                // alert(resp);
                if (resp.type == 'error') {
                    $(".loader").hide();
                    $.each(resp.errors, function(i, error){
                        $("#account-"+i).attr('style', 'color:red');
                        $("#account-"+i).html(error);
                        setTimeout(function(){
                            $('#account-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                if (resp.type == 'success') {
                    $(".loader").hide();
                    $('#account-success').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <strong>Success: </strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            },
            error: function () {
                alert('Error');
            }       
        });
    });

    //  Account Password Update 
    $('#passwordForm').submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/update-password',
            type: 'POST',
            data: formdata,
            success: function(resp){
                // alert(resp);
                if (resp.type == 'error') {
                    $(".loader").hide();
                    $.each(resp.errors, function(i, error){
                        $("#password-"+i).attr('style', 'color:red');
                        $("#password-"+i).html(error);
                        setTimeout(function(){
                            $('#password-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                else if (resp.type == 'success') {
                    $(".loader").hide();
                    $('#password-success').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <strong>Success: </strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
                else if (resp.type == 'incorrect') {
                    $(".loader").hide();                   
                    $('#password-error').html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <strong>Error: </strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            },
            error: function () {
                $(".loader").hide();   
                alert('Error');
            }       
        });
    });

    //  Register Form Validation 
    $('#userRegistrationForm').submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/register',
            type: 'POST',
            data: formdata,
            success: function(resp){
                // alert(resp);
                if (resp.type == 'error') {
                    $(".loader").hide();
                    $.each(resp.errors, function(i, error){
                        $("#register-"+i).attr('style', 'color:red');
                        $("#register-"+i).html(error);
                        setTimeout(function(){
                            $('#register-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                if (resp.type == 'success') {
                    $(".loader").hide();
                    $('#register-error').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                            <strong>Success: </strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);                   
                }
            },
            error: function () {
                alert('Error');
            }       

        });
    });

    //  Forgot Password Form Validation 
    $('#forgotPasswordForm').submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/forgot-password',
            type: 'POST',
            data: formdata,
            success: function(resp){
                // alert(resp);
                if (resp.type == 'error') {
                    $(".loader").hide();
                    $.each(resp.errors, function(i, error){
                        $("#forgot-"+i).attr('style', 'color:red');
                        $("#forgot-"+i).html(error);
                        setTimeout(function(){
                            $('#forgot-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                if (resp.type == 'success') {
                    $(".loader").hide();
                    $('#forgot-error').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                            <strong>Success: </strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);                   
                }
            },
            error: function () {
                alert('Error');
            }       

        });
    });

    //  Login Form  
    $('#loginForm').submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url: '/user/login',
            type: 'POST',
            data: formdata,
            success: function(resp){
                if (resp.type == 'error') {
                    $.each(resp.errors, function(i, error){
                        $("#login-"+i).attr('style', 'color:red');
                        $("#login-"+i).html(error);
                        setTimeout(function(){
                            $('#login-'+i).css({'display': 'none'});
                        },[3000]);
                    });
                }
                else if (resp.type == 'incorrect') {
                    $('#login-error').html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                            <strong>Error:</strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);                   
                } 
                else if (resp.type == 'inactive') {
                    $('#login-error').html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                            <strong>Error:</strong> ${resp.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);                   
                } 
                else if (resp.type == 'success') {
                    window.location.href = resp.url;                    
                } 
            },
            error: function () {
                alert('Error');
            }       

        });
    });

    //  mini cart hide button
    $(document).on("click","#mini-cart-close", function(){
        $('.mini-cart-wrapper').removeClass('mini-cart-open');
    });

    //  Apply Coupon
    $('#ApplyCoupon').submit(function(){
        var user = $(this).attr('user');
        // alert(user);
        if(user){
            var coupon = $('#code').val();
            // if(!coupon){
            //     $('#ApplyCouponError').text('Enter coupon apply!');
            // }
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/apply-coupon",
                type: "POST",
                data: {coupon:coupon},
                success: function(resp){
                    if(resp.message!=""){
                        alert(resp.message);
                    }
                    $('.totalCartItems').html(resp.totalCartItems);                    
                    $('#appendCartItems').html(resp.view);
                    $('#appendHeaderCartItems').html(resp.headerView);
                    if(resp.couponAmount > 0){
                        $('.couponAmount').text("Tk. "+resp.couponAmount);
                    }else{
                        $('.couponAmount').text("Tk. 0");
                    }
                    if(resp.grandTotal > 0){
                        $('.grandTotal').text("Tk. "+resp.grandTotal);
                    }
                },
                error: function(){
                    alert('Error');
                }
            });
        }
        else{
            alert('Please login to apply coupon!');
            return false;
        }
    });

});

function get_filter(class_name) {
    var filter = [];
    $("." + class_name + ":checked").each(function () {
        filter.push($(this).val());
    });
    return filter;
}
