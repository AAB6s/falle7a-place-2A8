function fetchDashboardData() {
  fetch("http://localhost/smart/View/Back_Office/charts.php")
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("totalVisitors").innerText = data.totalVisitors;
      document.getElementById("totalProducts").innerText = data.totalProducts;
      document.getElementById("totalServices").innerText = data.totalServices;
      document.getElementById("totalReclamations").innerText = data.totalReclamations;

      const totalRequests = data.serviceRequestsByStatus.reduce(
        (sum, item) => sum + item.count,
        0
      );
      document.getElementById("totalRequests").innerText = totalRequests;

      renderPieChart("usersRoleChart", data.usersByRole, "Users by Role");
      renderPieChart(
        "serviceRequestsChart",
        data.serviceRequestsByStatus,
        "Service Requests Status"
      );
      renderBarChart(
        "productsServicesBarChart",
        ["Products", "Services"],
        [data.totalProducts, data.totalServices]
      );
    })
    .catch((error) => console.error("Error fetching data:", error));
}
function renderPieChart(chartId, chartData, title) {
  const labels = chartData.map((item) => item.role_display || item.status);
  const values = chartData.map((item) => item.count);
  const ctx = document.getElementById(chartId).getContext("2d");
  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          data: values,
          backgroundColor: ["#4CAF50", "#FF5722", "#2196F3", "#FFC107"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        title: { display: true, text: title },
        legend: { position: "bottom" },
      },
    },
  });
}
function renderBarChart(chartId, labels, values) {
  const ctx = document.getElementById(chartId).getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Count",
          data: values,
          backgroundColor: ["#3F51B5", "#E91E63"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        title: { display: true, text: "Products vs Services" },
        legend: { display: false },
      },
    },
  });
}
fetchDashboardData();
setInterval(fetchDashboardData, 10000);
