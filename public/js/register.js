var PAGE = (function () {
  var form = $("form.user");
  var inicio = function () {
    form.unbind().on("submit", function () {
      
      ingreso(this);

      return false;
    });
  };
  var ingreso = function (f) {
    var formulario = {},
    dataform = form.serializeArray();
    console.log(dataform);
    formulario.tipo = 1;

    for (i in dataform) {
      formulario[dataform[i]["name"]] = dataform[i]["value"];
      console.log(dataform[i]["name"]);
    }
    console.log(formulario);
    $.ajax({
      data: formulario,
      error: function () {
        alert("error");
      },
    }).done(function (data) {
      if (data.Estado == "Error") {
        alert("hay un error");

        return false;
      } else {
        alert("Afiliado ingresado correctamente");
        form[0].reset();
      }
    });
  };

  return {
    init: () => {
      inicio();
    },
  };
})();
