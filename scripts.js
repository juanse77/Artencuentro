function borrar_trabajo(id_obra, titulo){
	if(!confirm('¿Desea borrar la obra "'+ titulo +'"?')){
       return;
    }

    $.ajax({
		url: "borrar_trabajo.php",
		type: "POST",
		data: JSON.stringify({"id_obra":id_obra}),
		contentType: "application/json;charset=utf-8",

		success: function(res){
			if(res.borrado){
				$('#obra_' + id_obra).remove();

				var num_obras = parseInt($('#num_obras').val());
				num_obras--;
				
				if(num_obras === 0){
					$('#trabajos').remove();
				}else{
					$('#num_obras').val(num_obras);
				}

			}else{
				alert('Error: ' + res.mensaje_error);
			}
		},

		error: function(res){
			alert('Error:' + res.mensaje_error);
		}

	});
}

function validaTitulo(titulo){
    if(titulo.length < 2 || titulo.length > 32){
        return false;
    }
    return true;
}

function validaTipo(tipo){
    if(tipo.length < 5 || tipo.length > 16){
        return false;
    }

    if(tipo.match(/^[a-záéíóúñ]+(\s[a-záéíóúñ]+)*[a-záéíóúñ]$/) === null){
        return false;
    }
    return true;
}

function validaDescripcion(descripcion){
    if(descripcion.length < 12 || descripcion.length > 1024){
        return false;
    }
    return true;
}

function validaCampos(){
    var correcto = true;

    $('.error-val').text('');

    if(!validaTitulo($("#titulo").val())){
        $("#error-titulo").text("Mínimo 2 caracteres y máximo 32 caracteres");
        correcto = false;
    }

    if(!validaTipo($("#tipo").val())){
        $("#error-tipo").text("Mínimo 5 caracteres y máximo 16 caracteres, solo minúsculas y espacios");
        correcto = false;
    }

    if(!$("#fecha").val()){
        $("#error-fecha").text("Formato correcto [d]d/[m]m/aaaa y fecha posible");
        correcto = false;
    }

    if(!validaDescripcion($("#descripcion").val())){
        $("#error-descripcion").text("Mínimo 12 y máximo 1024 caracteres");
        correcto = false;
    }

    return correcto;
}

function validaNuevaObra(){
    var correcto = validaCampos();

    if(!$("#imagen").val()){
        $("#error-imagen").text("Debe añadir una imagen");
        correcto = false;
    }

    return correcto;
}

function buscaObra(){
    var titulo = $("#obra");
    var tipo = $("#tipo");

    var resultado = $("#resultado");
    resultado.html("");
    
    if(titulo.val().length < 2 && tipo.val() === ''){
        return;
    }

    $.ajax({
		url: "buscaObras.php",
		type: "POST",
		data: JSON.stringify({"titulo" : titulo.val(), "tipo" : tipo.val()}),
		contentType: "application/json;charset=utf-8",

		success: function(res){
			
			if(res.registros.length > 0){
                var caja = $('<div></div>').addClass('trabajos');

                var tabla = $('<table></table>');
                var fila = $('<tr></tr>');

                resultado.append(caja);
                caja.append(tabla);
                fila.html("<th>Autor</th>" +
                	"<th>Nombre del trabajo</th>" +
                	"<th>Fecha</th>" +
                	"<th>Tipo de trabajo</th>");
                tabla.append(fila);

                for(var i in res.registros){
                    var registro = $('<tr></tr>');

                    registro.html("<td><a href=\"autor.php?idautor=" + res.registros[i].idautor + "\">" + res.registros[i].nombre + "</a></td>" +
                            "<td><a href=\"trabajo.php?id_obra=" + res.registros[i].id_obra + "\">" + res.registros[i].titulo + "</a></td>" +
                            "<td>" + res.registros[i].fecha + "</td>" +
                            "<td>" + res.registros[i].tipo_obra + "</td>");

                    tabla.append(registro);
                }
            }
        },

		error: function(res){
			alert('Error:' + res.mensaje_error);
		}

	});

}

function megusta(id_obra){
    var botonLike = $('#me-gusta');
    var bandera = botonLike.text() == "Dejar de gustar";

    $.ajax({
		url: "registrarLike.php",
		type: "POST",
		data: JSON.stringify({"id_obra": id_obra, "bandera": bandera}),
		contentType: "application/json;charset=utf-8",

		success: function(res){

            if(res.realizado === true){
                $('#likes').text(res.likes);

                if(bandera){
                    botonLike.text("Me gusta");
                }else{
                    botonLike.text("Dejar de gustar");
                }                
            }
	    },

		error: function(res){
			alert('Error:' + res.mensaje_error);
		}

	});

}