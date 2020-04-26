window.kanextDashboardChartElements =

(function() {
  var chartConfiguration = {
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
        inner: false,
        type: 'linear',
        tick: {
          format: d3.format('d'),
          outer: false
        }
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
        title: function () { return ''; }
      }
    }
  }

  setTimeout(function () {
    $('.c3_project_stats').each(function() {
      var element = $(this);
      var id = element.attr('id');
      var stats = element.data('stats');

      if (stats.lengh === 0) {
        return;
      }

     var chart = c3.generate(Object.assign({
        bindto: '#' + id,
        data: {
          columns: stats,
          type: 'bar'
        },
        onmouseover: function () {
          chart.flush();
        },
        onmouseout: function () {
          chart.flush();
        }
      }, chartConfiguration));
    });
  }, 100);

}());
