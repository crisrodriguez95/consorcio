// Example starter JavaScript for disabling form submissions if there are invalid fields

;(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')
  var inputs = document.querySelectorAll('.inputText')
  let code = false
  let value = ''

  // Obtener valores números
  function getCode(field) {
    field.addEventListener('keydown', (e) => {
      e.keyCode > 47 && e.keyCode < 58 ? (code = true) : (code = false)
    })
    return code
  }

  inputs.forEach((input) => {
    input.addEventListener('input', () => {
      let code = getCode(input)
      if (!isNaN(input.value) || code == true) {
        input.value = value
      }
    })
  })

  // let cedula = document.querySelector('#id'),
  //   nombre = document.querySelector('#name'),
  //   apellido = document.querySelector('#lastName'),
  //   mobile = document.querySelector('#mobil'),
  //   phone = document.querySelector('#phone'),
  //   currentValue = '',
  //   nameValue = '',
  //   mobileValue = '',
  //   phoneValue = '',
  //   code = false

  // nombre.addEventListener('input', (e) => {
  //   let code = getCode(nombre)
  //   if (!isNaN(nombre.value) || code == true) {
  //     nombre.value = nameValue
  //   } else {
  //     nameValue = nombre.value
  //   }
  // })

  // function validarNumber(field, aux) {
  //   field.addEventListener('input', (e) => {
  //     field.value = e.target.value.trim()
  //     if (isNaN(field.value)) {
  //       field.value = aux
  //     } else {
  //       aux = field.value
  //     }
  //   })
  // }

  // validarNumber(cedula, currentValue)
  // validarNumber(mobile, mobileValue)
  // validarNumber(phone, phoneValue)

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener(
      'submit',
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      },
      false,
    )
  })
})()
