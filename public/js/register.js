var PAGE = (function () {
  const form1 = document.querySelector('.user')
  var form = $('form.user')

  var inicio = function () {
    form.unbind().on('submit', function (e) {
      const formData = new FormData(form1)
      for (let [key, entry] of formData) {
        console.log(key, entry)
        if (entry == '') {
          return
        }
      }
      e.preventDefault()
      ingreso(this)
      return false
    })
  }
  var ingreso = (f) => {
    var formulario = {},
      dataform = form.serializeArray()
    console.log(dataform)
    formulario.tipo = 1

    for (i in dataform) {
      formulario[dataform[i]['name']] = dataform[i]['value']
    }
    console.log(formulario)
    $.ajax({
      data: formulario,
      error: function () {
        alert('error')
      },
    }).done(function (data) {
      if (data.Estado == 'Error') {
        alert('hay un error')

        return false
      } else {
        alert('Afiliado ingresado correctamente')
        form[0].reset()
      }
    })
  }

  return {
    init: () => {
      inicio()
    },
  }
})()
