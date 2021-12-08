const update = document.querySelectorAll('.update');

console.log(update);

  update.forEach((elem) => {
    console.log(update);
    elem.addEventListener('click', () => {
     tipo = 2;
      id = elem.dataset.id;
      $.ajax({
        data: {
          tipo: 7,
          id
        },
        error: function () {
          alert('error')
        },
      }).done(function (data) {
        if (data.Estado == 'Error') {
          alert('hay un error')
          return false
        } else {

          $('#id').val(data.datooos.cedula)
          $('#name').val(data.datooos.nombre)
          $('#lastName').val(data.datooos.apellido)
          $('#email').val(data.datooos.correo)
          $('#email').val(data.datooos.correo)
          $('#password').val(data.datooos.password)
          $('#estatus').val(data.datooos.estado)
  
        }
      })
    });
  });





 