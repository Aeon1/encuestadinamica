$(document).ready(function() {
    $('#reporte, #simplificada').DataTable({
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar excel',
                        title: 'Respuestas de Encuesta',
                    }
                ]
            },
            topEnd: {
                search: {
                    placeholder: ''
                }
            },
        },
        // responsive: true,
        ordering: true,
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
        },
        
    });

    $('.js-colorlib-nav-toggle').on('click', function () {
        $('body').toggleClass('offcanvas');
    });

    $( "form" ).submit(function() {
        $('#loader').show();
    });

    $('#addSection').click(function() {
        $('#addSeccionModal').modal('show');
        $('#addSeccionModal').on('shown.bs.modal', function () {
            $("#formseccion input[name='seccion']").val($("#formseccion > #vorigina").val());
            $("#formseccion textarea[name='texto']").val('');
        });
        // var nextTab = $('#tabs li').length+1;
        // $('<li class="nav-item"><a href="#tab'+nextTab+'" class="nav-link" role="tab" aria-selected="true" data-toggle="tab">Seccion '+nextTab+'</a></li>').appendTo('#tabs');
        // $('<div class="tab-pane" id="tab'+nextTab+'"></div>').appendTo('.tab-content');
        // $('<br><button type="button" class="btn btn-info modalx" data-toggle="modal" data-target="#addQuestion" onclick="openModelQuestion('+nextTab+',)">Agregar Pregunta</button>').appendTo('#tab'+nextTab)
        // $('#tabs a:last').tab('show');
    });

    $(".modificarSeccion").click(function (e) {
        let s = $(this).data('seccion');
        let t = $(this).data('texto');
        $('#addSeccionModal').modal('show');
        $('#addSeccionModal').on('shown.bs.modal', function () {
            $("#formseccion input[name='seccion']").val(s);
            $("#formseccion textarea[name='texto']").val(t);
        });
    });

    $(".eliminarSeccion").click(function (e) {
        let s = $(this).data('seccion');
        
        $('#deleteSeccionModal').modal('show');
        $('#deleteSeccionModal').on('shown.bs.modal', function () {
            $("#formsecciondelete input[name='seccion']").val(s);
        });
    });


    
    $(".mostrar").on('change',function (e) {
        var e = $(this).val();
        var n = $(this).parent('div').data('nivel');
        if ( e != 0) {
            var nextElement = $(this).parent().nextUntil(".principal");
            nextElement.each(function( index ) {            
                let id = $(this).prop('id');
                if ($('#'+id).data('momento') == e || $('#'+id).data('momento') ==3 || $('#'+id).data('momento') == 0) {
                    if ($('#'+id).hasClass('oculto') && $('#'+id).data('nivel') == (n+1)) {
                        $($('#'+id)).show("slow");
                        if($('#'+id).data('obligatorio') == 1){
                            $('#'+id+' > select').prop("required",true);
                            $('#'+id+' > input').prop("required",true);
                            $('#'+id+' > textarea').prop("required",true);
                        }
                    }
                }else{
                    if ($('#'+id).hasClass('oculto') && $('#'+id).data('nivel') ==0) {
                        $($('#'+id)).hide("slow");
                        if($('#'+id).data('obligatorio') == 1){
                            $('#'+id+' > select').val('').removeAttr('required');
                            $('#'+id+' > input').val('').removeAttr("required");
                            $('#'+id+' > textarea').val('').removeAttr("required");
                        }
                    }else{
                        if ($('#'+id).data('nivel') == (n+1)) {
                            $($('#'+id)).hide("slow");
                            if($('#'+id).data('obligatorio') == 1){
                                $('#'+id+' > select').val('').removeAttr('required');
                                $('#'+id+' > input').val('').removeAttr("required");
                                $('#'+id+' > textarea').val('').removeAttr("required");
                            }
                        }
                    }
                }
            });
        } else {
            var nextElement = $(this).parent().nextUntil(".principal");
            nextElement.each(function( index ) {            
                let id = $(this).prop('id');
                if ($('#'+id).hasClass('oculto')) {
                    $($('#'+id)).hide("slow");
                    if($('#'+id).data('obligatorio') == 1){
                        $('#'+id+' > select').val('').removeAttr('required');
                        $('#'+id+' > input').val('').removeAttr("required");
                        $('#'+id+' > textarea').val('').removeAttr("required");
                    }
                }
            });
        }
       
    });

    $('#inicio').trumbowyg({
        lang: 'es',
        btns: [
            ['myplugin'],
            ['viewHTML'],
            ['fontsize','foreColor', 'backColor'],
            ['strong', 'em'],
            ['justifyLeft','justifyCenter','justifyRight','justifyFull'],
            ['superscript','subscript'],
            ['insertImage', 'link'],
            ['historyUndo','historyRedo'],        
            ['unorderedList','orderedList'],
            ['horizontalRule'],
            ['indent', 'outdent','lineheight']
        ],plugins: {
            resizimg: {
                minSize: 64,
                step: 16,
            },
            fontsize: {
                sizeList: [
                    '12px',
                    '14px',
                    '16px',
                    '32px',
                    '42px',
                    '50px'
                ],
                allowCustomSize: true
            }
        }
    });

    $('#instrucciones,#fin,#cerrada').trumbowyg({
        lang: 'es',
        btns: [
            ['viewHTML'],
            ['fontsize','foreColor', 'backColor'],
            ['strong', 'em'],
            ['justifyLeft','justifyCenter','justifyRight','justifyFull'],
            ['superscript','subscript'],
            ['insertImage', 'link'],
            ['historyUndo','historyRedo'],        
            ['unorderedList','orderedList'],
            ['horizontalRule'],
            ['indent', 'outdent','lineheight']
        ],plugins: {
            resizimg: {
                minSize: 64,
                step: 16,
            },
            fontsize: {
                sizeList: [
                    '12px',
                    '14px',
                    '16px',
                    '32px',
                    '42px',
                    '50px'
                ],
                allowCustomSize: true
            }
        }
    });

    $('#instruccionModal').on('shown.bs.modal', function () {
        $('#instruccionModal .modal-body').html($('#instrucciones').val());
    });

    $('.dltqt').click(function (e) {
        var d = $(this).data('delete');
        const x = $(this).parent('div');
        x.hide('slow');
        $.get('/Encuesta/Preguntas/Eliminar/'+d,function( data ) {
            if(data == 200){
                x.remove();
            }else{
                $('body').prepend('<div class="alert alert-warning alert-block text-center"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+data+'</strong></div>');
                x.show('slow');
            }
            
        });
    });
    var startTime,endTime = 0
    $(".bntcmp").on('mousedown',function() {
        startTime = new Date();
    })
    $(".bntcmp").on('mouseup',function() {
        endTime = new Date();
        var timeDiff = endTime - startTime;
        if(timeDiff > 2000){
            Swal.fire({
                title: 'Eliminando campo...',
                html: 'Por favor espere...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading()
                }
              });
                var url = "/Encuesta/Registro/Eliminar/Campo/"+$(this).data('tipo');
                $.get(url,function(data) {
                    swal.close();
                    var r = JSON.parse(data);
                    if(r.respuesta == 1){
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: 'Por favor intente de nuevo',
                        });
                    }
                });
            $(this).remove();
        }
    })
    $(".bntcmp").click(function (e) {
        var c = $(this).data('campo');
        var n = $(this).data('nombre');
        var ty = $(this).data('tipo');
        var t = $(this).text();
        var ct = $('#template').val();
        if (c == 1) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<input type="text" class="form-control" name="'+n+'" id="'+n+'"></div>');
        }
        if (c == 2) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<input type="number" class="form-control" name="'+n+'" id="'+n+'"></div>');
        }
        if (c == 3) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<input type="email" class="form-control" name="'+n+'" id="'+n+'"></div>');
        }
        if (c == 4) {//selects normales
            // $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            // '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            // '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'"><input type="checkbox" class="form-check-input chko" id="'+n+'" checked>Obligatorio</label></div>'+
            // '<input type="number" class="form-control" name="'+n+'" id="'+n+'"></div>');
        }
        if (c == 5) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<textarea name="'+n+'" id="'+n+'" class="form-control" cols="30" rows="3"></textarea></div>');
        }
        if (c == 6) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<select class="form-control" name="'+n+'" id="'+n+'"><option>Seleccionar</option></select></div>');
            $.get("/Encuesta/Registro/Datos/1",function (datos) {
                $.each(JSON.parse(datos), function(i,item){
                    $("#formTemplate #"+n).append("<option>"+item['area']+"</option>");
                })
            });
        }
        if (c == 7) {
            $('#formTemplate').append('<div class="form-group" registro="'+ty+'*1"><label for="'+n+'">'+t+'</label>'+
            '<button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>'+
            '<div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="'+n+'x"><input type="checkbox" class="form-check-input chko" id="'+n+'x" checked>Obligatorio</label></div>'+
            '<select class="form-control" name="'+n+'" id="'+n+'"><option>Seleccionar</option></select></div>');
            $.get("/Encuesta/Registro/Datos/2",function (datos) {
                $.each(JSON.parse(datos), function(i,item){
                    $("#formTemplate #"+n).append("<option>"+item['nivel']+"</option>");
                })
            });
        }

        $(".chko").click(function(e) {
            var l = $(this);
            if (!l.is(':checked')) {
                const x = l.parent('label').parent('div').parent('div');
                var d = x.attr('registro');
                var v = d.split('*');
                x.attr('registro',v[0]+'*0')
            }else{
                const x = l.parent('label').parent('div').parent('div');
                var d = x.attr('registro');
                var v = d.split('*');
                x.attr('registro',v[0]+'*1')
            }            
        });

       

        $(".dltcmp").click(function(e){
            const x = $(this).parent('div');
            x.hide('slow',function () {
                x.remove();
            });
        });

    });

    $("#generarRegistro").click(function (e) {
        var t = '';
        $('#formTemplate .form-group').each(function( index ) {
            t +=$( this ).attr('registro')+',';
        });
        $("#template").val(t);
        $("#send-template-registro").submit();
    });

    $(".chko").click(function(e) {
        var l = $(this);
        if (!l.is(':checked')) {
            const x = l.parent('label').parent('div').parent('div');
            var d = x.attr('registro');
            var v = d.split('*');
            x.attr('registro',v[0]+'*0')
        }else{
            const x = l.parent('label').parent('div').parent('div');
            var d = x.attr('registro');
            var v = d.split('*');
            x.attr('registro',v[0]+'*1')
        }            
    });

   

    $(".dltcmp").click(function(e){
        const x = $(this).parent('div');
        x.hide('slow',function () {
            x.remove();
        });
    });

    

});

