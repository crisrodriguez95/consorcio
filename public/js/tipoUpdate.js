const update = document.querySelectorAll('.update');

  update.forEach((elem) => {
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

         $('#typeTramit').val(data.datooos.tramite)
         $('#observation').val(data.datooos.observacion)
         $('#tiempo').val(data.datooos.tiempo)
         $('#carga').val(data.datooos.carga)
  
        }
      })
    });
  });




 