
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 <style type="text/css">
 #canvas{
  background-color: #EFC;
 }
 body {
  background:#eee;
}
#canvas {
  background:#fff;
}
</style>
<script>

	function sleep(ms) {
	  return new Promise(resolve => setTimeout(resolve, ms));
	}
	function travacampo(){
		document.getElementById('xbody').scrolling = 'yes';
		document.body.style.overflow = 'hidden';
	}
	document.addEventListener('touchmove', function (event) {
	  if (event.scale !== 1) { event.preventDefault(); }
	   temporiza = setTimeout(function(){ 
			 salvar();
		}, 8000);
	 
	}, { passive: true });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div id="canvasDiv" width="100%" height="100%" ondblclick="salvar()" onclick="travacampo()"></div>

<script type="text/javascript">
 var canvasWidth = 300;
var canvasHeight = 150;
var canvasDiv = document.getElementById('canvasDiv');
canvas = document.createElement('canvas');
canvas.setAttribute('width', canvasWidth);
canvas.setAttribute('height', canvasHeight);
canvas.setAttribute('id', 'canvas');
canvasDiv.appendChild(canvas);
if(typeof G_vmlCanvasManager != 'undefined') {
	canvas = G_vmlCanvasManager.initElement(canvas);
}
context = canvas.getContext("2d");


$('#canvas').mousedown(function(e){
  var mouseX = e.pageX - this.offsetLeft;
  var mouseY = e.pageY - this.offsetTop;
		
  paint = true;
  addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
  redraw();
});

$('#canvas').mousemove(function(e){
  if(paint){
    addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
    redraw();
  }
});

$('#canvas').mouseup(function(e){
  paint = false;
});

$('#canvas').mouseleave(function(e){
  paint = false;
});

var clickX = new Array();
var clickY = new Array();
var clickDrag = new Array();
var paint;

function addClick(x, y, dragging)
{
  clickX.push(x);
  clickY.push(y);
  clickDrag.push(dragging);
}

// Set up touch events for mobile, etc
canvas.addEventListener("touchstart", function (e) {
        mousePos = getTouchPos(canvas, e);
  var touch = e.touches[0];
  var mouseEvent = new MouseEvent("mousedown", {
    clientX: touch.clientX,
    clientY: touch.clientY
  });
  canvas.dispatchEvent(mouseEvent);
}, false);

canvas.addEventListener("touchend", function (e) {
  var mouseEvent = new MouseEvent("mouseup", {});
  canvas.dispatchEvent(mouseEvent);
}, false);

canvas.addEventListener("touchmove", function (e) {
  var touch = e.touches[0];
  var mouseEvent = new MouseEvent("mousemove", {
    clientX: touch.clientX,
    clientY: touch.clientY
  });
  canvas.dispatchEvent(mouseEvent);
}, false);

// Get the position of a touch relative to the canvas
function getTouchPos(canvasDom, touchEvent) {
  var rect = canvasDom.getBoundingClientRect();
  return {
    x: touchEvent.touches[0].clientX - rect.left,
    y: touchEvent.touches[0].clientY - rect.top
  };
}

// Prevent scrolling when touching the canvas
document.body.addEventListener("touchstart", function (e) {
  if (e.target == canvas) {
    e.preventDefault();
  }
}, false);
document.body.addEventListener("touchend", function (e) {
  if (e.target == canvas) {
    e.preventDefault();
  }
}, false);
document.body.addEventListener("touchmove", function (e) {
  if (e.target == canvas) {
    e.preventDefault();
  }
}, false);

function redraw(){
  context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
  
  context.strokeStyle = "#000";
  context.lineJoin = "round";
  context.lineWidth = 1;
			
  for(var i=0; i < clickX.length; i++) {		
    context.beginPath();
    if(clickDrag[i] && i){
      context.moveTo(clickX[i-1], clickY[i-1]);
     }else{
       context.moveTo(clickX[i]-1, clickY[i]);
     }
     context.lineTo(clickX[i], clickY[i]);
     context.closePath();
     context.stroke();
  }
}



function salvar()
{
	
	const canvas = document.getElementById("canvas");
	var http = new XMLHttpRequest();
	// Converte o canvas para image/png; base64:
	var image = canvas.toDataURL()
	var params = "image=" + image + "&TABELA=REGISTRO_TAREFAS&NOME=REL_ASSINATURA&GRUPO="+<?php echo $_GET["CODIGO"];?>+"&TIPO="+<?php echo $_GET["TIPO"];?>+""; 
	
		http.open("get", "grava_assinatura.php?"+params+"", true);	
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Talvez o Content-type pode ser outro, não tenho certeza quanto a isso
		http.send("image=" + image + "");
	
	
	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			var response = http.responseText;
			var update = new Array();
			
			
			location.reload();
		}
	}
	
	

	
}


 </script>

