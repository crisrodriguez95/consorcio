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

          $('#client').val(data.datooos.cliente)
          $('#tipo').val(data.datooos.tipo)
          
  
        }
      })
    });
  });





 