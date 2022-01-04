var PAGE = (function () {
  var form = $('form.user')
  const form1 = document.querySelector('.user'),
    eliminar = document.querySelectorAll('.eliminar'),
    crear = document.querySelector('.crear'),
    estado = document.querySelector('.estado'),
    update = document.querySelectorAll('.update'),
    success = document.querySelector('.message')

  let tipo = '',
    id = '',
    regex = new RegExp('[a-z0-9]+@[a-z]+.[a-z]{2,3}')

  crear.addEventListener('click', () => {
    tipo = 1
    form[0].reset()
    if (estado) {
      estado.style.display = 'none'
    }
  })

  update.forEach((elem) => {
    elem.addEventListener('click', () => {
      tipo = 2
      id = elem.dataset.id
      if (estado) {
        estado.style.display = 'block'
      }
    })
  })

  // ----------------Eliminado lógico ----------------
  eliminar.forEach((elem) => {
    elem.addEventListener('click', () => {
      let id = elem.dataset.id
      $.ajax({
        data: {
          tipo: 6,
          id,
        },
        error: function () {
          alert('error')
        },
      }).done(function (data) {
        if (data.Estado == 'Error') {
          alert('hay un error')
          return false
        } else {
          alert('Registro eliminado')
          form[0].reset()
        }
      })
    })
  })

  // ----------------- Submit ----------------
  var inicio = function () {
    form.unbind().on('submit', function (e) {
      ingreso(this)
      return false
    })
  }

  var ingreso = (f) => {
    var formulario = {},
      dataform = form.serializeArray()

    if (tipo == 2) {
      formulario.id = id
    }
    formulario.tipo = tipo
    for (i in dataform) {
      formulario[dataform[i]['name']] = dataform[i]['value']
    }
    // ----------------- Validaciones -----------------------
    const formData = new FormData(form1)
    for (let [key, entry] of formData) {
      // -------- Correo ------------
      if (key == 'correo') {
        if (regex.test(entry) == false) {
          console.log(entry)
          $('.modal').modal('hide')
          $('#correo').modal('show')
          return
        }
      }
      // -------- Cédula ------------
      if (key == 'cedula') {
        if (entry.length != 10) {
          console.log('object')
          $('.cls').click()
          $('#error').modal('show')
          return
        } else {
          num = entry.length
          array = entry.split('')
          console.log(entry)
          console.log(array)
          total = 0
          digito = array[9] * 1
          for (i = 0; i < num - 1; i++) {
            mult = 0
            if (i % 2 != 0) {
              total = total + array[i] * 1
            } else {
              mult = array[i] * 2
              if (mult > 9) total = total + (mult - 9)
              else total = total + mult
            }
          }
          decena = total / 10
          decena = Math.floor(decena)
          decena = (decena + 1) * 10
          final = decena - total
          if ((final == 10 && digito == 0) || final == digito) {
          } else {
            $('.cls').click()
            $('#error').modal('show')
            return
          }
        }
      }
      // -------- Celular ------------
      if (key == 'celular') {
        if (entry.length != 10) {
          $('.cls').click()
          $('#errorMobile').modal('show')
          return
        }
      }
      // -------- Teléfono ------------
      if (key == 'telefono') {
        if (entry.length != 7) {
          $('.cls').click()
          $('#errorMobile').modal('show')
          return
        }
      }
      // -------- Rol ------------
      if (
        key == 'id_rol' ||
        key == 'password' ||
        key == 'nombre' ||
        key == 'apellido'
      ) {
        if (entry == '') {
          alert('Llene todos los campos')
          return
        }
      }
    }
    console.log(formulario)
    $.ajax({
      data: formulario,
      error: function () {
        alert('Llene todos los campos')
      },
    }).done(function (data) {
      if (data.Estado == 'Error') {
        return false
      } else {
        form[0].reset()
        $('.cls').click()
        success.style.display = 'block'
        success.setAttribute('class', 'success')
        setTimeout(() => {
          success.setAttribute('class', 'message')
          location.reload(true)
        }, 1000)
      }
    })
  }

  return {
    init: () => {
      inicio()
    },
  }
})()
