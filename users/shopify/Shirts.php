<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>Trendzzz...</title>
      <link href='../../css/bootstrap.css' rel='stylesheet' type='text/css'>
      <script src='../../js/jquery-1.10.2.js'></script>
      <script src='../../js/bootstrap.js'></script>

      
    </head>
    <body>
    <input type='hidden' value='41' id='store_id' />
      <!--Container-->
    <div class='container'>

      <!--Title-->
      <div class='center-block page-header'>
        <h2 class='text-center' id='store_title'><a href='index.php'>Trendzzz...</a><label class='pull-right'><a id='cartBtn' href='bill_info.html?store_id=41' class='btn btn-default'><span class='glyphicon glyphicon-shopping-cart'></span> Cart (0)</a></label></h2>
      </div><!--close title div--><div id='billContainer'></div> <!--Store navbar-->
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
          <ul class='nav nav-pills nav-justified' id='display_categories'><li><a href = 'index.php'>Jeans</a></li><li class='active'><a href = 'Shirts.php'>Shirts</a></li><li><a href = 'T-Shirts.php'>T-Shirts</a></li></ul></div></nav> <!--Display store products-->
      <div id='display_products' style='padding-top: 40px;'>
        <div id='display_products_row' class='row'><div class='col-xs-12 col-sm-6 col-md-3'><a href = 'view_product.php?product_id=34'><img src = 'images/2bbz5x30h4regular-fit-patriot-blue-shirt-in-mandarin-collar-full-sleeves-original.jpg'width='100%' height='250px' alt='...' style='height:250px;' /><h5 class='text-center product_name'>Sero Blue Shirt</h5></a></div><div class='col-xs-12 col-sm-6 col-md-3'><a href = 'view_product.php?product_id=35'><img src = 'images/7jpd159xsrregular-fit-purple-shirt-in-mandarin-collar-full-sleeves-original.jpg'width='100%' height='250px' alt='...' style='height:250px;' /><h5 class='text-center product_name'>Levis Maroon Shirt</h5></a></div></div>
  </div><!--close display products--></div><!--close container-->
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
  </html>