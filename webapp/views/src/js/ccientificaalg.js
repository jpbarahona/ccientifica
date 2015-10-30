	function ejecutarCodigo(exeFundamento,exeMetodo){
		var fx = $('#fxx').val();
		var xi = $('#xii').val();
		var xf = $('#xff').val();
		var errto = $('#errto').val();
		var imax = $('#imax').val();

		var $loading = $('#kkmolida').append("<div id='load' style=''><img src='/ccientifica/webapp/views/src/images/ajax-loader.gif'/></div>");
		$.getJSON('../../exeMetodo',{'fx': fx, 'xi': xi, 'xf': xf, 'errto': errto, 'imax': imax, 'exeFundamento': exeFundamento,
								'exeMetodo': exeMetodo})
			.fail(function(){
				alert(fx+" "+xi+" "+xf+" "+errto+" "+imax+" "+exeFundamento+" "+exeMetodo);
				alert("Ocurrio un error en el servidor");
			})
			.done(function(d){
				$loading.append();
				$("#load").html($('<img>').attr("src",d[0]));
				var i = 0;
				$("#kkmolida").append($('<div>').attr("class","scrollable")
								  .append($('<table>')
								  	.append($('<thead>')
								  		.append($('<tr>')
								  			.append('<th>'+d['resultados'][0][0]+'</th><th>'+d['resultados'][0][1]+'</th><th>'+d['resultados'][0][2]+'</th>')))
								  	.append($('<tbody>').attr("id","ttbody"))));
				for (var i = 1; i < d['resultados'].length; i++) {
					$('#ttbody').append($('<tr>').attr("id","ttbtr"+i));
					for (var j = 0; j < d['resultados'][0].length-1; j++) {
						$('#ttbtr'+i).append('<td>'+d['resultados'][i][j]+'</td>');
					};
				};
			});
		}