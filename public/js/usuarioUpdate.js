const update = document.querySelectorAll('.update')

update.forEach((elem) => {
  elem.addEventListener('click', () => {
    id = elem.dataset.id
    $.ajax({
      data: {
        tipo: 7,
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
        $('#id').val(data.datooos.cedula)
        $('#name').val(data.datooos.nombre)
        $('#lastName').val(data.datooos.apellido)
        $('#email').val(data.datooos.correo)
        $('#email').val(data.datooos.correo)
        $('#password').val(data.datooos.password)
        $('#id_rol').val(data.datooos.rol)
        $('#estatus').val(data.datooos.estado)
      }
    })
  })
})
