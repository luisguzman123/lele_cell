$(document).ready(function () {
  cargarTotales();
  cargarGrafico();
});

function cargarTotales() {
  $.ajax({
    url: 'controladores/dashboard.php',
    type: 'POST',
    data: { totales: true },
    success: function (res) {
      try {
        var data = JSON.parse(res);
        $('#recepciones_hoy').text(data.recepciones);
        $('#ventas_hoy').text(data.ventas);
      } catch (e) {
        console.error('Error parseando totales', e);
      }
    },
  });
}

function cargarGrafico() {
  $.ajax({
    url: 'controladores/dashboard.php',
    type: 'POST',
    data: { grafico: true },
    success: function (res) {
      try {
        var data = JSON.parse(res);
        var options = {
          chart: {
            type: 'bar',
            height: 350,
          },
          series: [
            {
              name: 'Recepciones',
              data: data.recepciones,
            },
            {
              name: 'Ventas',
              data: data.ventas,
            },
          ],
          xaxis: {
            categories: data.fechas,
          },
        };
        var chart = new ApexCharts(
          document.querySelector('#grafico-recepciones-ventas'),
          options
        );
        chart.render();
      } catch (e) {
        console.error('Error parseando grafico', e);
      }
    },
  });
}

