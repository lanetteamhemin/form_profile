<?php
session_start();
include_once("header_include.php");

?>

<html>
<head>
    <title>

    </title>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#update_profile").click(function(){
                var file=$("#new_profile")[0].files[0];
                var _id=$("#data_id").val();

                var form=new FormData();
                if(file)
                {
                    form.append("profile",file);
                }

                var url="http://192.168.200.83:1212/updateprofile/"+_id;

                $.ajax({
                    type:"POST",
                    url:url,
                    data:form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success:function(res){
                        $.ajax({
                            type: "POST",
                            url: "API/session_data.php",
                            data:{id: _id},
                            success: function(data){
                                //location.reload();
                                window.location = "home.php";
                            },error: function(err){
                                console.log("error occure during access session data");
                            }
                        });
                    },
                    error:function(err){
                        console.log("error during profile updating...");
                    }
                });

            });
        })
    </script>
</head>
<body>
<?php

require_once("header.php");

?>
<div class="row" id="up">
    <div class="col-sm-3">
        <input type="hidden" id="data_id" value="<?php echo $_SESSION['id']; ?>"><br>
        <div class="form-group">
            <img src="http://192.168.200.83/JS_Example/Rest_api_php/img/<?php echo $_SESSION['profile']; ?>" height="50px" width="50px" id="profile" class="img-circle"/>
        </div>
        <div class="form-group">
            <input type="file" class="form-control" id="new_profile">
        </div>
        <button type="submit" class="btn btn-info" name="update-profile" id="update_profile">Register</button>
        <button type="submit" class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
    </div>
</div>

</body>
</html>