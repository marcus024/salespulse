
let selectedUser    = 'All';
let selectedProject = 'All';
let selectedMonth   = 'All';
let peakChart       = null;  // Chart.js instance

$(document).ready(function() {
    // Initial data load
    fetchAllData();

    // Dynamic event for user dropdown
    $('#usersDropdownMenu').on('click', '.dropdown-item-text', function() {
        selectedUser = $(this).text().trim();
        $('#selected-user').text(selectedUser);
        // Reset project to 'All' whenever a user changes
        selectedProject = 'All';
        $('#selected-project').text('Select');
        fetchAllData();
    });

    // Dynamic event for projects dropdown
    $('#projectsDropdownMenu').on('click', '.dropdown-item-text', function() {
        selectedProject = $(this).text().trim();
        $('#selected-project').text(selectedProject);
        fetchAllData();
    });

    // Month selection
    $('.month-item').on('click', function() {
        selectedMonth = $(this).data('month');
        $('#selected-month').text(selectedMonth);
        fetchAllData();
    });
});

// AJAX function
function fetchAllData() {
    $.ajax({
        url: 'x-nd/fetch_chart.php',
        type: 'POST',
        dataType: 'json',
        data: {
            selectedUser: selectedUser,
            selectedProject: selectedProject,
            selectedMonth: selectedMonth
        },
        success: function(response) {
            if (response.error) {
                console.error(response.error);
                return;
            }
            // Update Cards
            $('#totalUsers').text(response.totalUsers);
            $('#totalProjects').text(response.totalProjects);
            $('#avgDuration').text(response.avgDuration);

            // Update Users Dropdown
            updateUsersDropdown(response.usersList);

            // Update Projects Dropdown
            updateProjectsDropdown(response.projectsList);

            // Update Chart
            updateChart(response.chartData);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function updateUsersDropdown(usersList) {
    $('#usersDropdownMenu').empty();
    $('#usersDropdownMenu').append('<li><span class="dropdown-item-text">All</span></li>');
    usersList.forEach(userName => {
        $('#usersDropdownMenu').append('<li><span class="dropdown-item-text">' + userName + '</span></li>');
    });
}

function updateProjectsDropdown(projectsList) {
    $('#projectsDropdownMenu').empty();
    $('#projectsDropdownMenu').append('<li><span class="dropdown-item-text">All</span></li>');
    projectsList.forEach(proj => {
        $('#projectsDropdownMenu').append('<li><span class="dropdown-item-text">' + proj + '</span></li>');
    });
}

function updateChart(chartData) {
    // Convert all data points to integers.
    // parseInt() will drop any decimal portion.
    const intData = chartData.data.map(value => parseInt(value, 10) || 0);

    const ctx = document.getElementById('peakUsersChart').getContext('2d');
    if (peakChart) {
        peakChart.destroy();
    }
    
    peakChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Users',
                data: intData, 
                backgroundColor: 'rgba(54,185,204,0.2)',
                borderColor: 'rgba(54,185,204,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            responsive: true,
            // Use maintainAspectRatio + aspectRatio
            maintainAspectRatio: true,
            aspectRatio: 4, 
            scales: {
                x: {
                    ticks: { color: '#333' }
                },
                y: {
                    ticks: {
                        color: '#333',
                        // Optional: Force Y-axis to use integer steps
                        stepSize: 1
                    },
                    beginAtZero: true
                }
            }
        }
    });
}
