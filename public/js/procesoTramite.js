
var PAGE = (function () {
  
  var form = $('form.proceso');
  const cedula = document.getElementById("cedula").checked,
  botonSi = $('#modal-btn-si'),
  botonNo = $('#modal-btn-no');
  let tipo = "";
  let id = "";
  let aprobacion="";


  botonSi.on('click', ()=> {
    aprobacion = 'true'
    alert('aaa')
  })
  botonNo.on('click', ()=> {
    aprobacion = 'false'
  })
  
  var inicio = function () {
    console.log(cedula);
    form.unbind().on('submit', function (e) {
     // const formData = new FormData(form1)
      console.log('aqui')
      
      ingreso(this)
      return false;
    })
  }
  var ingreso = (f) => {

    var formulario = {},
    dataform = form.serializeArray()

    if(tipo == 2){
      formulario.id = id; 
    }

    console.log(dataform);
    formulario.tipo = 10;


    for (i in dataform) {
      formulario[dataform[i]['name']] = dataform[i]['value']
    }
    formulario.cedula = $('#cedula').prop('checked') 
    formulario.papeleta = $('#papeleta').prop('checked') 
    formulario.bienes = $('#bienes').prop('checked') 
    formulario.enagenado = $('#enagenado').prop('checked') 
    formulario.pvalores = $('#pvalores').prop('checked') 
    formulario.minuta = $('#minuta')[0].files[0].name ? $('#minuta')[0].files[0].name : null;
    //formulario.archivoMinuta = $('#minuta')[0].files[0]? $('#minuta')[0].files[0]: null;
    formulario.comprobantep = $('#comprobantep')[0].files[0].name ? $('#comprobantep')[0].files[0].name : null
    //formulario.archivoComprobante = $('#comprobantep')[0].files[0] ? $('#comprobantep')[0].files[0] : null;
    formulario.aprobarPagoCliente = aprobacion
    formulario.idTramite = $('#idTramite').val() 
    console.log(formulario);
    
    $.ajax({
      type: "POST",
      url: "../actualizarTramite",
      data: formulario,
      cache: false,
      contentType: false,
      processData: false,
      error: function () {
       alert('sajadh');
      }
  }).done(function (data) {
      
      //form[0].reset();
      //swalInit('Se ha guardado postulación con éxito', 'success', 5000);
  });
    //return false;
  }

  return {
    init: () => {
      inicio()
    },
  }
})()
