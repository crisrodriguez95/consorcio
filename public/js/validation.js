// Example starter JavaScript for disabling form submissions if there are invalid fields

;(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation');
  const inputsText = document.querySelectorAll('.inputText'), 
  inputsNumber = document.querySelectorAll('.number');
  let code = false, value = '', aux = '';


  // Obtener valores números
  function getCode(field) {
    field.addEventListener('keydown', (e) => {
      e.keyCode > 47 && e.keyCode < 58 ? (code = true) : (code = false)
    })
    return code
  }

  inputsText.forEach((input) => {
    input.addEventListener('input', () => {
      let code = getCode(input)
      if (!isNaN(input.value) || code == true) {
        input.value = value
      }
    })
  })

  inputsNumber.forEach((input) => {
    input.addEventListener('input', (e) => {
      input.value = e.target.value.trim()
      if (isNaN(input.value)) {
        input.value = aux
      } 
      // else {
      //   aux = input.value
      // }
    })
  })


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
