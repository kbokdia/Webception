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
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Webception</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<style>
body {
	padding-top: 60px;
}
</style>
<link href="css/bootstrap-responsive.css" rel="stylesheet" />
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	
</script>
</head>

<body>
<!--WEBCEPTION Navbar -->
<nav class="nav navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#navbar-list-left'> <span class='sr-only'>Toggle navigation</span> <span class='icon-bar'></span> <span class='icon-bar'></span> <span class='icon-bar'></span> </button>
      <a class='navbar-brand' href='index.php'><label>
        <font face="Lucida Sans Unicode" color="#ffffff" size="+2">[</font>
	<font face="Lucida Sans Unicode" color="#3a5c9b" size="+2">Web</font>
	<font face="Lucida Sans Unicode" color="#ffffff" size="+2">]</font>
	<font face="Lucida Sans Unicode" color="#ff6c00" size="+2">ception</font></label></a>
    </div>
    <div class='collapse navbar-collapse' id="navbar-list-left">
		<ul class="nav navbar-nav">
			<li><a class='btn' id='add_category_btn'>Add Category</a></li>
			<li><a class='btn' id='add_product_btn'>Add Product</a></li>
			<li><a class='btn' id="display_all_products_btn">Display all products</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		    <li><a href="#">Publish</a></li>
		  	<li><a href="index.php">Exit</a></li>
		</ul>
    </div>
  </div>
