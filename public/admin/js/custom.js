$(document).ready(function(){
    //call database class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();

    //check Admin Password is correct or not
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp){
                if(resp=="false"){
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                }else if(resp=="true"){
                    $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                }
            },error:function(){
                alert('Error'); 
            }
        });
    })

    // Update Admin Status
    $(document).on("click",".updateAdminStatus",function(){
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-admin-status',
            data:{status:status,admin_id:admin_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else if(resp['status']==1){
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    });

    // Update Section Status
    $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-Active' status='Active'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    });

    // Update Category Status
    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#category-"+category_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inctive'></i>")
                }else if(resp['status']==1){
                    $("#category-"+category_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    });    

    // Update Brands Status
    $(document).on("click",".updateBrandStatus",function(){
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-brand-status',
            data:{status:status,brand_id:brand_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#brand-"+brand_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Active'></i>")
                }else if(resp['status']==1){
                    $("#brand-"+brand_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    }); 

    // Update Products Status
    $(document).on("click",".updateProductStatus",function(){
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-product-status',
            data:{status:status,product_id:product_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#product-"+product_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Active'></i>")
                }else if(resp['status']==1){
                    $("#product-"+product_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    }); 
    
    // // confirm Deletion (simple javascript)
    // $(".confirmDelete").click(function(){
    //     var title = $(this).attr("title");
    //     if(confirm("Are you sure to delete this "+title+"?")){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // });
     
     // confirm Deletion (Sweet Alert javascript library)
     $(document).on("click",".confirmDelete",function(){   
        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');
        Swal.fire({
            title:'Are you sure?',
            text:'You wont able to revert this!',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#d33',
            confirmButtonText:'Yes, Delete it!',
        }).then((result)=>{
            if(result.isConfirmed){
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                window.location = "/admin/delete-"+module+"/"+moduleid;
            }
        })
    });

    // Apend Categories Level
    $("#section_id").change(function(){
        var section_id = $(this).val();
        // alert(section_id);
        $.ajax({
            type:'get',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp);
            },error:function(){
                alert("Error");
            }
        });
    });

    // Products Attributes Add/Remove Script
    var maxfield = 10; //Input field increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height: 10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 80px;"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 80px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 80px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 80px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; // New Input Field html
    
    var x = 1; //initial field counter

    // once add button is clicked
    $(addButton).click(function(){
        // check maximum number of input fields
        if(x < maxfield){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click','.remove_button',function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove HTML
        x--; //Decrement field counter
    });

    // Update Attribute status
    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-attribute-status',
            data:{status:status,attribute_id:attribute_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#attribute-"+attribute_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Active'></i>")
                }else if(resp['status']==1){
                    $("#attribute-"+attribute_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    }); 

    // Update Image status
    $(document).on("click",".updateImageStatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-image-status',
            data:{status:status,image_id:image_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#image-"+image_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Active'></i>")
                }else if(resp['status']==1){
                    $("#image-"+image_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    });

     // Update Banner Status
     $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type:'post',
            url:'/admin/update-banner-status',
            data:{status:status,banner_id:banner_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#banner-"+banner_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inctive'></i>")
                }else if(resp['status']==1){
                    $("#banner-"+banner_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error:function(){
                alert("error");
            }
        })
    });
    
})