function openModelQuestion(seccion,pregunta) {
    var lk = '';
    var id_encuesta = $('#id_encuesta').val();
    if (pregunta) {
        lk ="../../Modal/"+seccion+'/'+id_encuesta+'/'+pregunta
    }else{
        lk = "../../Modal/"+seccion+'/'+id_encuesta
    }
    
    $('#addQuestion .modal-body').load(lk,function(){
        $('#addQuestion').modal({show:true});
        $('#addQuestion .modal-title').text('Agregar pregunta a sección ' + seccion)
        $("#asignacion").change(function() {
            if($(this).val() != 0){
                $('#timeShowWhen').removeClass('d-none');
                $('#subnivel').val($('#asignacion option:selected').data('level')+1);
                $('#orden').val($('#asignacion option:selected').data('orden')+0.01);
            }else{
                $("#timeShowWhen option:selected").prop("selected", false);
                $('#timeShowWhen').addClass('d-none');
                $('#subnivel').val(0);
                $('#orden').val($('#originalOorden').val());
            }            
        });
        $('#nivel,#area').val('');

        $('#nivel,#area').multiselect({
            includeSelectAllOption: true,
            nonSelectedText:'Seleccionar',
            selectAllText:'Todos',
            selectAllValue:0
          });
    
        $('input[name=tipo]').click(function() {
            var nopt = $(this).data('option');
            if($("#typeQuestion"+nopt).is(':checked')) {
                $(".oqf").addClass('d-none');
                $("#oq"+nopt).removeClass('d-none');
            }
        })
    
        $("#addOptionQuestion").click(function() {
            var nextInput = $('#oqc input').length+1;
            $('<div class="form-group input-group"><input type="text" class="form-control" name="oqp[]" aria-describedby="button-addon'+nextInput+'">'+
            '<span class="input-group-btn"><button class="btn btn-default delete" type="button" id="button-addon'+nextInput+'"><i class="bi bi-node-minus-fill" style="color:red"></i></button></span></div>').appendTo('#oqc');
            $('.delete').click(function() {
                $(this).closest('div').remove();
            })
        });
    });
}