// Retrieve data from data attributes
var sumpaidData = JSON.parse(document.currentScript.getAttribute("data-sumpaid"));
var monthsData = JSON.parse(document.currentScript.getAttribute("data-months"));
var packageservicesData = JSON.parse(document.currentScript.getAttribute("data-packageservices"));
var packagenamesData = JSON.parse(document.currentScript.getAttribute("data-packagenames"));

// Function to get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
      var colors = document.getElementById(chartId).getAttribute("data-colors");
      colors = JSON.parse(colors);
      return colors.map(function (value) {
        var newValue = value.replace(" ", "");
  
        if (newValue.indexOf(",") === -1) {
          var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
          if (color) return color; else return newValue;
        } else {
          var val = value.split(',');
  
          if (val.length == 2) {
            var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
            rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
            return rgbaColor;
          } else {
            return newValue;
          }
        }
      });
    }
  }

// Define function to create and render a bar chart
function renderBarChart() {
  var chartPieBasicColors = getChartColorsArray("revenue_bar_chart");

  var options = {
    series: [{
      name: 'Revenue',
      data: sumpaidData
    }],
    chart: {
      height: 400,
      type: 'bar'
    },
    xaxis: {
      categories: monthsData
    },
    yaxis: {
      title: {
        text: 'Amount'
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        distributed: true
      }
    },
    legend: {
      position: 'bottom'
    },
    dataLabels: {
      enabled: false
    },
    colors: chartPieBasicColors
  };

  var chart = new ApexCharts(document.querySelector("#revenue_bar_chart"), options);
  chart.render();
}

// Define function to create and render a pie chart
function renderPieChart() {
  var chartPieBasicColors = getChartColorsArray("service_pie_chart");

  var options = {
    series: packageservicesData,
    chart: {
      height: 430,
      type: 'pie'
    },
    labels: packagenamesData,
    legend: {
      position: 'bottom'
    },
    dataLabels: {
      dropShadow: {
        enabled: false
      }
    },
    colors: chartPieBasicColors
  };

  var chart = new ApexCharts(document.querySelector("#service_pie_chart"), options);
  chart.render();
}

// Function to fetch initial data
function fetchInitialData() {
  // Your AJAX request to fetch initial data goes here
}

// Call functions to render charts and fetch initial data
renderBarChart();
renderPieChart();
fetchInitialData();
