const update = document.querySelectorAll('.update');

  update.forEach((elem) => {
    elem.addEventListener('click', () => { 
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

          $('#client').val(data.datooos.cliente)
          $('#tipo').val(data.datooos.tipo)
          
  
        }
      })
    });
  });





 