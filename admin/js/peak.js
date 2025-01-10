
    // Sample Data - Replace with your dynamic data
    const peakUsersData1 = {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Peak Users',
            data: [120, 150, 180, 200, 170, 160, 190],
            backgroundColor: 'rgba(54, 185, 204, 0.2)',
            borderColor: 'rgba(54, 185, 204, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    const peakUsersData2 = {
        labels: ['Juan', 'Pedro', 'Maria', 'Ato', 'Delima', 'Jojo', 'Sonny'],
        datasets: [{
            label: 'Projects',
            data: [100, 130, 160, 180, 150, 140, 170],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    // Chart Configuration
    const config1 = {
        type: 'line', // Choose chart type: 'line', 'bar', etc.
        data: peakUsersData1,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision:0
                }
            }
        }
    };

    const config2 = {
        type: 'bar',
        data: peakUsersData2,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision:0
                }
            }
        }
    };

    // Render Chart 1
    const ctx1 = document.getElementById('peakUsersChart1').getContext('2d');
    const peakUsersChart1 = new Chart(ctx1, config1);

    // Render Chart 2
    const ctx2 = document.getElementById('peakUsersChart2').getContext('2d');
    const peakUsersChart2 = new Chart(ctx2, config2);
