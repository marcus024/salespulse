// Fetch data and update cards and charts
$(document).ready(function() {
    fetchData();

    // Filter widget change event
    $('#filterWidget').on('change', function() {
        fetchData($(this).val());
    });
});

function fetchData(filter = '') {
    $.ajax({
        url: './dirback/spcome_fetch_table.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (filter) {
                data = data.filter(project => project.projectStatus === filter);
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
                    <div class="card-title" style="font-family:'Poppins'">Total Projects</div>
                    <div class="card-number" style="font-family:'Poppins'">${totalProjects}</div>
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

// HTML for the filter widget
$('#calendar-container').before(`
    <div class="mb-3">
        <label for="filterWidget" class="form-label text-white">Filter by Status</label>
        <select class="form-select" id="filterWidget">
            <option value="">All</option>
            <option value="Completed">Completed</option>
            <option value="In Progress">In Progress</option>
            <option value="Pending">Pending</option>
        </select>
    </div>
`);
