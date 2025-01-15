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
          <td class="action-buttons">
              <a href="projects/view/view_project.php?project_id=${escapeHtml(project.project_unique_id)}" class="view-btn">
                  <i class="fas fa-eye" style="font-size: 12px; color: #36b9cc;"></i> 
              </a>
              <!-- <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProjectModal" data-project-id="<?php echo $project['project_unique_id']; ?>">
                  <i class="fas fa-pencil-alt" style="font-size: 10px; color: #36b9cc;"></i>
              </button> -->
              <style>
                  .view-btn i {
                      font-size: 10px;
                      color: #36b9cc;
                      transition: color 0.3s ease, transform 0.3s ease;
                  }

                  .view-btn:hover i {
                      color: #009394; /* Change to desired hover color */
                      transform: scale(1.2); /* Slightly enlarge the icon */
                  }
              </style>
          </td>
        </tr>`;
      $('#appUserTable tbody').append(rowHtml);
    });
  }

  // Populate dropdown menus and set up filtering
function populateDropdowns(projects) {
  const months = new Set();
  const accountManagers = new Set();
  const projectIds = new Set();

  projects.forEach((project) => {
    if (project.start_date && !isNaN(Date.parse(project.start_date))) {
      const month = new Date(project.start_date).toLocaleString('default', {
        month: 'long',
      });
      months.add(month);
    }
    accountManagers.add(project.account_manager);
    projectIds.add(project.project_unique_id);
  });

  // Populate and attach event listeners to months dropdown
  $('#monthsDropdownMenu').empty();
  months.forEach((month) => {
    $('#monthsDropdownMenu').append(
      `<li><a class="dropdown-item month-item" href="#" data-month="${month}">${month}</a></li>`
    );
  });

  // Populate and attach event listeners to account managers dropdown
  $('#usersDropdownMenu').empty();
  accountManagers.forEach((manager) => {
    $('#usersDropdownMenu').append(
      `<li><a class="dropdown-item manager-item" href="#" data-manager="${manager}">${manager}</a></li>`
    );
  });

  // Populate and attach event listeners to projects dropdown
  $('#projectsDropdownMenu').empty();
  projectIds.forEach((id) => {
    $('#projectsDropdownMenu').append(
      `<li><a class="dropdown-item project-item" href="#" data-project-id="${id}">${id}</a></li>`
    );
  });

  // Attach filtering logic
  attachFilteringLogic(projects);
}

function attachFilteringLogic(projects) {
  // Filter by month
  $(document).on('click', '.month-item', function () {
    const selectedMonth = $(this).data('month');
    const filteredProjects = projects.filter((project) => {
      if (!project.start_date || isNaN(Date.parse(project.start_date))) {
        return false;
      }
      const projectMonth = new Date(project.start_date).toLocaleString(
        'default',
        { month: 'long' }
      );
      return projectMonth === selectedMonth;
    });

    updateCards(filteredProjects);
    generateHorizontalBarChart(filteredProjects);
    generatePieChart(filteredProjects);
  });

  // Filter by account manager
  $(document).on('click', '.manager-item', function () {
    const selectedManager = $(this).data('manager');
    const filteredProjects = projects.filter(
      (project) => project.account_manager === selectedManager
    );

    updateCards(filteredProjects);
    generateHorizontalBarChart(filteredProjects);
    generatePieChart(filteredProjects);
  });

  // Filter by project ID
  $(document).on('click', '.project-item', function () {
    const selectedProjectId = $(this).data('project-id');
    const filteredProjects = projects.filter(
      (project) => project.project_unique_id === selectedProjectId
    );

    updateCards(filteredProjects);
    generateHorizontalBarChart(filteredProjects);
    generatePieChart(filteredProjects);
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
    .filter(
      (project) =>
        project.duration !== 'NA' && 
        !isNaN(Date.parse(project.start_date)) && 
        !isNaN(Date.parse(project.end_date))
    )
    .map((project) => parseInt(project.duration));

  const avgDuration =
    durations.length > 0
      ? Math.round(durations.reduce((a, b) => a + b, 0) / durations.length)
      : 0;

  $('#avgDuration').text(`${isNaN(avgDuration) ? 0 : avgDuration}`);
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


function generatePieChart(projects) {
  const statusCounts = projects.reduce((counts, project) => {
    const status = project.status.trim(); // Ensure status is clean
    counts[status] = (counts[status] || 0) + 1; // Increment status count
    return counts;
  }, { Completed: 0, Ongoing: 0, Cancelled: 0, 'Not Yet Started': 0 }); // Initialize all statuses

  const ctx = document.getElementById('projectStatusChart').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Completed', 'Ongoing', 'Cancelled', 'Not Yet Started'],
      datasets: [
        {
          data: [
            statusCounts.Completed,
            statusCounts.Ongoing,
            statusCounts.Cancelled,
            statusCounts['Not Yet Started'],
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
