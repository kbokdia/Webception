<?php
	$location = $_GET['location'];
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Customization Tool">
		<meta name="author" content="Webception">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
	
		<title>Customize - Webception</title>
				

		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/createjs-2013.12.12.min.js"></script>
		<script type='text/javascript' src='js/avgrund.js'></script>
		<script type="application/javascript">
		var stage;
		var productImage;
		var inputText
		var inputTextClick = false;
		var bitmapImage;
		var bitmapImageClick = false;
		var fontList = new Array('Sans-serif', 'Cursive', 'Arial', 'Verdana','Times New Roman', 'Fantasy', 'Serif', 'Comic Sans MS', 'Helvetica','Geneva', 'Tahoma', 'Helvetica Greek','Corsiva', 'Courier');
		
		
		function draw() {
			populateListBox();
	    	stage = new createjs.Stage('tutorial');
	    	stage.enableMouseOver(20);

	    	drawProduct();

	    	createjs.Ticker.setFPS(60);
	    	createjs.Ticker.addEventListener("tick",tick);
	    	
	    }

	    function populateListBox(){
	    	for (var i = 0; i <fontList.length; i++) {
	    		var option = document.createElement('option');
	    		option.setAttribute('value',fontList[i]);
	    		option.innerHTML = fontList[i];
	    		document.getElementById('fontListBox').appendChild(option);
	    	}
	    }

	    function drawProduct(){
	    	var img = document.getElementById('product');
			productImage = new createjs.Bitmap(img);
			console.log(productImage.image.width);
			
			console.log(productImage);
			productImage.scaleX = (500/productImage.image.width);
			console.log(500/productImage.image.width);
			productImage.scaleY = (500/productImage.image.height);

			stage.addChild(productImage);
		}

		function addText(){
			var inputTextSize = document.getElementById('inputTextSize').value;
			var inputFont = getSelectedFont();

			inputText = new createjs.Text(document.getElementById('inputText').value, inputTextSize +'px '+ inputFont, document.getElementById('inputColor').value);
			inputText.regX = (inputText.getMeasuredWidth()/2);
			inputText.regY = (inputText.getMeasuredHeight()/2);
			inputText.x = 250;
			inputText.y = 250;

			inputText.addEventListener("mousedown", moveText);
			inputText.addEventListener("pressup",stopText);

			console.log(inputText.text);

			stage.addChild(inputText);
		}

		function getSelectedFont(){
			var index = document.getElementById('fontListBox').selectedIndex;
			return (document.getElementsByTagName("option")[index].value);
		}

		function changeColor(){
			if(inputText != null)
				inputText.color = document.getElementById('inputColor').value;
		}

		function changeFont(){
			var size = document.getElementById('inputTextSize').value;
			
			if(inputText != null)
				inputText.font = size+"px " +getSelectedFont();
		}

		function changeFontSize(){
			var size = document.getElementById('inputTextSize').value;
			inputText.font =  size+"px " +getSelectedFont();
		}

		function handleInputImage(files){
			var imageFile = files[0];

			var reader = new FileReader();
			reader.onloadend = function(){
				addImage(reader.result);
			}
			reader.readAsDataURL(imageFile);

			//addImage(img);
		}

		function addImage(img){
			bitmapImage = new createjs.Bitmap(img);

			bitmapImage.regX = (bitmapImage.image.width/2);
			bitmapImage.regY = (bitmapImage.image.height/2);
			
			bitmapImage.x = 250;
			bitmapImage.y = 250;
			
			bitmapImage.scaleX = ((500/bitmapImage.image.width)/4);
			bitmapImage.scaleY = ((500/bitmapImage.image.height)/4);
			
			bitmapImage.addEventListener('mousedown', moveImage);
			bitmapImage.addEventListener('pressup', stopImage);

			stage.addChild(bitmapImage);
		}

		function scaleInputImage(){
			var value = document.getElementById('inputZoom').value;
			bitmapImage.scaleX = value/100;
			bitmapImage.scaleY = value/100;
		}

		function removeElement(){
			console.log(stage.getNumChildren());
			console.log(stage.getChildAt(stage.getNumChildren()-1));
			stage.removeChildAt(stage.getNumChildren()-1);
		}

	    function moveText(event){
	    	inputTextClick = true;
	    }

	    function stopText(event){
	    	inputTextClick = false;
	    }

	    function moveImage(event){
	    	bitmapImageClick = true;
	    }

	    function stopImage(event){
	    	bitmapImageClick = false;
	    }

	    function tick(){
	    	if(inputTextClick){
	    		inputText.cursor = "pointer";
	    		inputText.x = stage.mouseX;
	    		inputText.y = stage.mouseY;
	    	}

	    	if(bitmapImageClick){
	    		bitmapImage.cursor = "pointer";
	    		bitmapImage.x = stage.mouseX;
	    		bitmapImage.y = stage.mouseY;
	    	}

	    	stage.update();
	    }

	</script>
		
	</head>
	<body>
	<aside id='default-popup' class='avgrund-popup'>
		<img id='savedImage' />
	</aside>
	<div class='container avgrund-contents'>
		<div class='row'>
			<div class='col-md-6'>
				<canvas id='tutorial' width='500' height='500'>
					<div style='display:none;'>
						<img src='<?php echo $location; ?>' onload='draw();' id='product'>
					</div>
				</canvas>
			</div>
			<div class='col-md-6'>
				<div id='button-group'>
					<button id='addTextBtn' class='btn btn-primary'><span class='glyphicon glyphicon-pencil'></span> Add Text</button>
					<button id='addImageBtn' class='btn btn-primary'><span class='glyphicon glyphicon-picture'></span> Add Image</button>
					<button onclick='saveCustomProduct();' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span> Preview</button>
					<button class='btn btn-danger' onclick='removeElement();'><span class='glyphicon glyphicon-trash'></span> Remove</button>					
					<!--<button class='btn btn-success'>Save</button>-->
				</div>
				<div id='textDiv'>
					<div class='form-group'>
						<label for='inputText'>Enter Text</label>
						<input class='form-control' type='text' id='inputText' />								
					</div>
					<div class='form-group'>
						<label>Font Color</label>
						<input type='color' class='form-control' onchange='changeColor();' id='inputColor' /><br />
						<label>Font Size</label>
						<input type='number' id='inputTextSize' class='form-control' onchange='changeFontSize();' value = '30' min='8' maxlength='2' style='width:75px'><br />
						<label>Font Family</label>
						<select id='fontListBox' class='form-control' onchange='changeFont();'>
							
						</select>
					</div>				
					<button class='btn btn-default' onclick='addText();'>Add</button><br />
				</div>
				<div id='imageDiv'>
					<div class='form-group'>
						<input type='file' style='display:none;' id='inputImage' onchange='handleInputImage(this.files);'>
						<a href="#" id='fileSelect'>Select Image</a><br/><br/>
						
						Zoom: 1<input type='range' value='30' onchange='scaleInputImage();' class='form-control' id='inputZoom' min='1' max='100' />100
			
						<div id='preview'></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="css/avgrund.css">
	
	<style type="text/css">
		html,body 
		{
			height: 100%;
		}
		html 
		{
			background-color: #222;
			background-repeat: repeat;
		}

		body {
		 padding-top: 70px; 
		}

		.avgrund-popup {
			position: absolute;
			width: 500px;
			height: 500;
			left: 45%;
			top: 25%;
			margin: -130px 0 0 -190px;
			visibility: hidden;
			opacity: 0;
			z-index: 2;
			padding: 0px;
			background: white;
			box-shadow: 0px 0px 20px rgba( 0, 0, 0, 0.6 );
			border-radius: 3px;
			-webkit-transform: scale( 0.8 );
			-moz-transform: scale( 0.8 );
			-ms-transform: scale( 0.8 );
			-o-transform: scale( 0.8 );
			transform: scale( 0.8 );
			padding-top: -50px;
		}

		input[type='range'] {
			-webkit-appearance: none;
			border-radius: 5px;
			box-shadow: inset 0 0 5px #333;
			background-color: #999;
			height: 10px;
			vertical-align: middle;
			display: inline-block;
			width: inherit;
		}
		input[type='range']::-moz-range-track {
			-moz-appearance: none;
			border-radius: 5px;
			box-shadow: inset 0 0 5px #333;
			background-color: #999;
			height: 10px;
			display: inline-block;
			width: inherit;
		}
		input[type='range']::-webkit-slider-thumb {
			-webkit-appearance: none !important;
			border-radius: 20px;
			background-color: #FFF;
			box-shadow:inset 0 0 10px rgba(000,000,000,0.5);
			border: 1px solid #999;
			height: 20px;
			width: 20px;
		}
		input[type='range']::-moz-range-thumb {
			-moz-appearance: none;
			border-radius: 20px;
			background-color: #FFF;
			box-shadow:inset 0 0 10px rgba(000,000,000,0.5);
			border: 1px solid #999;
			height: 20px;
			width: 20px;
		}
	</style>
	<script type="text/javascript">
		
		function saveCustomProduct(){
	    	var destinationFolder = "/images/";
	    	var canvas = document.getElementById('tutorial');

	    	console.log("Saving canvas");
	    	var dataUrl = canvas.toDataURL();
	    	var img = document.getElementById('savedImage');
	    	img.src = dataUrl;
	    	img.file = dataUrl;
	    	openDialog();
	    }

		function openDialog() {
			Avgrund.show( "#default-popup" );
		}

		function closeDialog() {
			Avgrund.hide();
		}
	</script>
	
	<script type="text/javascript">
		var fileSelect = document.getElementById('fileSelect'),
			inputImage = document.getElementById('inputImage');

		fileSelect.addEventListener('click',function(e){
			if(inputImage){
				inputImage.click();
			}
			e.preventDefault();
		},false);

	</script>
	<script type="text/javascript">
			$('#textDiv').hide();
			$('#imageDiv').hide();

			$('#addTextBtn').click(function(event) {
				$('#imageDiv').hide();
				$('#textDiv').slideToggle('fast');
			});

			$('#addImageBtn').click(function(event) {
				$('#textDiv').hide();
				$('#imageDiv').slideToggle('fast');
			});
	</script>
	</body>
</html>