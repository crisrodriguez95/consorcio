
var PAGE = (function () {
  
  var form = $('form.user');
  const form1 = document.querySelector('.user'), 
  eliminar = document.querySelectorAll('.eliminar'),
  crear = document.querySelector('.crear'),
  estado = document.querySelector('.estado'),
  update = document.querySelectorAll('.update'),
  success = document.querySelector('.message'),
  error = document.querySelector('.message-error');
  let tipo = "";
  let id = "";
  

  crear.addEventListener("click", () => {
    tipo = 1; 
    form[0].reset();
    estado.style.display = 'none';
  });

  
  update.forEach((elem) => {
    elem.addEventListener('click', () => {
      tipo = 2;
      id = elem.dataset.id;
      if(estado){
        estado.style.display = 'block';    
      }
    });
  });
 

  eliminar.forEach((elem) => {
    elem.addEventListener('click', () => {
      let id = elem.dataset.id;
      $.ajax({
        data: {
          tipo: 6,
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
          alert('Registro eliminado')
          form[0].reset()
        }
      })
    });
  });

  

  var inicio = function () {
    form.unbind().on('submit', function (e) {
      const formData = new FormData(form1)

      // for (let [key, entry] of formData) {
      //   if (entry == '') {
      //     return
      //   }
      // }
      ingreso(this)
      return false
    })
  }
  var ingreso = (f) => {
    var formulario = {},
    dataform = form.serializeArray()

    if(tipo == 2){
      formulario.id = id; 
    }

    console.log(dataform);
    formulario.tipo = tipo; 

    for (i in dataform) {
      formulario[dataform[i]['name']] = dataform[i]['value']
    }
    console.log(formulario);
    $.ajax({
      data: formulario,
      error: function () {
       alert("Llene todos los campos");
      },
    }).done(function (data) {
      if (data.Estado == 'Error') {
        return false
      } else {
        form[0].reset()
        $('.modal').modal('hide')
        success.style.display= 'block';  
        success.setAttribute('class', 'success');
        setTimeout(() => {
          success.setAttribute('class', 'message');
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
