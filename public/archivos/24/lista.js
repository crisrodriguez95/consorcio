var PAGE = function(){
    var tabla = $('table.lista'),
            formChanged = false,
            formD = false,
            buscar = $('.b-input'),
            form = $('form'),
            descarga = $('.descarga'),
            $window = $(window),
            isNoviBuilder = false,
            plugins = {preloader: $(".preloader")};
    function capitalizeFirstLetter(str)
    {
        return str.replace(/\w\S*/g, function(txt){
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }

    form.find('.caja').on('keydown keypress keyup change', 'input', function(){
        formChanged = true;
        formD = true;
    });

    var inicio = function(){
        $window.on('load', function(){
            if (plugins.preloader.length && !isNoviBuilder) {
                pageTransition({
                    target: document.querySelector('.page'),
                    delay: 0,
                    duration: 500,
                    classIn: 'fadeIn',
                    classOut: 'fadeOut',
                    classActive: 'animated',
                    conditions: function (event, link) {
                        return !/(\#|callto:|tel:|mailto:|:\/\/)/.test(link) && !event.currentTarget.hasAttribute('data-lightgallery') && !event.currentTarget.hasAttribute('data-rd-calendar') && !event.currentTarget.getElementsByClassName('getElementsByClassName');
                    },
                    onTransitionStart: function (options) {
                        setTimeout(function () {
                            plugins.preloader.removeClass('loaded');
                        }, options.duration * .75);
                    },
                    onReady: function () {
                        plugins.preloader.addClass('loaded');
                        windowReady = true;
                    }
                });
            }
        });
        buscar.find('.texto').attr({
            type: 'text',
            minlength: 3,
            maxlength: 20,
            required: true            
        }).css('text-transform', 'none');
        buscar.find('input[id="NA"]:radio').prop('checked', true);
        
        function valid(regexp){            
            form.find('.caja input[type=text]').unbind().bind('input paste cut', function(e){
                var val = '';                   
                for (i = 0; i <= $(this).val().length; i++) {
                    letra = $(this).val().substr(i, 1);                   
                    if (letra.match(regexp))
                    val += letra;                   
                }
                
                $(this).val(val);
            });        
        }
        valid(/^[A-Za-z\s]+$/);
        buscar.find('input[type="radio"]').change(function(){
                buscar.find('input.texto').val('')
            if ($(this).val() == 3) {  
                valid()
                buscar.find('input.texto').attr('type','date').css('text-transform', 'none');                                
                valid(/^\d{4}([\-/.])(0?[1-9]|1[1-2])\1(3[01]|[12][0-9]|0?[1-9])$/);
            } 
            else if ($(this).val() == 2){               
                buscar.find('input.texto').attr({
                    type: 'text',
                    minlength: 10,
                    maxlength: 33,
                }).css('text-transform', 'uppercase');
                valid(/^[A-Za-z0-9]+$/);
            } 
            else if ($(this).val() == 1){                
                buscar.find('input.texto').attr({
                    type: 'text',
                    minlength: 3,
                    maxlength: 20,
                }).removeNumeric().css('text-transform', 'none');
                valid(/^[A-Za-z\s]+$/);
            }
        });

        form.unbind().on('submit', function(){
            if (formChanged){
                formChanged = false;
                if ($('.texto').val().trim().length >= 3 )
                busqueda();
                else
                    swalInit('Escriba más parametros de busqueda', 'warning', 5000);
               
                return false;
            } else {
                return false;

            }
        });
        
        descarga.find('button').on('click', function(){            
          if(formD){
                formD = false;               
            if($(this).data('tipoBusqueda') && $(this).data('busqueda')){ 
                data = decodeURIComponent('radio='+$(this).data('tipoBusqueda')+'&texto='+$(this).data('busqueda'))            
                window.open('../busqueda?'+data, '_blank'); 
            }
            else
            swalInit('No se han encontrado registros de la busqueda', 'warning', 5000);
            }  else
            swalInit('Ya ha descargado', 'warning', 5000);               
            
        });

    };
    var busqueda = function () {
        plugins.preloader.removeClass('loaded');
        $.ajax({
            data: {
                tipo: 3,
                radio: buscar.find('input[name="buscar"]:checked').val(),
                texto: buscar.find('input.texto').val().trim()
            },
            error: function () {
                plugins.preloader.removeClass('loaded');
                swalInit('error', 'warning', 5000);
            }
        }).done(function (data) {
            if (data.Estado == 'Error') {
                tabla.find('tbody tr').hide();

                plugins.preloader.addClass('loaded');
                swalInit('No se han encontrado registros', 'warning', 5000);
                
                descarga.find('button').data('tipoBusqueda', '');
                descarga.find('button').data('busqueda', '');
                
                return false;
            }
            else {
                var registros = data.Datos.registros;
                tabla.find('tbody tr').hide();
                for (i in registros) {
                    tabla.append(
                            '<tr>' +
                            '<td >' + (parseInt(i) + 1) + '</td>' +
                            '<td >' + capitalizeFirstLetter(registros[i].nombre) + '</td>' +
                            '<td>' + registros[i].identificacion + '</td>' +
                            '<td>' + registros[i].fecha + '</td>' +
                            '<td>' +
                            '<a href="/modificar/' + registros[i].identificacion + '">modificar</a>' +
                            ' <a href="/ficha/' + registros[i].identificacion + '">ver</a>' +
                            '</td>' +
                            '</tr>'
                            );
                }
                
                descarga.find('button').data('tipoBusqueda', buscar.find('input[name="buscar"]:checked').val());
                descarga.find('button').data('busqueda', buscar.find('input.texto').val());                
                plugins.preloader.addClass('loaded');
                if (data.Datos.mensaje){
                    swalInit(data.Datos.mensaje, 'success', 19000,true);
                    
                    return false;
                }
          
            }
        });
    }
     

    var swalInit = function (title, icon, timer = 3000,confirm){
        Swal.fire({
            icon: icon,
            title: title,
            showConfirmButton: confirm,
            timer: timer,           
            confirmButtonText: 'Descargar'
            
        }).then((result) => {
            if (result.value)
            descarga.find('button').click();                      
        });       
        
    }
    
    var swalD = function (title){
            Swal.fire({
            title: title,                      
            confirmButtonText: 'Descargar'            
        }).then((result) => {
            if (result.value)
            descarga.find('button').click();                      
        })
    }
    
    return {
        init: function () {
            inicio();
        }
    }
}();




