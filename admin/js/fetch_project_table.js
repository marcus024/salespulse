$(document).ready(function () {
  $.ajax({
    url: 'x-nd/fetch_project_table.php', // Fetch projects
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.status === 'success') {
        const projects = response.data;

        // Populate table
        populateTable(projects);

        // Populate dropdowns
        populateDropdowns(projects);

        // Update cards
        updateCards(projects);

        // Generate charts
        generateHorizontalBarChart(projects);
        generatePieChart(projects);
      } else {
        alert("Error: " + response.message);
        console.error("Server error:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
      alert("An error occurred while fetching project data.");
    },
  });

  // Populate the project table
  function populateTable(projects) {
    $('#appUserTable tbody').empty();
    projects.forEach(function (project) {
      let rowHtml = `
        <tr>
          <td>${escapeHtml(project.project_unique_id)}</td>
          <td>${escapeHtml(project.client_name)}</td>
          <td>${escapeHtml(project.account_manager)}</td>
          <td>${escapeHtml(project.product_type)}</td>
          <td>${escapeHtml(project.source)}</td>
          <td>${escapeHtml(project.current_stage)}</td>
          <td>${escapeHtml(project.start_date)}</td>
          <td>${escapeHtml(project.end_date)}</td>
          <td style="color:${getStatusColor(project.status)}">${escapeHtml(project.status)}</td>
          <td>${escapeHtml(project.duration)}</td>
        </tr>`;
      $('#appUserTable tbody').append(rowHtml);
    });
  }

  // Populate dropdown menus
  function populateDropdowns(projects) {
    const months = new Set();
    const accountManagers = new Set();
    const projectIds = new Set();

    projects.forEach((project) => {
      if (project.start_date) {
        const month = new Date(project.start_date).toLocaleString('default', {
          month: 'long',
        });
        months.add(month);
      }
      accountManagers.add(project.account_manager);
      projectIds.add(project.project_unique_id);
    });

    $('#monthsDropdownMenu').empty();
    months.forEach((month) => {
      $('#monthsDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${month}</a></li>`
      );
    });

    $('#usersDropdownMenu').empty();
    accountManagers.forEach((manager) => {
      $('#usersDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${manager}</a></li>`
      );
    });

    $('#projectsDropdownMenu').empty();
    projectIds.forEach((id) => {
      $('#projectsDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${id}</a></li>`
      );
    });
  }

  // Update card values
  function updateCards(projects) {
    $('#totalProjects').text(projects.length);

    const uniqueManagers = new Set(
      projects.map((project) => project.account_manager)
    );
    $('#totalUsers').text(uniqueManagers.size);

    const durations = projects
      .filter((project) => project.duration !== 'NA')
      .map((project) => parseInt(project.duration));
    const avgDuration =
      durations.length > 0
        ? Math.round(durations.reduce((a, b) => a + b, 0) / durations.length)
        : 0;
    $('#avgDuration').text(`${avgDuration}`);
  }

// Generate the horizontal bar chart
function generateHorizontalBarChart(projects) {
  const accountManagerCounts = projects.reduce((counts, project) => {
    counts[project.account_manager] =
      (counts[project.account_manager] || 0) + 1;
    return counts;
  }, {});

  const labels = Object.keys(accountManagerCounts);
  const data = Object.values(accountManagerCounts);

  const ctx = document.getElementById('projectsPerAccountManagerChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Number of Projects',
          data: data,
          backgroundColor: '#36b9cc',
        },
      ],
    },
    options: {
      maintainAspectRatio: false, // Allow chart height customization
      indexAxis: 'y', // Horizontal bars
      plugins: {
        legend: { display: true },
      },
      scales: {
        x: {
          beginAtZero: true,
          ticks: {
            stepSize: 1, // Ensure step size is 1
            callback: function (value) {
              return Number(value).toFixed(0); // Force whole numbers
            },
          },
        },
      },
    },
  });
}


  // Generate the pie chart
  function generatePieChart(projects) {
    const statusCounts = projects.reduce(
      (counts, project) => {
        counts[project.status] =
          (counts[project.status] || 0) + 1;
        return counts;
      },
      { Completed: 0, Ongoing: 0, Cancelled: 0, 'Not yet Started': 0 }
    );

    const ctx = document.getElementById('projectStatusChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Completed', 'Ongoing', 'Cancelled', 'Not yet Started'],
        datasets: [
          {
            data: [
              statusCounts.Completed,
              statusCounts.Ongoing,
              statusCounts.Cancelled,
              statusCounts['Not yet Started'],
            ],
            backgroundColor: ['#28a745', '#007bff', '#dc3545', '#6c757d'],
          },
        ],
      },
      options: {
        plugins: {
          legend: { position: 'top' },
        },
      },
    });
  }

  // Helper functions
  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function getStatusColor(status) {
    switch (status) {
      case 'Completed':
        return 'green';
      case 'Ongoing':
        return 'blue';
      case 'Cancelled':
        return 'red';
      case 'Not yet Started':
        return 'gray';
      default:
        return '#000';
    }
  }
});
