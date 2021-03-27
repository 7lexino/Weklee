// Funcion para menu desplegable //
 $(document).ready(function(){
   
      $('.menulog ul ul').css({
	      position:"absolute",
		  display:"none"
	  });
	  
	  $('.menulog li').hover(function(){
	      $(this).find('> ul').stop(true, true).slideDown('slow');
      }, function(){
	      $(this).find('> ul').stop(true, true).slideUp('slow');
		 });
   
   });
// FIN DEL MENU DESPLEGABLE //

// Funcion para cargar paginas o elementos //
$(document).ready(function(){
	$("#registrarseinicio").click(function(evento){
		evento.preventDefault();
		$("#cargando").css("display", "inline");
		$("#destino").load("incluir/r.php", function(){
			$("#cargando").css("display", "none");
		});
	});
})

// Funcion para menu desplegable //
 $(document).ready(function(){
   
      $('.menuprincipal ul ul').css({
	      position:"absolute",
		  display:"none"
	  });
	  
	  $('.menuprincipal li').hover(function(){
	      $(this).find('> ul').stop(true, true).slideDown('slow');
      }, function(){
	      $(this).find('> ul').stop(true, true).slideUp('slow');
		 });
   
   });
// FIN DEL MENU DESPLEGABLE //

// Funcion para validar formularios //
$(document).ready(function () {
    var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    $(".btnlogin").click(function (){
        $(".error").remove();
        if( $(".emaillogin").val() == "" || !emailreg.test($(".emaillogin").val()) ){
            $(".emaillogin").focus().after("<span class='error'>Ingrese un email correcto</span>");
            return false;
        }else if( $(".passwordlogin").val() == "" ){
            $(".passwordlogin").focus().after("<span class='error'>Ingrese una contrase&ntilde;a</span>");
            return false;
        }
    });
    $(".emaillogin").keyup(function(){
        if( $(this).val() != "" && emailreg.test($(this).val())){
            $(".error").fadeOut();
            return false;
        }
    });
    $(".passwordlogin").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });
});
// FIN DE FUNCION DE VALIDACION //

// Funcion para validar formulario de AGREGAR POST //
$(document).ready(function () {
    $(".agregarpost").click(function (){
        $(".error").remove();
        if( $(".titulodelpost").val() == "" ){
            $(".titulodelpost").focus().after("");
            return false;
        }
    });
    $(".titulodelpost").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });
});
// FIN DE FUNCION DE VALIDACION //

// Funcion para validar formularios de Registro //
$(document).ready(function () {
    var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    $(".btnregistro").click(function (){
        $(".error").remove();
        if( $(".emailregistro").val() == "" || !emailreg.test($(".emailregistro").val()) ){
            $(".emailregistro").focus().after("<span class='error'>Ingrese un email correcto</span>");
            return false;
        }else if( $(".passwordregistro").val() == "" ){
            $(".passwordregistro").focus().after("<span class='error'>Ingrese una contrase&ntilde;a</span>");
            return false;
        }
		else if( $(".password2registro").val() == "" ){
            $(".password2registro").focus().after("<span class='error'>Ingrese una contrase&ntilde;a</span>");
            return false;
        }
		else if( $(".usuarioregistro").val() == "" ){
            $(".usuarioregistro").focus().after("<span class='error'>Ingrese uno, [Ya no se podra cambiar!]</span>");
            return false;
        }
    });
    $(".emailregistro").keyup(function(){
        if( $(this).val() != "" && emailreg.test($(this).val())){
            $(".error").fadeOut();
            return false;
        }
    });
    $(".passwordregistro").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });
	$(".password2registro").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });
	$(".usuarioregistro").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });
});
// FIN DE FUNCION DE VALIDACION //

// Funcion para que no aya ningun espacio en campo usuario //
function noespacios() {
		var er = new RegExp(/\s/);
		var web = document.getElementById('cdusuario_web').value;
		if(er.test(web)){
			alert('No se permiten espacios');
			return false;
		}
                else
			return true;
	}
// Fin de comprobacion de espacios //

//----- Aceptar terminos --------//
$(document).ready(function(){
	$("#aceptarterminos").click(function(evento){
		if ($("#aceptarterminos").attr("checked")){
			$("#fomrularioregistro").css("display", "block");
		}else{
			$("#fomrularioregistro").css("display", "none");
		}
	});
});
//---------------------------------//
//------------ Cargar imagen de perfil --------------//
$(document).ready(function(){
	$("#enlaceajax").click(function(evento){
		evento.preventDefault();
		$("#cargando").css("display", "inline");
		
	});
})
//---------------------------------------------------//

//-------- PARA CATECORIAS -------------//
function select_cat(Sel){
if (Sel.ad.selectedIndex != 0){
document.location=Sel.ad.options[Sel.ad.selectedIndex].value
}}

//----------- FRM_REG ------------//
$(document).ready(function() {
   // Mostramos el loader
    $().ajaxStart(function() {
        $('#loading_form_reg').show();
        $('#result_form_reg').hide();
    }).ajaxStop(function() {
        $('#loading_form_reg').hide();
        $('#result_form_reg').fadeIn('slow');
    });
   // Enviamos el formulario
    $('#myform_form_reg').submit(function() {
   // Definimos el metodo ajax, los datos
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                // Imprimimos la respuesta en el div result
                $('#result_form_reg').html(data);

            }
        })
       
        return false;
    });
})

//------------ form logueo ------- //
$(document).ready(function() {
   // Mostramos el loader
    $().ajaxStart(function() {
        $('#loading_form_log').show();
        $('#result_form_log').hide();
    }).ajaxStop(function() {
        $('#loading_form_log').hide();
        $('#result_form_log').fadeIn('slow');
    });
   // Enviamos el formulario
    $('#myform_form_log').submit(function() {
   // Definimos el metodo ajax, los datos
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                // Imprimimos la respuesta en el div result
                $('#result_form_log').html(data);

            }
        })
       
        return false;
    });
})

//-------- CARGAR FORMS Y OBJETOS -------/
function prehide(){
if (document.getElementById){
document.getElementById('preload').style.visibility='hidden'}
}
function preshow(){
if (document.getElementById){
document.getElementById('preload').style.visibility='visible'}
}

//------------ CONTADOR DE CARACTRES REGISTRO -------//
$(document).ready(function(){
		$('#testinput').jqEasyCounter({
			'maxChars': 18,
			'maxCharsWarning': 15
		});
});

// -----------
if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
else navegador=1;