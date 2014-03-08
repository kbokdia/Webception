<?php
session_start();
$store_id = 0;
$store_name = "";
$row = array();
if(isset($_SESSION["s_id"]))
{
	if((isset($_GET["store_id"])) && (isset($_GET["store_name"])))
	{
		$store_id = (int) $_GET["store_id"];
		$store_name = $_GET["store_name"];
		include("header.php");
		$sql = "SELECT * FROM `basic_store_info` WHERE store_id=".$store_id;
		$row = mysqli_fetch_array(mysqli_query($connection,$sql));
	}
	else
	{
		header("Location:index.php");
		exit;		
	}	
}
else
{
	header("Location:index.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Webception</title>
<link href="css/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.css" rel="stylesheet" />
<link href="css/bootstrap.css" rel="stylesheet">
<style>
body
{
	padding-top:70px;	
}

</style>
<link href="css/bootstrap-responsive.css" rel="stylesheet" />
<script src="js/jquery-1.10.2.js">
</script>
<script src="css/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.js"></script>
<script src="js/bootstrap.js">
</script>
</head>

<body>
<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
	<div class='navbar-header'>
    <!--<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>-->
    <a class='navbar-brand' href='index.php'>Webception</a>
  </div>
</nav>
	<div class="container">
        <section>
        	<a id="basic_store_info_btn" href="#/basic_info_section" class="btn btn-primary">Basic Info</a>
			<a id="category_btn" href="#/category_section" class="btn btn-primary">Categories</a>
        </section>
        <section id="basic_info_section">
        	<h3 class="h3">Basic Store Info</h3>
            <form action="edit_basic_store_info.php?store_id=<?php echo $store_id;?>&store_name=<?php echo $store_name;?>" method="post" role="form">
            	<div class="form-group">
                	<label for="store_title">Store Title</label>
                	<p><input class="form-control" id="store_title" type="text" name="store_title" value="<?php echo stripslashes($row['store_title']) ?>"></p>
           		</div>
                <div class="form-group">
                	<label for="store_desc">Description</label>
	                <textarea name="store_desc" id="store_desc" class="form-control"><?php echo stripslashes($row["store_desc"]) ?></textarea><br />
				</div>
                <div class="form-group">
                	<label for="basic-info_email">Email Address</label>
	                <input class="form-control" type="email" id="basic_info_email" name="email" value="<?php echo stripslashes($row['email']) ?>" /><br />
    			</div>
                <div class="form-group">
                	<label for="basic_info_mobile">Mobile</label>
	                <input class="form-control" id="basic_info_mobile" type="text" name="mobile" value="<?php 	echo stripslashes($row['mobile']) ?>"/><br />
    			</div>
                <div class="form-group">
	                <input class="btn btn-success" type="submit" value="Update" />
    			</div>
                <input type='hidden' value='1' name='submitted' />
            </form>
        </section>
        <section id="category_section">
        	<h3 class="h3">Categories</h3>
        	<button id="add_category_btn" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Category</button>
                	<button id="edit_category_btn" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                    <button id="delete_category_btn" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                	<div id="display_category">                        
                    </div>          	
                	<div id="category_form_dialog" title="Category">
                        
                        	<form id="form_category" name="form_category" method="post" enctype="multipart/form-data" role="form">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" id="category_name" required="required" />
                                </div>
                               
                                	<label for="image_file">Image:</label>
									<input type="file" name="file" id="image_file">
                                    <div class="display_category_image">
                                    </div>                               
                                <br /><br />
                                <div class="form-group">
                                <button id="submit_category" type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> OK</button>
                                <input type="hidden" name="store_id" value="<?php echo $store_id?>" />
                                <input type="hidden" name="store_name" value="<?php echo $store_name?>" />
                                <input type="hidden" name="category_id" id="category_id"/>
                                <input type='hidden' name='submitted' id="submitted" />
                                </div>
                            </form>               
            			</div>
        </section>
     
</div>

<script type="text/javascript">
$(document).ready(function(e) {
	$(this).scroll();
	//$("#accordion").accordion({header:"h3",collapsible:true,active:false});
	$("#category_form_dialog").dialog({ autoOpen:false });
	//$("#edit_category_dialog").dialog({ autoOpen:false });
	var image_object = $("#image_file");
	
	$.urlParam = function(name){
    var results = new RegExp('[\\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
    return results[1] || 0;
	};
	var category_name = new Array();
	var category_image = new Array();
	var category_id = new Array();	
	
	var getCategories = function(){
		var str = "<table>";
		$.getJSON("get_categories.php",
		{
			store_id:$.urlParam("store_id"),		
		}).done(function(data)
		{
			$.each(data,function(i,value){
				str += "<tr><td>"+i+"</td><td><input type='radio' checked='checked'  name='category_name' value='"+value.category_name+"'/><img src='"+value.category_image+"' width='70px' height='100px' />"+value.category_name+"</td><td><input type='hidden' id='display_category_id' value='" + value.id + "'></td><td><input type='hidden' id='display_category_image' value='"+value.category_image+"'/></td></tr>";
				category_name[i] = value.category_name;
				category_image[i] = value.category_image;
				category_id[i] = value.id;
				console.log(category_image)
			});
			str += "</table>";
			$("#display_category").append(str);
		});
	 };
	 getCategories();
	 
	 var updateCategory = function(id,name)
	 {
		$.post("edit_category.php",{category_id:id,category_name:name}).done(function(data){
			$("#display_category").empty();
			getCategories();});	 
	};
	
	$("#submit_category").click(function(e) {	
		
        $("#category_form_dialog").dialog("close");
		
		var formData = new FormData(document.getElementById("form_category"));
		$.ajax({
			url: "create_category.php",
			type: "POST",
			data: formData,
			processData:false,
			contentType:false
		}).done(function(){
			$("#display_category").empty();
			getCategories();
			});
		/*var oReq = new XMLHttpRequest();
		oReq.open("POST","create_category.php",true);
		oReq.onload = function(oEvent){
			if(oReq.status == 200){
				alert("Uploaded");
			}else{
				alert("Error: "+ oReq.status)	
			}
		};
		oReq.send(formData);*/
				
    });
		
	var deleteCategory = function(id,image)
	{
		$.post("delete_category.php",{category_id:id,category_image:image}).done(function(data){
			$("#display_category").empty();
			getCategories();	
		});	
	};
	 
	 $("#image_file").change(function(e) {
		$(".display_category_image").empty();
        var image = this.files[0];
		if((image.size||image.fileSize) > 512000)
		{
			$(".display_category_image").find("img").remove();
			$(".display_category_image").append("File size greater than 500KB")
			image_object.replaceWith(image_object = image_object.clone(true));
		}
		else
		{
			$(".display_category_image").find("img").remove();
			//var file = image//e.originalEvent.srcElement.files[0];
			
			var img = document.createElement("img");
			var reader = new FileReader();
			reader.onloadend = function() {					
				 img.src = reader.result;
				 $(".display_category_image").find("img").width(150).height(150);
			}
			reader.readAsDataURL(image);
			$(".display_category_image").append(img);
		
			
		}
    });
	 
	 $("#delete_category_btn").click(function(e) {
		 var id =  $("#display_category").find("input:radio:checked").parents("tr").find("#display_category_id").val();
		 var image = $("#display_category").find("input:radio:checked").parents("tr").find("#display_category_image").val();	
		deleteCategory(id,image);
    });
	 
	 $("#add_category_btn").click(function(e) {
		 
		 $("#category_form_dialog").find("#form_category").each(function() {
            this.reset();
        });
		
		$("#category_form_dialog").find("#submitted").val(1);
		$(".display_category_image").empty();
        $("#category_form_dialog").dialog("open");
    });
	 
	 $("#edit_category_btn").click(function(e) {
		var category_name =  $("#display_category").find("input:radio:checked").val();
		$("#category_form_dialog").find("#category_name").val(category_name);
		
		
		$(".display_category_image").empty();
		
		var id =  $("#display_category").find("input:radio:checked").parents("tr").find("input:hidden").val();
		$("#category_form_dialog").find("#category_id").val(id);
		
		$("#category_form_dialog").find("#submitted").val(2);
		$("#category_form_dialog").dialog("open");     
    });
	
});

</script>
</body>
</html>