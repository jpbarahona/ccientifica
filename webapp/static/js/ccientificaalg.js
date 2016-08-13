//==================
//Global
//==================

var $loading;
var numChileRegex = /^-?(?=.*[0-9])\d*(,\d{1,10})?$|^-?[0-9]\d{0,2}(\.\d{3,3})*?(,\d{1,10})?$/g;

// Validar ingreso de números formato Chile.
function validateFormatterNumber (value){
	if (!value.match(numChileRegex)){
		alert("Formato incorrecto "+value+".\nFormato correcto 321321412,2 o 1.323.232,432.");
		throw new Error();
	}
	return 0;
}

// Completar campos requeridos
function noEmpty (value){
	if(value==''){
		alert("Debe completar todos los campos requeridos.");
		throw new Error();
	}
	return 0;
}

function getCoord (i){

	var map = {};
	var xptos = [];
	var yptos = [];
	var catx = "";
	var caty = "";

	$(".valx").each(function() {
   		map[$(this).attr("class")] = $(this).val();
   		noEmpty(map.valx);
		validateFormatterNumber(map.valx);
   		xptos.push(map.valx);
	});

	$(".valy").each(function() {
   		map[$(this).attr("class")] = $(this).val();
   		noEmpty(map.valy);
		validateFormatterNumber(map.valy);
   		yptos.push(map.valy);
	});

	for(var i = 0;i < xptos.length-1; i++){
		catx += xptos[i]+";";
	}

	for(var i = 0;i < yptos.length-1; i++){
		caty += yptos[i]+";";
	}

	catx += xptos[xptos.length-1];
	caty += yptos[xptos.length-1];


	return input = {
		catx: catx,
		caty: caty
	}

}

//==================
//Funciones
//==================
 
/**
 * Ejecutar códigos de ecuacion de la recta
 */

function ejecutarCodigo(exeFundamento,exeMetodo){
	var fx = $('#fxx').val();
	var xi = $('#xii').val();
	var xf = $('#xff').val();
	var errto = $('#errto').val();
	var imax = $('#imax').val();

	noEmpty(fx);
	noEmpty(xi);
	validateFormatterNumber(xi);
	noEmpty(xf);
	validateFormatterNumber(xf);
	noEmpty(errto);
	validateFormatterNumber(errto);
	noEmpty(imax);
	validateFormatterNumber(imax);

	/*var fx = "x*log(x/3)-x";
	var xi = 1.5;
	var xf = 20.1;
	var errto = 0.00001;
	var imax = 25;*/

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeMetodo',{'fx': fx, 'xi': xi, 'xf': xf, 'errto': errto, 'imax': imax,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			console.log("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").remove();
			$("#load").html($('<img>').attr("src",d['img']));
			$("#loader").append($('<div>').attr("class","scrollable")
						    .append($('<table>').attr("id","ttable")
							  	.append($('<thead>')
							  		.append($('<tr>').attr("id","tthtr")))));
			for (var i = 0; i < d['resultados'][0].length; i++) {
				$("#tthtr").append('<th>'+d['resultados'][0][i]+'</th>');
			};
			$("#ttable").append($('<tbody>').attr("id","ttbody"));
			for (var i = 1; i < d['resultados'].length; i++) {
				$('#ttbody').append($('<tr>').attr("id","ttbtr"+i));
				for (var j = 0; j < d['resultados'][0].length; j++) {
					$('#ttbtr'+i).append('<td>'+d['resultados'][i][j]+'</td>');
				};
			};
		});
	}

