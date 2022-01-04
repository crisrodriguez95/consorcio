$(document).ready(function () {
  let valor = '',
    i = 0,
    a = 0,
    b = 0,
    c = 0

  const id = $('#cedula'),
    papeleta = $('#papeleta'),
    bienes = $('#bienes'),
    pValores = $('#pvalores'),
    minuta = $('#minuta'),
    municipio = $('#vmunicipio'),
    comprobante = $('#comprobantep'),
    documentoFirmado = $('.documFirmado'),
    mutualista = $('#esMutualista'),
    labelMutualista = $('.mut'),
    li = $('.disabled'),
    next = li.next().children()

  // ---------- Ocultar o Mostrar boton siguiente --------------

  if (mutualista.prop('checked')) {
    documentoFirmado.css({ display: 'block' })
    labelMutualista.css({ margin: '3px' })
  } else {
    documentoFirmado.css({ display: 'none' })
    labelMutualista.css({ margin: '0 0 20px 0' })
  }
  mutualista.on('click', () => {
    if (mutualista.prop('checked')) {
      documentoFirmado.css({ display: 'block' })
      labelMutualista.css({ margin: '3px' })
    } else {
      documentoFirmado.css({ display: 'none' })
      labelMutualista.css({ margin: '0 0 20px 0' })
    }
  })
})