</nav>
<label id="store_id" hidden="true"><?php echo $store_id?></label>
<!--Container-->
<div class="container"> 
  <!--Title-->
  <div class="center-block page-header">
    <h2 class="text-center" id="store_title" contenteditable="true"></h2>
  </div>
  <!--Store navbar-->
  <nav class="nav navbar-default" style="border-color: white; background-color: white;"  role="navigation">
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar-store-list-left'> 
      	<span class='sr-only'>Toggle navigation</span> 
        <span class='icon-bar'></span> 
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
    </div>
	<div class='navbar-collapse collapse' id="navbar-store-list-left">
	    <ul class="nav nav-pills nav-justified" id="display_categories">
	    </ul>
	</div>
  </nav>

  <!--Display store products-->
  <div id="display_products" style="padding-top: 40px;">
	<div id="display_products_row" class="row">
		
	</div>
  </div><!--close display products-->
  
  <!--Category modal-->
  <div class="modal fade bs-modal-sm" id="category_modal" tabindex='-1' role="dialog" aria-labelledby="category_title" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="category_title">Category</h3>
        </div>
        <div class="modal-body">
          <form id="form_category" name="form_category" enctype="multipart/form-data" role="form">
            <div class="form-group">
              <label for="category_name">Category Name</label>
              <input type="text" class="form-control" name="category_name" id="category_name" required="required" />
            </div>
            <label for="image_file">Image:</label>
            <input type="file" name="file" id="image_file">
            <div id="display_category_image"></div>
            <br />
            <br />
            <input type="hidden" name="store_id" value="<?php echo $store_id?>" />
            <input type="hidden" name="store_name" value="<?php echo $store_name?>" />
            <input type="hidden" name="category_id" id="category_id"/>
            <input type='hidden' name='submitted' id="submitted" />
          </form>
        </div>
        <div class="modal-footer">
          <button id="submit_category" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!--Product Modal-->
	  <div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel">Product</h3>
	      </div>
	      <div class="modal-body">
	      	<form id="form_product" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="input_product_name">Product Name:</label>
						<input type="text" class="form-control" name="input_product_name" id="input_product_name" placeholder="Product name" />
					</div>
					<div class="form-group">
						<label for="input_product_model_no">Product Model Number</label>
						<input type="text" class="form-control" name="input_product_model_no" id="input_product_model_no" placeholder="Model No" />
					</div>
					<div class="form-group">
						<label for="input_product_price">Price</label>
						<input type="Number" class="form-control" name="input_product_price" id="input_product_price" placeholder="Rs" /> 
					</div>
					<div class="form-group">
						<label for="select_product_category">Product Category</label>
						<select class="form-control" id="select_product_category" name="category_id">
							<option value="0">Please add category first</option>
						</select>
					</div>
					<div class="form-group">
						<label for="input_product_description">Product Description</label>
						<textarea id="input_product_description" name="input_product_description" rows="5" class="form-control"></textarea>
					</div>         	
				</div>
				<div class="col-md-6">
					<input type="hidden" name="store_id" value="<?php echo $store_id ?>" />
					<input type="hidden" name="store_name" value="<?php echo $store_name?>" />
					<input type="hidden" name="submitted" id="product_submitted"/>
					<label for="input_product_image">Product Image</label>
					<input type="file" name="file" id="input_product_image"><br />
					<div id="display_product_image"></div><br />
					<div class="form-group">
						<label for="input_product_key_features">Product Key Features ( Tags )</label>
						<textarea class="form-control" name="input_product_key_features" id="input_product_key_features" rows="3"></textarea>
					</div>
					<div class="checkbox">
						<label>
						<input type="checkbox" name="customize_product" id="customize_product" value="1"/>Enable product customization
						</label>
					</div>					
				</div>
			</div>
		</form>      
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="submit_product"><span class="glyphicon glyphicon-ok"></span> Save Product</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div><!--close product modal-->
</div>
<script type="text/javascript">
	//Get store id
	var store_id = $("#store_id").text();
	var store_title;
	var input_category_name;

	//category details
	var category_name = new Array();
	var category_image = new Array();
	var category_id = new Array();

	//product details
	var product_id = new Array();
	var product_name = new Array();
	var product_image = new Array();
	var product_category = new Array();
	
	//To check if add category btn clicked
	var is_add_category_btn_clicked = false;

	//get category index variable
	var get_category_index;
	//current page detail
	var current_page;

	//call_display_categories_fn variable is check whether or not to call display_categories_fn()
	//var call_display_categories_fn = true; 

	//Get basic store info	
	//AND display store title		
	var get_store_title = function(s_id){
		$.getJSON("get_basic_store_info.php",
		{
			store_id:s_id,
		}).done(function(data){
			store_title = data[0].store_title;
			$("#store_title").empty();
			$("#store_title").html(store_title);				
		});	
	};
	
	//Gets the category from the database
	function get_categories(){
		$("#display_categories").empty();
		$.getJSON("get_categories.php",
		{
			store_id:store_id		
		})
		.done(function(data)
		{
			$.each(data,function(i,value)
			{
				category_name[i] = value.category_name;
				category_image[i] = value.category_image;
				category_id[i] = value.id;
				//display_category(value.category_name);
			});

			display_categories_fn();
		});
	};

	//Gets product info from database
	var get_products = function()
	{
		$.getJSON("get_product_basic.php",
		{
			store_id:store_id,
		})
		.done(function(data)
		{
			$.each(data, function(i, value) {
				 product_id[i] = value.product_id;
				 product_name[i] = value.name;
				 product_image[i] = value.product_image;
				 product_category[i] = value.category_id;
			});
			display_products_fn();
		});
	};

	//displays all the products
	function display_products_fn()
	{
		$("#display_products_row").empty();
		if(product_name.length < 1)
		{
			$("#display_products_row").append('<em>No products yet...</em>');
			return;
		}

		$("#display_categories").find('.active').removeClass('active');
		
		for(var i=0; i<product_id.length; i++)
		{
			display_product_fn(product_name[i],product_image[i]);
		}
	};

	//Display Product function
	function display_product_fn(name,image)
	{
		var content = "<div class='col-xs-12 col-sm-6 col-md-3'><div class='thumbnail'>";
		content += "<div class='dropdown'><a data-toggle='dropdown' href='#'>";
		content += "<img src='"+image+"' width='100%' height='250px' alt='...' style='height:250px;' /><h5 class='text-center'>"+name+"</h5></a>";
		content += "<ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>";
		content += "<li><a href='#' class='view_product text-center'><strong>View</strong></a></li><li class= 'divider'></li>";
		content += "<li><a href='#' class='edit_product'><span class='glyphicon glyphicon-edit'></span> Edit</a></li><li><a href='#' class='delete_product'><span class='glyphicon glyphicon-remove-circle'></span> Delete</a></li>";
		content +="</ul></div>";
		$("#display_products_row").append(content);
	};

	//displays all the categories
	function display_categories_fn()
	{
		$("#display_categories").empty();
		for(var temp in category_name)
		{
			display_category(category_name[temp]);
		}
	};
	
	//display category
	function display_category(name)
	{
		var content = "<li class='dropdown'><a href='#category' class='category_name dropdown-toggle' role='button' data-toggle='dropdown'>"+name+"</a><ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>";
		content += "<li><a href='#' class='view_category text-center'><strong>View</strong></a></li><li class= 'divider'></li>";
        content += "<li><a href='#' class='edit_category'><span class='glyphicon glyphicon-edit'></span> Edit</a></li>";
        content += "<li><a href='#' class='delete_category'><span class='glyphicon glyphicon-remove-circle'></span> Delete</a></li></ul></li>";
		$("#display_categories").append(content);
	};
	
	//On add category click
	function add_category(e)
	{
		input_category_name = "";
		is_add_category_btn_clicked = true;
		$("#category_id").val(0);
		$("#submitted").val(1);
        $("#category_modal").modal('show');
	};

	//On view category click
	function view_category(e)
	{
		current_page = $(e.currentTarget).parents("li").find(".category_name").text();
		$(e.currentTarget).parents("#display_categories").find('.active').removeClass('active');
		$(e.currentTarget).parents(".dropdown").addClass('active');

		//To find category index
		var temp_category_index = category_name.indexOf(current_page);
		var is_product_available = false;
		
		//empties the display area
		$("#display_products_row").empty();

		//for loop is displaying product based on category view
		for(var i=0; i < product_name.length; i++)
		{
			if(product_category[i] == category_id[temp_category_index])
			{
				display_product_fn(product_name[i],product_image[i]);
				is_product_available = true;
			}
		}

		if(!is_product_available)
			$("#display_products_row").append('<em>No products yet...</em>');
	};

	//On edit category click
	function edit_category(e)
	{
		var temp_category_name = $(e.currentTarget).parents("li").find(".category_name").text();
		input_category_name = temp_category_name;
		var index_category_id = category_name.indexOf(temp_category_name);

		//Disable add category btn
		is_add_category_btn_clicked = false;

		//set category index
		get_category_index = index_category_id;

		$("#category_id").val(category_id[index_category_id]);
		$("#submitted").val(2);
		$("#category_modal").modal('show');
	};
	
	//On delete category click
	function delete_category()
	{
		if(confirm("Are you sure? Products under this category will also be DELETED..."))
		{
			var item_index = category_name.indexOf($(this).parents("li").find(".category_name").text());
			var id = category_id[item_index];
			var image = category_image[item_index];
			deleteFromDatabase(id,image,"category","id");

			for(var i=0; i<product_name.length; i++)
			{
				if(product_category[i] == id)
				{
					remove_product(i);
				}
			}

			$(this).parents("li").remove();
			if(item_index > -1)
			{
				category_id.splice(item_index, 1);
				category_name.splice(item_index, 1);
				category_image.splice(item_index, 1);
			}
			
			display_products_fn();		
		}
	}
	
	//delete data from given table
	function deleteFromDatabase(id,image,table_name,where_variable)
	{
		$.post("delete_category.php",{id:id,image:image,table_name:table_name,where_variable:where_variable,});	
	};

	function remove_product(index_variable)
	{
		var temp_product_id = product_id[index_variable];
		var temp_product_image = product_image[index_variable];

		deleteFromDatabase(temp_product_id,temp_product_image,"product","product_id");

		if(index_variable > -1)
		{
			product_id.splice(index_variable, 1);
			product_name.splice(index_variable, 1);
			product_image.splice(index_variable, 1);
			product_category.splice(index_variable, 1);
		}
	}


	//Submit category
	var submit_category_fn = function( event )
	{
		var temp_category_name = $("#category_name").val();

		if (temp_category_name == "") {return;};

		$("#category_modal").modal("hide");
		//save category in database
        var formData = new FormData(document.getElementById("form_category"));
		$.ajax({
			url: "create_category.php",
			type: "POST",
			data: formData,
			processData:false,
			contentType:false
		})
		.done(function(){
			//call_display_categories_fn = true;
			get_categories();
		});

		//display_categories_fn();  
		//create_category_dropDown_box();      
	}

	//To populate on select box of add product dialog box
	function create_category_dropDown_box()
	{
		//Populate categories in drop-down list
		$("#select_product_category").empty();
		for (var i = 0; i < category_id.length; i++) {
			$("#select_product_category").append('<option value='+category_id[i]+'>'+category_name[i]+'</option>');
		};
	}

	//on add product click
	var add_product = function(e)
	{
		$("#product_modal").modal("show");
		create_category_dropDown_box();
		$("#product_submitted").val(1);
	};

	var set_current_page = function(name)
	{
		current_page = name;
	};
	
	$(window).load(function(e) {		
		//on document load title display store title
		get_store_title(store_id);  
		
		//get users categories
		get_categories();

		//get products
		get_products();
    });
	
	$(document).ready(function(e) {
		//hide modal
		$("#category_modal").modal('hide');
		
		//When the title is changed the data is stored in database
        $("#store_title").focusout(function(e)
        {
            var title = $(this).text();
			if(!(title === store_title))
			{
				$.post("edit_basic_store_info.php",
					{
						store_id:store_id,
						store_title:title
					});
			}
        });
		
		//on modal show trigger clear form
		$("#category_modal").on("show.bs.modal",function(e){
			document.forms["form_category"].reset();
			$("#display_category_image").empty();
		});
		
		$("#category_modal").on("shown.bs.modal",function(e){
			$("#category_name").focus();
			$("#category_name").val(input_category_name);
		});
		//on selecting a file display it to the user
		$("#image_file").change(function(e) {
			$("#display_category_image").empty();
			var image = this.files[0];
			if((image.size||image.fileSize) > 512000)
			{
				$("#display_category_image").find("img").remove();
				$("#display_category_image").append("File size greater than 500KB");
				//$("#image_file").replaceWith("<input type='file' id='image_file' name='file' />");
			}
			else
			{
				$("#display_category_image").find("img").remove();
				
				var img = document.createElement("img");
				var reader = new FileReader();
				reader.onloadend = function() {					
					 img.src = reader.result;
					 $("#display_category_image").find("img").width(150).height(150);
				}
				reader.readAsDataURL(image);
				$("#display_category_image").append(img);			
			}
	    });

	    $("#product_modal").on('show.bs.modal', function(event) {
	    	document.forms["form_product"].reset();
	    	$("#display_product_image").empty();
	    });

	     $("#product_modal").on('shown.bs.modal', function(event) {
	    	$("#input_product_name").focus();
	    });

		//on selecting product image display image
	    $("#input_product_image").change(function(e) {
			$("#display_product_image").empty();
			var image = this.files[0];
			if((image.size||image.fileSize) > 512000)
			{
				$("#display_product_image").find("img").remove();
				$("#display_product_image").append("File size greater than 500KB");
			}
			else
			{
				$("#display_product_image").find("img").remove();
				
				var img = document.createElement("img");
				var reader = new FileReader();
				reader.onloadend = function() {					
					 img.src = reader.result;
					 $("#display_product_image").find("img").width(200).height(200);
				}
				reader.readAsDataURL(image);
				$("#display_product_image").append(img);			
			}
		});
		
		//On Input type text do event.preventDefault();
		$("form input:text").keypress(function(event) {
			/* Act on the event */
			if ( event.which == 13 ) {
			    event.preventDefault();
			 }
		});

		//On  submitting category saving it into the database
		$("#submit_category").click(function(event) {
			submit_category_fn(event);
		});

		//On submitting product form it saves all the values in database
		$("#submit_product").click(function(event) {
			event.preventDefault();
			$("#product_modal").modal("hide");
			var formData = new FormData(document.getElementById("form_product"));
			$.ajax({
				url: "create_product.php",
				type: "POST",
				data: formData,
				processData:false,
				contentType:false
			})
			.done(function()
				{
					get_products();
				});
		});
		//on add category click trigger add_category function
		$("nav").on("click","#add_category_btn",add_category);

		//on add product click trigger add_product function
		$("nav").on("click","#add_product_btn",add_product);

		//on display all products click trigger display_products_fn function
		$("nav").on("click","#display_all_products_btn",display_products_fn);

		//on view category click trigger view_category function
		$("#display_categories").on('click', '.view_category', view_category);

		//on edit category click trigger edit_category function
		$("#display_categories").on("click",".edit_category",edit_category);
		
		//on delete category click trigger delete_category function
		$("#display_categories").on("click",".delete_category",delete_category);
	
    });

</script>
</body>
</html>