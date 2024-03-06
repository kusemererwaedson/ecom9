$(document).ready(function(){
    //check Admin Password is correct or not
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
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
            type:'post',
            url:'/admin/update-admin-status',
            data:{status:status,admin_id:admin_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0){
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                }else if(resp['status']==1){
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
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
                type:'post',
                url:'/admin/update-section-status',
                data:{status:status,section_id:section_id},
                success:function(resp){
                    // alert(resp);
                    if(resp['status']==0){
                        $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Inactive'></i>")
                    }else if(resp['status']==1){
                        $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                    }
                },error:function(){
                    alert("error");
                }
            })
        });

    
})