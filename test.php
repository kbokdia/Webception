<?php 
  $store_id = 41;
  $store_name = "shopify";

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

  echo "<pre>";
  print_r($categories);
  echo "</pre>";

  $index_page = "";

  for($i=0 ; $i<count($categories);$i++){

    if($i == 0){
      $page_title = "users/".$store_name."/index.php";
      $index_page = $categories[0]["category_name"];
    }
    else
      $page_title = "users/".$store_name."/".clean($categories[$i]["category_name"]).".php";
    $page_content;

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

      <script type='text/javascript'>

      </script>
    </head>
    <body>
      <!--Container-->
    <div class='container'>

      <!--Title-->
      <div class='center-block page-header'>
        <h2 class='text-center' id='store_title'>".$store_title."</h2>
      </div><!--close title div-->";

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
        echo $image_location ."<br/>";
        $product_content .= "<div class='col-xs-12 col-sm-6 col-md-3'><a href = '#'><img src = 'images/".$image_location."'width='100%' height='250px' alt='...' style='height:250px;' /><h5 class='text-center product_name'>".$row['name']."</h5></a></div>";
      }
    }
    else{
      $product_content .="<em>Products will be added shortly ... Thank you.</em>";
    }

    $product_content .= "</div>
  </div><!--close display products-->";

      $footer_content = "</div><!--close container-->
  </body>
  </html>";

    
    $page_content = $headerContent . $nav_content . $product_content . $footer_content;

    //echo $page_content;

    $file = fopen($page_title, "w");
    fwrite($file, $page_content);
    fclose($file);
  }


  mysqli_close($connection);
?>