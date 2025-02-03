$(document).ready(function() {
    fetchData();
    // Filter widget change event
    $('#filterWidget').on('change', function() {
        const selectedProject = $(this).val();

        // If "All" is selected, reset the filter
        if (selectedProject === "All") {
            fetchData(); // Fetch all projects
        } else {
            fetchData(selectedProject); // Fetch data for the selected project
        }
    });

    // Refresh button click event
    $('#refreshButton').on('click', function() {
        const selectedProject = $('#filterWidget').val();
        
        // If "All" is selected, reset the filter
        if (selectedProject === "All") {
            fetchData(); // Fetch all projects
        } else {
            fetchData(selectedProject); // Fetch data for the selected project
        }
    });
});

// Populate the filter dropdown with project names
function populateDropdown(data, selectedProject = 'All') {
    const filterWidget = $('#filterWidget');
    filterWidget.empty(); // Clear previous options

    // Add "All" option, and select it if no project is selected
    filterWidget.append('<option value="All" ' + (selectedProject === 'All' ? 'selected' : '') + '>All</option>');

    // Add options for each project
    data.forEach(project => {
        filterWidget.append(`
            <option value="${project.project_name}" ${selectedProject === project.project_name ? 'selected' : ''}>
                ${project.project_name}
            </option>
        `);
    });
}


function fetchData(filter = 'All') {
    $.ajax({
        url: './dirback/spcome_fetch_table.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {

            populateDropdown(data,"All");

            // Filter data based on selected project (if any)
            if (filter !== "All") {
                data = data.filter(project => project.project_name === filter);
            }


            updateCards(data);
            updateCharts(data);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
            alert('Failed to fetch project data. Please try again.');
        }
    });
}

function updateCards(data) {
    let totalProjects = data.length;
    let totalNetSales = data.reduce((sum, project) => sum + parseFloat(project.net_sales), 0);
    let totalGrossProfit = data.reduce((sum, project) => sum + parseFloat(project.gross_profit), 0);
    let totalCommission = data.reduce((sum, project) => sum + parseFloat(project.commission), 0);

    $('#calendar-container').html(`
        <div class="row" style="padding: 10px; gap: 4px; margin-top: -0.5rem;"> <!-- Reduced margin above cards -->
            <div class="rectangle-card" onclick="filterTable('Completed')">
                <i class="card-icon">
                    <img src="../images/completed_i.png" alt="icon" width="30" height="30">
                </i>
                <div class="card-content">
                    <div class="card-title" style="font-family:'Poppins'">Projects</div>
                    <div class="card-number" style="font-family:'Poppins'">${totalProjects}</div>
                </div>
            </div>
            <div class="rectangle-card" onclick="filterTable('Ongoing')">
                <i class="card-icon">
                    <img src="../images/ongoing_i.png" alt="icon" width="30" height="30">
                </i>
                <div class="card-content">
                    <div class="card-title" style="font-family:'Poppins'">Net Sales</div>
                    <div class="card-number" style="font-family:'Poppins'">Php ${totalNetSales.toLocaleString()}</div>
                </div>
            </div>
            <div class="rectangle-card" onclick="filterTable('Cancelled')">
                <i class="card-icon">
                    <img src="../images/cancelled_i.png" alt="icon" width="30" height="30">
                </i>
                <div class="card-content">
                    <div class="card-title" style="font-family:'Poppins'">Gross Profit</div>
                    <div class="card-number" style="font-family:'Poppins'">Php ${totalGrossProfit.toLocaleString()}</div>
                </div>
            </div>
            <div class="rectangle-card" onclick="filterTable('All')">
                <i class="card-icon">
                    <img src="../images/duration_i.png" alt="icon" width="30" height="30">
                </i>
                <div class="card-content">
                    <div class="card-title" style="font-family:'Poppins'">Commission</div>
                    <div class="card-number" style="font-family:'Poppins'">Php ${totalCommission.toLocaleString()}</div>
                </div>
            </div>
        </div>
        <canvas id="projectsChart" style="margin-top: 20px;"></canvas>
    `);
}

function updateCharts(data) {
    let ctx = document.getElementById('projectsChart').getContext('2d');

    let projectNames = data.map(project => project.project_name);
    let netSales = data.map(project => parseFloat(project.net_sales));
    let grossProfit = data.map(project => parseFloat(project.gross_profit));
    let commission = data.map(project => parseFloat(project.commission));

    if (window.projectsChartInstance) {
        window.projectsChartInstance.destroy();
    }

    window.projectsChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: projectNames,
            datasets: [
                {
                    label: 'Net Sales',
                    backgroundColor: '#4caf50',
                    data: netSales
                },
                {
                    label: 'Gross Profit',
                    backgroundColor: '#ff9800',
                    data: grossProfit
                },
                {
                    label: 'Commission',
                    backgroundColor: '#f44336',
                    data: commission
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Php ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Php ' + context.raw.toLocaleString();
                            return label;
                        }
                    }
                }
            }
        }
    });
}

$('#calendar-container').before(`
    <div class="mb-1" style="margin: 10px; width: 250px;  top: 10px; right: 10px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <label for="filterWidget" class="form-label text-white">Filter by Project</label>
            <select class="form-select" id="filterWidget">
                <option value="All">All</option>
                <!-- Projects will be populated here -->
            </select>
        </div>
        <button id="refreshButton" class="btn btn-secondary" style="margin-left: 5px; margin-top:30px; font-family;'Poppins'; font-size:12px; height:30px; width:70px;">Refresh</button>
        <div class="btn-group" role="group" style="margin-left:5px; margin-top:10px;">
            <!-- Export Dropdown -->
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" 
                    style="color:black; font-size: 12px; font-family:'Poppins'; height: 30px; margin: 0; border:none; background-color:#f9ce45">
                Export
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="exportToPDF()">Download PDF</a></li>
                <li><a class="dropdown-item" href="#" onclick="exportPNG()">Download PNG</a></li>
                <li><a class="dropdown-item" href="#" onclick="exportJPG()">Download JPG</a></li>
                <li><a class="dropdown-item" href="#" onclick="printTable()">Print</a></li>
            </ul>
        </div>
    </div>
`);

