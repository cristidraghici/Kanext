(function() {
  $('.c3_project_stats').each(function() {
    var element = $(this);
    var id = element.attr('id');
    var stats = element.data('stats');

    if (stats.lengh === 0) {
      return;
    }

    c3.generate({
      bindto: '#' + id,
      data: {
        columns: stats,
        type: 'bar'
      },
      padding: {
        left: 10,
        right: 10
      },
      size: {
        height: 200
      },
      bar: {
        width: {
          ratio: 1
        },
        zerobased: true
      },
      axis: {
        rotated: true,
        x: {
          show: false
        },
        y: {
          show: true,
          inner: true,
          type: 'linear'
        }
      },
      grid: {
        x: {
          show: true
        },
        y: {
          show: true
        }
      },
      legend: {
        position: 'bottom'
      },
      tooltip: {
        format: {
          title: function (x, index) { return ''; }
        }
      }
    });

  });

}());
