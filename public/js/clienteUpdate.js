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
        $('#civil').val(data.datooos.estadoCivil)
        $('#phone').val(data.datooos.telefono)
        $('#mobil').val('0' + data.datooos.movil)
        $('#address').val(data.datooos.direccion)
        $('#email').val(data.datooos.email)
        $('#estatus').val(data.datooos.estado)
      }
    })
  })
})
