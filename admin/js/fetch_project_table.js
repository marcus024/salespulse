$(document).ready(function () {
  $.ajax({
    url: 'x-nd/fetch_project_table.php', // Fetch projects
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.status === 'success') {
        const projects = response.data;

        // Populate dropdowns
        populateDropdowns(projects);

        // Update cards
        updateCards(projects);

        // Generate charts
        generateHorizontalBarChart(projects);
        generatePieChart(projects);
      } else {
        alert("Error: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
    },
  });

  function populateDropdowns(projects) {
    // Extract unique values for dropdowns
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

    // Populate months dropdown
    $('#monthsDropdownMenu').empty();
    months.forEach((month) => {
      $('#monthsDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${month}</a></li>`
      );
    });

    // Populate account managers dropdown
    $('#usersDropdownMenu').empty();
    accountManagers.forEach((manager) => {
      $('#usersDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${manager}</a></li>`
      );
    });

    // Populate projects dropdown
    $('#projectsDropdownMenu').empty();
    projectIds.forEach((id) => {
      $('#projectsDropdownMenu').append(
        `<li><a class="dropdown-item" href="#">${id}</a></li>`
      );
    });
  }

  function updateCards(projects) {
    // Total projects
    $('#totalProjects').text(projects.length);

    // Total account managers
    const uniqueManagers = new Set(
      projects.map((project) => project.account_manager)
    );
    $('#totalUsers').text(uniqueManagers.size);

    // Average duration
    const durations = projects
      .filter((project) => project.duration !== 'NA')
      .map((project) => parseInt(project.duration));
    const avgDuration =
      durations.length > 0
        ? Math.round(durations.reduce((a, b) => a + b, 0) / durations.length)
        : 0;
    $('#avgDuration').text(`${avgDuration} days`);
  }

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
        indexAxis: 'y',
        plugins: {
          legend: { display: false },
        },
        scales: {
          x: { beginAtZero: true },
        },
      },
    });
  }

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
});
