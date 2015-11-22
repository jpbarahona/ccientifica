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

	var $loading = $('#kkmolida').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('../exeMetodo',{'fx': fx, 'xi': xi, 'xf': xf, 'errto': errto, 'imax': imax, 'exeFundamento': exeFundamento,
							'exeMetodo': exeMetodo})
		.fail(function(){
			alert(fx+" "+xi+" "+xf+" "+errto+" "+imax+" "+exeFundamento+" "+exeMetodo);
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$loading.append();
			$("#load").html($('<img>').attr("src",d['img']));
			$("#kkmolida").append($('<div>').attr("class","scrollable")
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
	/*var map = {};
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
	var g = i;*/

	var fx = "log(x)";
	var x = 2;
	var g = 2;
	var cat = "1;4;6";

	var $loading = $('#kkmolida').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
	$.getJSON('exeLagrange',{'fx': fx, 'x': x, 'g': g, 'xptos': cat, 'exeFundamento': exeFundamento,
							'exeMetodo': exeMetodo})
		.fail(function(){
			alert("Ocurrio un error en el servidor");
		})
		.done(function(d){
			$loading.append();
			$("#load").html($('<img>').attr("src",d['img']));
			$("#kkmolida").append($('<div>').attr("class","scrollable")
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