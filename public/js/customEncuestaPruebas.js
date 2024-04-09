$(document).ready(function() {
    const APP_NAME = $("#idstorage").val();
    // cargar la seccion correspondiente al avance
    $('fieldset').collapse({toggle: false});
    var f = '';
    for(let x of $(':required')){
        let cp = $(x).prop('name');
        if(localStorage.getItem(`${APP_NAME}.${cp}`) == null){
            f = $(x).closest('fieldset').attr('id');            
            break;
        }        
    }
    var fnx1 = $('.container .form-control');
    let vas1 = localStorage.getItem(`${APP_NAME}.areanum`);
    if( vas1 != null){
        for(let x of fnx1){
            let cp = $(x).data('areas');
            if (cp) {
                var areas = cp.toString().split(',');
                if(!areas.includes(vas1) && !areas.includes(0)){
                    $(x).parent('.form-group').remove();
                }
            }
        }
    }
    let vlv1 = localStorage.getItem(`${APP_NAME}.nivelnum`);
    if( vlv1 != null){
        for(let x of fnx1){
            let cp = $(x).data('niveles');
            if (cp) {
                var niveles = cp.toString().split(',');
                if(!niveles.includes(vlv1) && !niveles.includes(0)){
                    $(x).parent('.form-group').remove();
                }
            }            
        }
    } 

    if (f) {
        $(`#${f}`).collapse("show");        
        for (let y of $(`#${f} .form-control`)) {
            let n = $(y).attr('id');
            let e = $(`#${n}`).prop('nodeName');
            let v = localStorage.getItem(`${APP_NAME}.${n}`);
            if( v != null){
                if (e =='INPUT') {
                    $(`#${n}`).val(v);
                }
                if (e =='TEXTAREA') {
                    $(`#${n}`).text(v);
                }
                if (e =='SELECT') {
                    $("#"+n+" option[value="+v+"]").prop('selected', true);
                    setTimeout(function() {
                        $(`#${n}`).trigger("change");
                    }, 100);
                }
            }
        }
        $('#instruccionesModal').modal('show');
        progressbar($(`#${f} form`).prop('id'));
    }else{
        $('.container fieldset:last-child').collapse("show");
    }

    // mostrar u ocultar las preguntas
    $(".mostrar").on('change',function () {
        var e = $(this);
        var n = e.parent('div').data('nivel');
        if ( e.val() != "") {
            var nextElement = e.parent().nextUntil(".principal");
            nextElement.each(function( index ) {
                let id = $(this).prop('id');
                if (id) {
                    if ($('#'+id).data('momento') == e.val() || $('#'+id).data('momento') ==3 || $('#'+id).data('momento')  == 0) {
                        if ($('#'+id).hasClass('oculto') && $('#'+id).data('nivel') == (n+1)) {
                            $('#'+id).show('slow');
                            if($('#'+id).data('obligatorio') == 1){
                                $('#'+id+' > select').prop("required",true);
                                $('#'+id+' > input').prop("required",true);
                                $('#'+id+' > textarea').prop("required",true);
                            }
                        }
                    }else{
                        if ($('#'+id).hasClass('oculto') && $('#'+id).data('nivel') ==0) {
                            $('#'+id).hide('slow',function () {
                                progressbar($(e).closest('form').prop('id'));
                            });
                            if($('#'+id).data('obligatorio') == 1){
                                $('#'+id+' > select').val('').removeAttr('required');
                                $('#'+id+' > input').val('').removeAttr("required");
                                $('#'+id+' > textarea').val('').removeAttr("required");
                            }
                        }else{
                            if ($('#'+id).data('nivel') == (n+1)) {
                                $('#'+id).hide('slow',function () {
                                    progressbar($(e).closest('form').prop('id'));
                                });
                                if($('#'+id).data('obligatorio') == 1){
                                    $('#'+id+' > select').val('').removeAttr('required');
                                    $('#'+id+' > input').val('').removeAttr("required");
                                    $('#'+id+' > textarea').val('').removeAttr("required");
                                }
                            }
                        }
                    }
                }
                
            });
        } else{
            var nextElement = $(this).parent().nextUntil(".principal");
            nextElement.each(function( index ) {
                let id = $(this).prop('id');
                if ($('#'+id).hasClass('oculto') && $('#'+id).data('nivel') > n) {
                    $($('#'+id)).hide("slow",function () {
                        progressbar($(e).closest('form').prop('id'));
                    });
                    if($('#'+id).data('obligatorio') == 1){
                        $('#'+id+' > select').val('').removeAttr('required');
                        $('#'+id+' > input').val('').removeAttr("required");
                        $('#'+id+' > textarea').val('').removeAttr("required");
                    }
                }
            });
        }
    });
    
    $("form").submit(function(e){
        e.preventDefault();
        let form = $('form:visible').prop('id');
        let envio = $('form:visible').data('envio');
        if(document.getElementById(form).checkValidity()){
            let valores = $("#"+form).serializeArray();
            $.each( valores, function( key, value ) {
                if(value['value']){
                    if(value['name'] == 'area'){
                        localStorage.setItem(`${APP_NAME}.areanum`, value['value']);
                        localStorage.setItem(`${APP_NAME}.${value['name']}`, $('#area option:selected').text());
                        
                    }else if (value['name'] == 'nivel_jerarquico') {
                        localStorage.setItem(`${APP_NAME}.nivelnum`, value['value']);
                        localStorage.setItem(`${APP_NAME}.${value['name']}`, $('#nivel_jerarquico option:selected').text());
                    } else {
                        localStorage.setItem(`${APP_NAME}.${value['name']}`, value['value']);
                    }
                    
                }
            });
            if (envio == 'Finalizar') {
                $("#pbini").css('width','100%');
                $("#pbini .show").html('Avance general 100%');
                Swal.fire({
                    title: 'Guardando...',
                    html: 'Por favor espere...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                      Swal.showLoading()
                    }
                  });
                var datos = {}
                $.each( valores, function( key, value ) {
                    localStorage.setItem(`${APP_NAME}.${value['name']}`, value['value']);                    
                });
                for(let d of Object.entries(localStorage)){
                    datos[d[0].split('.').pop()] = d[1];
                }
                datos['_token'] =  $('meta[name="csrf-token"]').attr('content');
                var url = "Encuesta/Guardar";
                $.post(url, datos, function(data) {
                    swal.close();
                    var r = JSON.parse(data);
                    if(r.respuesta == 1){
                        for(let d of Object.entries(localStorage)){
                            if (d[0].split('.')[0] == APP_NAME) {
                                localStorage.removeItem(d[0]); 
                            }                            
                        }
                        window.location.href="Finalizada/";
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: 'Por favor intente de nuevo',
                        });
                    }
                });
            } else {
                $("#"+form).parent('fieldset').collapse("hide");
                $("#"+form).parent('fieldset').on('hidden.bs.collapse', function () {
                    $("#"+form).parent('fieldset').next().collapse("show");
                    $("#"+form).parent('fieldset').next().on('shown.bs.collapse', function () {  
                        progressbarprincipal();
                        $("#sb").css('width','0%');
                        $("#sb .show").html('0%');
                        let fnx = $("#"+form).parent('fieldset').next().attr('id');
                        let vas1 = localStorage.getItem(`${APP_NAME}.areanum`);
                        if( vas1 != null){
                            for(let x of $("#"+fnx+' .form-control')){
                                let cp = $(x).data('areas');
                                if (cp) {
                                    var areas = cp.toString().split(',');
                                    if(!areas.includes(vas1) && !areas.includes(0)){
                                        $(x).parent('.form-group').remove();
                                    }
                                }            
                            }
                        }
                        let vlv1 = localStorage.getItem(`${APP_NAME}.nivelnum`);
                        if( vlv1 != null){
                            for(let x of $("#"+fnx+' .form-control')){
                                let cp = $(x).data('niveles');
                                if (cp) {
                                    var niveles = cp.toString().split(',');
                                    if(!niveles.includes(vlv1) && !niveles.includes(0)){
                                        $(x).parent('.form-group').remove();
                                    }
                                }            
                            }
                        }
                        $('html, body').animate({scrollTop:0}, 1250);
                    });
                });
            }
        }
    });

    // guardar las respuestas
    $('#savex').click(function() {
        let form = $('form:visible').prop('id');
        let valores = $("#"+form).serializeArray();
        $.each( valores, function( key, value ) {
            if(value['value']){
                localStorage.setItem(`${APP_NAME}.${value['name']}`, value['value']);
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Guardado de avance',
            text: 'Se guardó su avance',
        });
    });
    
    progressbarprincipal();
    // barra de progreso por seccion
    $('.form-control').change(function (e) {
        // obtener el nombre del formulario
        let form = $(this).closest('form').prop('id');
        progressbar(form);
    });
});

function progressbarprincipal() {
    // barra de progreso general
    let total = 0;
    let zz = 0;
    let con = 0
    for(let x of $('fieldset')){
        if (total != 0 && $(x).is(':visible')) {
            zz = 1;
            con = total;
        }else{
        }
        total +=1;
    }
    if (zz == 1) {
        $("#pbini").css('width',(100/total)*con+'%');
        $("#pbini .show").html('Avance general '+Math.round((100/total)*con)+'%');
    }
    
}

function progressbar(id) {
    let total = 0;
    let visibles = 0;
    let contestadas = 0;
    for(let x of $(`#${id} .form-control`)){
        if ($(x).is(':visible')) {
            if ($(x).val()) {
                contestadas += 1; 
            }
            total += 1;
            visibles += 1;
        }else{
            total += 1;
        }
    }
    $("#sb").css('width',(100/visibles)*contestadas+'%');
    $("#sb .show").html(Math.round((100/visibles)*contestadas)+'%');
}