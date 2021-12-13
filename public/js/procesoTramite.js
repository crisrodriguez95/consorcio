
var PAGE = (function () {
  
  var form = $('form.proceso');
 
  const cedula = document.getElementById("cedula").checked,
  formula = document.querySelector(".proceso");
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
      
      ingreso(this)
      return false;
    })
  }
  var ingreso = (f) => {
    const formData = new FormData(formula);
    formData.append("tipo", 1);

    console.log(formData.get('cedula'))

    formData.append("cedula", $('#cedula').prop('checked'));
    formData.append("papeleta", $('#papeleta').prop('checked'));
    formData.append("bienes", $('#bienes').prop('checked'));
    formData.append("enagenado", $('#enagenado').prop('checked'));
    formData.append("pvalores", $('#pvalores').prop('checked'));
    formData.append("pagoNotarial", $('#pagoNotarial').prop('checked'));
    formData.append("esMutualista", $('#esMutualista').prop('checked'));
    formData.append("entregadoMutualista", $('#entregadoMutualista').prop('checked'));
    
    
    console.log(formData);
    
    $.ajax({
      url: "../actualizarTramite",
      type: "POST",
      dataType: "html",
      data: formData,
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
