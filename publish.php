<?php

function copyPHPFiles($location,$fileName,$header = "",$footer = "")
{
  $view_page_content = $header;

  
  $file = fopen($fileName, "r");
  while(!feof($file))
  {
    //echo fgets($file). "<br>";
    $view_page_content .= fgets($file);
  }
  fclose($file);
  
  $view_page_content .= $footer;

  //echo $view_page_content;

  $file = fopen($location.$fileName,"w");
  fwrite($file, $view_page_content);
  fclose($file);
}


  $store_id = $_POST['store_id'];
  $store_name = $_POST['store_name'];
  $store_location = "users/".$store_name."/";

  $page_title;
  include("header.php");
  include("function_clean.php");

   $store_title;

      $sql = "SELECT store_title FROM basic_store_info WHERE store_id = ".$store_id.";";
      if($result = mysqli_query($connection,$sql)){
          while($row = mysqli_fetch_array($result)){
            $store_title = $row[0];
          }
      }

  $categories = array();
  $sql = "SELECT * FROM category WHERE store_id = ".$store_id." ORDER BY category_name;";

  if($result = mysqli_query($connection,$sql)){
    while($row = mysqli_fetch_array($result)){
      array_push($categories,$row);
    }
  }

  //echo "<pre>";
  //print_r($categories);
  //echo "</pre>";

  $headerContent = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>".$store_title."</title>
      <link href='../../css/bootstrap.css' rel='stylesheet' type='text/css'>
      <script src='../../js/jquery-1.10.2.js'></script>
      <script src='../../js/bootstrap.js'></script>

      
    </head>
    <body>
    <input type='hidden' value='".$store_id."' id='store_id' />
      <!--Container-->
    <div class='container'>

      <!--Title-->
      <div class='center-block page-header'>
        <h2 class='text-center' id='store_title'><a href='index.php'>".$store_title."</a><label class='pull-right'><a id='cartBtn' href='bill_info.html?store_id=".$store_id."' class='btn btn-default'><span class='glyphicon glyphicon-shopping-cart'></span> Cart (0)</a></label></h2>
      </div><!--close title div--><div id='billContainer'></div>";

    $footer_content = "</div><!--close container-->
    <script type='text/javascript'>
      $(window).load(getNoOfProducts());
      function getNoOfProducts(){
          var store_id = $('#store_id').val();
          $.get('get_no_of_cart_item.php', {store_id: store_id }).done(function(data){
            var str = '<span class=\'glyphicon glyphicon-shopping-cart\'></span> Cart (';
              str += data;
              str += ')'
            $('#cartBtn').html(str);
          });
        }
      </script>
    <footer class='navbar navbar-default navbar-fixed-bottom'>
    <div class='container'>     
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='#'>powered by &copy Webception</a></li>
      </ul>
    </div>
  </footer>
  </body>
  </html>";

  
  $index_page = "";

  for($i=0 ; $i<count($categories);$i++){

    if($i == 0){
      $page_title = "users/".$store_name."/index.php";
      $index_page = $categories[0]["category_name"];
    }
    else
      $page_title = "users/".$store_name."/".clean($categories[$i]["category_name"]).".php";
    $page_content;

    //echo $headerContent;

    $active_class = "";
   
    $nav_content = " <!--Store navbar-->
      <nav class='nav navbar-default' style='border-color: white; background-color: white;'  role='navigation'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar-store-list-left'> 
            <span class='sr-only'>Toggle navigation</span> 
            <span class='icon-bar'></span> 
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
        </div>
      <div class='navbar-collapse collapse' id='navbar-store-list-left'>
          <ul class='nav nav-pills nav-justified' id='display_categories'>";

    foreach ($categories as $category) {

      $temp_location;

      if($category["category_name"] == $index_page){
        $temp_location = "index.php";
      }
      else{
        $temp_location = clean($category['category_name']).".php";
      }
      # code...
      if($category["id"] == $categories[$i]["id"]){
        $active_class = "active";

        $nav_content .= "<li class='active'><a href = '".$temp_location."'>".$category['category_name']."</a></li>";
      }
      else{
        $nav_content .= "<li><a href = '".$temp_location."'>".$category["category_name"]."</a></li>";
      }
    }

    $nav_content .= "</ul></div></nav>";

    $product_content = " <!--Display store products-->
      <div id='display_products' style='padding-top: 40px;'>
        <div id='display_products_row' class='row'>";

    $sql = "SELECT product_id, name, product_image FROM product WHERE category_id = " . $categories[$i]["id"];

    if($result = mysqli_query($connection,$sql)){
      while($row = mysqli_fetch_array($result)){
        $image_location = substr(strrchr($row['product_image'], "/"), 1);
       // echo $image_location ."<br/>";
        $product_content .= "<div class='col-xs-12 col-sm-6 col-md-3'><a href = 'view_product.php?product_id=".$row['product_id']."'><img src = 'images/".$image_location."'width='100%' height='250px' alt='...' style='height:250px;' /><h5 class='text-center product_name'>".$row['name']."</h5></a></div>";
      }
    }
    else{
      $product_content .="<em>Products will be added shortly ... Thank you.</em>";
    }

    $product_content .= "</div>
  </div><!--close display products-->";
    
    $page_content = $headerContent . $nav_content . $product_content . $footer_content;

    //echo $page_content;

    $file = fopen($page_title, "w");
    fwrite($file, $page_content);
    fclose($file);
  }

  //echo "<h4>You have successfully build and published your store.</h4>";
  //echo "<a href='users/".$store_name."/'>".$store_name."</a>";

  //echo $headerContent;

//This is to write view_product.php

  $fileName = "view_product.php";
  copyPHPFiles($store_location,$fileName,$headerContent,$footer_content);

  $fileName = "add_to_cart.php";
  copyPHPFiles($store_location,$fileName);

  $fileName = "bill_info.php";
  copyPHPFiles($store_location,$fileName);

  $fileName = "get_no_of_cart_item.php";
  copyPHPFiles($store_location,$fileName);

  $fileName = "addslashes_to_POST.php";
  copyPHPFiles($store_location,$fileName);

  $footer_content = "</div><!--close container-->
    
    <footer class='navbar navbar-default navbar-fixed-bottom'>
    <div class='container'>     
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='#'>powered by &copy Webception</a></li>
      </ul>
    </div>
  </footer>
  </body>
  </html>";

  $fileName = "bill_info.html";
  copyPHPFiles($store_location,$fileName, $headerContent, $footer_content);

  mysqli_close($connection);

  header("Location:index.php");
?>