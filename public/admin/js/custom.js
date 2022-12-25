$(document).ready(function(){
    //  Call Database Class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();
    $('#filters').DataTable();
    $('#filtersValues').DataTable();

    //  Sidevbar Menu Active Inactive
    $(".nav-item").removeClass('active');
    $(".nav-link").removeClass('active');

    //  Check Admin Password id correct or not
    $("#current_password").keyup(function(){
        var current_password = $('#current_password').val();
        // alert(current_password);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp){
                // alert(resp);
                if (resp == "false") {
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                }
                else if(resp == "true"){
                    $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                }
            },
            error:function(){
                alert("Error");
            }
        });
    });

    //  Update Admin Status
    // $(".updateAdminStatus").click(function(){
    $(document).on("click",".updateAdminStatus", function(){
        // alert("ok");
        var admin_id = $(this).attr("admin_id");
        var status = $(this).children("i").attr("status");
        // alert(admin_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-admin-status',
            data:{admin_id:admin_id, status:status},
            success:function(resp){
                if (resp['status'] == 0) {
                    $("#admin-"+admin_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#admin-"+admin_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

     //  Update Section Status
    //  $(".updateSectionStatus").click(function(){
    $(document).on("click",".updateSectionStatus", function(){
        var section_id = $(this).attr("section_id");
        var status = $(this).children("i").attr("status");
        // alert(section_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-section-status',
            data:{section_id:section_id, status:status},
            success:function(resp){
                if (resp['status'] == 0) {
                    $("#section-"+section_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#section-"+section_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });   

    //  Update Category Status
    // $(".updateCategoryStatus").click(function(){
    $(document).on("click",".updateCategoryStatus", function(){
        // alert('ok');
        var category_id = $(this).attr("category_id");
        var status = $(this).children("i").attr("status");
        // alert(category_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-category-status',
            data:{category_id:category_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#category-"+category_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#category-"+category_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Brand Status
    $(document).on("click",".updateBrandstatus", function(){
        // alert("ok");
        var brand_id = $(this).attr("brand_id");
        var status = $(this).children("i").attr("status");
        // alert(brand_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-brand-status',
            data:{brand_id:brand_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#brand-"+brand_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#brand-"+brand_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Porduct Status
    // $(".updateProductStatus").click(function(){
    $(document).on("click",".updateProductStatus", function(){
        // alert('ok');
        var product_id = $(this).attr("product_id");
        var status = $(this).children("i").attr("status");
        // alert(product_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-product-status',
            data:{product_id:product_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#product-"+product_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#product-"+product_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Banner Status
    // $(".updateBannerStatus").click(function(){
    $(document).on("click",".updateBannerStatus", function(){
        // alert('ok');
        var banner_id = $(this).attr("banner_id");
        var status = $(this).children("i").attr("status");
        // alert(banner_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-banner-status',
            data:{banner_id:banner_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#banner-"+banner_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#banner-"+banner_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Attribute Status
    // $(".updateAttributeStatus").click(function(){
    $(document).on("click",".updateAttributeStatus", function(){
        // alert('ok');
        var attribute_id = $(this).attr("attribute_id");
        var status = $(this).children("i").attr("status");
        // alert(attribute_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-attribute-status',
            data:{attribute_id:attribute_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#attribute-"+attribute_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#attribute-"+attribute_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Filter Status
    $(document).on("click",".updateFilterstatus", function(){
        // alert("ok");
        var filter_id = $(this).attr("filter_id");
        var status = $(this).children("i").attr("status");
        // alert(filter_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-filter-status',
            data:{filter_id:filter_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#filter-"+filter_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#filter-"+filter_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    }); 

    //  Update Filter Value Status
    $(document).on("click",".updateFiltersValueStatus", function(){
        // alert("ok");
        var filter_id = $(this).attr("filter_id");
        var status = $(this).children("i").attr("status");
        // alert(filter_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-filter-value-status',
            data:{filter_id:filter_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#filter-"+filter_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#filter-"+filter_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    });  

    //  Update Multi Images Status
    // $(".updateImageStatus").click(function(){
    $(document).on("click",".updateImageStatus", function(){
        // alert('ok');
        var image_id = $(this).attr("image_id");
        var status = $(this).children("i").attr("status");
        // alert(image_id);
        // alert(status);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-image-status',
            data:{image_id:image_id, status:status},
            success:function(resp){
                // alert(resp);
                if (resp['status'] == 0) {
                    $("#image-"+image_id).html("<i status='Inactive' style='font-size: 25px;' class='mdi mdi-bookmark-outline'></i>")
                } else if(resp['status'] == 1) {
                    $("#image-"+image_id).html("<i status='Active' style='font-size: 25px;' class='mdi mdi-bookmark-check'></i>")
                }
            },
            error(){
                alert('Error');
            }
        });
    }); 

    //  Delete Section (Simple JavaScript)
    // $(".confirmDelete").click(function(){
    //     var title = $(this).attr("title");
    //     // alert(title);
    //     var section_id = $(this).attr("section_id");
    //     // alert(section_id);
    //     if(confirm("Are you sure to delete this "+title+" ?")){
    //         return true;
    //     }
    //     else{
    //         return false;
    //     }
    // });

    //  Delete Section (SweetAlert2 JavaScript)
    // $(".confirmDelete").click(function(){
    $(document).on("click",".confirmDelete", function(){
        var module = $(this).attr("module");
        // alert(module);
        var moduleId = $(this).attr("moduleId");
        // alert(moduleId);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              window.location = "/admin/delete-"+module+"/"+moduleId;
            }
        })
    });

   

    //  Append Category Lavel
    $("#section_id").change(function(){
        var section_id = $(this).val();
        // alert(section_id);
        $.ajax({
            type:'get',
            url:'/admin/append-categories-lavel',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLavel").html(resp);
            },
            error:function(){
                alert('Error');
            }
        });
    });

    //  Product Attributes Add/Remove
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 120px;"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 120px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 120px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    //  Show Filters on selection of Category
    $("#category_id").on('change', function(){
        var category_id  = $(this).val();
        // alert(category_id);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'category-filters',
            data:{category_id:category_id},
            success:function(resp){
                $(".loadFilters").html(resp.view);
            }
        });
    });

});
