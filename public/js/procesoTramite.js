var PAGE = (function () {
  var form = $('form.proceso')

  const cedula = document.getElementById('cedula').checked,
    success = document.querySelector('.message'),
    formula = document.querySelector('.proceso'),
    botonSi = $('#modal-btn-si'),
    botonNo = $('#modal-btn-no')

  botonSi.on('click', () => {
    aprobacion = 'true'
    alert('aaa')
  })
  botonNo.on('click', () => {
    aprobacion = 'false'
  })

  var inicio = function () {
    console.log(cedula)
    form.unbind().on('submit', function (e) {
      ingreso(this)
      return false
    })
  }
  var ingreso = (f) => {
    const formData = new FormData(formula)

    formData.append('tipo', 1)
    formData.append('cedula', $('#cedula').prop('checked'))
    formData.append('papeleta', $('#papeleta').prop('checked'))
    formData.append('bienes', $('#bienes').prop('checked'))
    formData.append('enagenado', $('#enagenado').prop('checked'))
    formData.append('pvalores', $('#pvalores').prop('checked'))
    formData.append('pagoNotarial', $('#pagoNotarial').prop('checked'))
    formData.append('esMutualista', $('#esMutualista').prop('checked'))
    formData.append(
      'entregadoMutualista',
      $('#entregadoMutualista').prop('checked'),
    )
    formData.append('entregaNotaria', $('#entregaNotaria').prop('checked'))
    formData.append('entregaRP', $('#entregaRP').prop('checked'))
    formData.append('clienteAprueba', $('#clienteAprueba').prop('checked'))
    formData.append('tituloPago', $('#tituloPago').prop('checked'))
    formData.append('pagoTitulo', $('#pagoTitulo').prop('checked'))
    formData.append('escrituraVali', $('#escrituraVali').prop('checked'))
    formData.append('pagoGastos', $('#pagoGastos').prop('checked'))

    $.ajax({
      url: '../actualizarTramite',
      type: 'POST',
      dataType: 'html',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      error: function () {
        alert('Error')
      },
    }).done(function (data) {
      success.style.display = 'block'
      success.setAttribute('class', 'success')
      setTimeout(() => {
        success.setAttribute('class', 'message')
        location.reload(true)
      }, 1000)
      //form[0].reset();
      //swalInit('Se ha guardado postulación con éxito', 'success', 5000);
    })
    //return false;
  }

  return {
    init: () => {
      inicio()
    },
  }
})()
