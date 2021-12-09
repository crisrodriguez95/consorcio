
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
    formulario.tipo = tipo;


    for (i in dataform) {
      formulario[dataform[i]['name']] = dataform[i]['value']
    }
    formulario.cedula = $('#cedula').prop('checked') 
    formulario.papeleta = $('#papeleta').prop('checked') 
    formulario.bienes = $('#bienes').prop('checked') 
    formulario.enagenado = $('#enagenado').prop('checked') 
    formulario.pvalores = $('#pvalores').prop('checked') 
    formulario.minuta = $('#minuta')[0].files[0].name
    formulario.archivoMinuta = $('#minuta')[0].files[0];
    formulario.comprobantep = $('#comprobantep')[0].files[0].name
    formulario.archivoComprobante = $('#comprobantep')[0].files[0];
    formulario.aprobarPagoCliente = aprobacion
    console.log(formulario);
    // $.ajax({
    //   data: formulario,
    //   error: function () {
    //    alert("Llene todos los campos");
    //   },
    // }).done(function (data) {
    //   if (data.Estado == 'Error') {
    //     return false
    //   } else {
    //     form[0].reset()
    //     $('.modal').modal('hide')
    //     success.style.display= 'block';  
    //     success.setAttribute('class', 'success');
    //     setTimeout(() => {
    //       success.setAttribute('class', 'message');
    //       location.reload(true)
    //     }, 1000)
    //   }
    // })
  }

  return {
    init: () => {
      inicio()
    },
  }
})()