function ejecutarLagrange(exeFundamento,exeMetodo,i){
	var map = {};
	var xptos = [];
	var cat = "";
	$(".valx").each(function() {
   		map[$(this).attr("class")] = $(this).val();
   		noEmpty(map.valx);
   		validateFormatterNumber(map.valx);
   		xptos.push(map.valx);
	});

	for(var i = 0;i < xptos.length-1; i++){
		cat += xptos[i]+";";
	}
	cat += xptos[xptos.length-1];
	var fx = $('#fxx').val();
	var x = $('#xxx').val();
	var g = i;

	noEmpty(fx);
	noEmpty(x);
	validateFormatterNumber(x);

	/*var fx = "log(x)";
	var x = 2;
	var g = 2;
	var cat = "1;4;6";*/

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeLagrange',{'fx': fx, 'x': x, 'g': g, 'xptos': cat,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").html($('<img>').attr("src",d['img']));
			$("#loader").append($('<div>').attr("class","scrollable")
						    .append($('<table>').attr("id","ttable")
							  	.append($('<thead>')
							  		.append($('<tr>').attr("id","tthtr")))));
			for (var i = 0; i < d['resultados'][0].length; i++) {
				$("#tthtr").append('<th>'+d['resultados'][0][i]+'</th>');
			};
			$("#ttable").append($('<tbody>').attr("id","ttbody"));
			for (var i = 1; i < d['resultados'].length; i++) {
				$('#ttbody').append($('<tr>').attr("id","ttbtr"+i));
				for (var j = 0; j < d['resultados'][0].length; j++) {
					$('#ttbtr'+i).append('<td>'+d['resultados'][i][j]+'</td>');
				};
			};
		});
	}

function ejecutarRegLineal(exeFundamento, exeMetodo, i){
	var coord = getCoord(i);

	/**
	 * Número de coordenadas : i,
	 * x[] : coord.catx,
	 * y[] : coord.caty
	 */

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeRegresion_lineal',{'i': i, 'x': coord.catx, 'y': coord.caty,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").remove();
			$("#loader").append(
				'<a href="'+d.rutaArchivo+'" target="blank_"><button class="btn">Descargar Archivo</button></a>'
			);
		});
}

function ejecutarInterpolacionNewton(exeFundamento, exeMetodo, i){
	/**
	 * Número de coordenadas : i,
	 * x[] : coord.catx,
	 * y[] : coord.caty,
	 * Número a evaluar : evaluar
	 */
	var coord = getCoord(i);
	var evaluar = $("#evaluar").val();

	noEmpty(evaluar);
	validateFormatterNumber(evaluar);

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeInterpolacion_newton',{'i': i, 'x': coord.catx, 'y': coord.caty, 'evaluar': evaluar,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			console.log(d.rutaArchivo);
			$("#load").remove();
			$("#loader").append(
				'<a href="'+d.rutaArchivo+'" target="blank_"><button class="btn">Descargar Archivo</button></a>'
			);
		});
}

function ejecutarMinimos_cuadrados_discretos(exeFundamento, exeMetodo, i){
	var coord = getCoord(i);

	/**
	 * Número de coordenadas : i,
	 * x[] : coord.catx,
	 * y[] : coord.caty
	 */

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeMinimos_cuadrados_discretos',{'i': i, 'x': coord.catx, 'y': coord.caty,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").remove();
			$("#loader").append(
				'<a href="'+d.rutaArchivo+'" target="blank_"><button class="btn">Descargar Archivo</button></a>'
			);
		});
}

function ejecutarEuler (exeFundamento, exeMetodo){

	var imax = $("#imax").val();
	var xii = $("#xii").val();
	var yii = $("#yii").val();
	var xff = $("#xff").val();

	noEmpty(imax);
	validateFormatterNumber(imax);
	noEmpty(xii);
	validateFormatterNumber(xii);
	noEmpty(yii);
	validateFormatterNumber(yii);
	noEmpty(xff);
	validateFormatterNumber(xff);

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeEuler',{'imax': imax, 'xi': xii, 'yi': yii, 'xf': xff,
							'exeFundamento': exeFundamento, 'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").remove();
			$("#loader").append(
				'<a href="'+d.rutaArchivo+'" target="blank_"><button class="btn">Descargar Archivo</button></a>'
			);
		});
}