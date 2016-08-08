var $loading;

function getCoord (i){

	var map = {};
	var xptos = [];
	var yptos = [];
	var catx = "";
	var caty = "";

	$(".valx").each(function() {
   		map[$(this).attr("class")] = $(this).val();
   		xptos.push(map.valx);
	});

	$(".valy").each(function() {
   		map[$(this).attr("class")] = $(this).val();
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

/**
 * Ejecutar códigos de ecuacion de la recta
 */

function ejecutarCodigo(exeFundamento,exeMetodo){
	var fx = $('#fxx').val();
	var xi = $('#xii').val();
	var xf = $('#xff').val();
	var errto = $('#errto').val();
	var imax = $('#imax').val();

	/*var fx = "x*log(x/3)-x";
	var xi = 1.5;
	var xf = 20.1;
	var errto = 0.00001;
	var imax = 25;*/

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeMetodo',{'fx': fx, 'xi': xi, 'xf': xf, 'errto': errto, 'imax': imax, 'exeFundamento': exeFundamento,
							'exeMetodo': exeMetodo})
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
   		xptos.push(map.valx);
	});

	for(var i = 0;i < xptos.length-1; i++){
		cat += xptos[i]+";";
	}
	cat += xptos[xptos.length-1];
	var fx = $('#fxx').val();
	var x = $('#xxx').val();
	var g = i;

	/*var fx = "log(x)";
	var x = 2;
	var g = 2;
	var cat = "1;4;6";*/

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeLagrange',{'fx': fx, 'x': x, 'g': g, 'xptos': cat, 'exeFundamento': exeFundamento,
							'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
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

function ejecutarRegLineal(exeFundamento, exeMetodo, i){
	var coord = getCoord(i);

	/**
	 * Número de coordenadas : i,
	 * x[] : coord.catx,
	 * y[] : coord.caty,
	 */

	$loading = $('#loader').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeRegresion_lineal',{'i': i, 'x': coord.catx, 'y': coord.caty, 'exeFundamento': exeFundamento,
							'exeMetodo': exeMetodo})
		.fail(function(){
			$("#load").remove();
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$("#load").remove();
			console.log(d.rutaArchivo);
			//$("#load").html($('<img>').attr("src",d['img']));
			$("#loader").append(
				'<a href="'+d.rutaArchivo+'" target="blank_"><button class="btn">Descargar Archivo</button></a>'
			);
		});
}

$("#load").remove();