 $(document).ready(function() {
        let actualGross = 0;

        // Fetch and display data from the server
        $.ajax({
            url: './dirback/spcome_fetch_table.php',  // The PHP file
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#commission-table').empty(); // Clear previous content

                if (data.length === 0) {
                    showError('No projects found.');
                    return;
                }

                // Sum the gross profits
                data.forEach(project => {
                    actualGross += parseFloat(project.gross_profit) || 0;

                    // Append data rows dynamically
                    $('#commission-table').append(`
                        <div class="d-flex p-3 mb-2" style="background: #292a2f; border-radius: 8px;">
                            <div class="col-2 comRows">${project.project_name}</div>
                            <div class="col-2 comRows">${project.start_date}</div>
                            <div class="col-2 comRows">${project.end_date}</div>
                            <div class="col-2 comRows">Php ${project.net_sales || 0}</div>
                            <div class="col-2 comRows">Php ${project.gross_profit || 0}</div>
                            <div class="col-2 comRows">Php ${project.commission || 0}</div> <!-- Default to 0 if commission is missing -->
                        </div>
                    `);
                });

                // Display the sum of gross profit as actual gross profit
                $('#actualGross').val(actualGross.toFixed(2));
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred while fetching data.';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }

                showError(errorMessage);
                console.error('Error fetching data:', error);
            }
        });

        // Function to display error notifications
        function showError(message) {
            $('#commission-table').html(`
                <div class="alert alert-danger" role="alert">
                    ${message}
                </div>
            `);
        }

        // Trigger the calculation when the Calculate button is clicked
        $('.calcBtn').on('click', function() {
            try {
                // Get actual gross profit and target gross profit values
                let targetGross = parseFloat($('#targetGross').val()) || 0;

                if (isNaN(targetGross) || targetGross <= 0) {
                    alert("Please enter a valid target gross profit.");
                    return;
                }

                let deficit = 0;

                if (actualGross > targetGross) {
                    deficit = 0; // No deficit if actual gross is greater
                } else {
                    deficit = targetGross - actualGross;
                }

                // Calculate the potential commission only if there is a deficit
                let potentialCommission = deficit * 0.05 * 0.70;

                let formattedCommission = potentialCommission.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Display the potential commission
                $('#potentialCommission').text(`Php ${formattedCommission}`);

                // Prepare data for AJAX
                let formData = {
                    actual_com: actualGross,
                    target_com: targetGross,
                    potential_com: potentialCommission.toFixed(2),
                };

                // Send data to backend via AJAX
                $.ajax({
                    url: './dirback/save_pot_com/save_commission.php',  // Backend PHP script
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Data saved successfully!');
                        console.log(response); // Log response for debugging
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Failed to save data.');
                    }
                });

            } catch (error) {
                // Alert to notify if something went wrong
                alert("There was an error in calculating the potential commission. Please try again.");
                console.error(error); // Log the error for debugging purposes
            }
        });

    });

        // Search function to filter rows based on input
        function searchTable() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toLowerCase();
            let rows = document.querySelectorAll("#commission-table .d-flex");

            rows.forEach(row => {
                let cells = row.querySelectorAll(".comRows");
                let rowText = "";

                cells.forEach(cell => {
                    rowText += cell.textContent.toLowerCase();
                });

                if (rowText.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Export to CSV
        function exportToCSV() {
            let rows = document.querySelectorAll("#commission-table .d-flex");
            let csvContent = "Project Name,Start Date,End Date,Net Sales,Gross Profit,Commission\n";

            rows.forEach(row => {
                let cells = row.querySelectorAll(".comRows");
                let rowData = [];
                cells.forEach(cell => {
                    rowData.push(cell.textContent.replace(/Php\s*/g, '').trim());
                });
                csvContent += rowData.join(",") + "\n";
            });

            let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "commissions.csv";
            link.click();
        }

        // Export to Excel
        function exportToExcel() {
            let tableHTML = '<table><tr><th>Project Name</th><th>Start Date</th><th>End Date</th><th>Net Sales</th><th>Gross Profit</th><th>Commission</th></tr>';
            let rows = document.querySelectorAll("#commission-table .d-flex");

            rows.forEach(row => {
                tableHTML += '<tr>';
                let cells = row.querySelectorAll(".comRows");
                cells.forEach(cell => {
                    tableHTML += '<td>' + cell.textContent.replace(/Php\s*/g, '').trim() + '</td>';
                });
                tableHTML += '</tr>';
            });
            tableHTML += '</table>';

            let blob = new Blob([tableHTML], { type: 'application/vnd.ms-excel' });
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "commissions.xls";
            link.click();
        }

        // Export to PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            let doc = new jsPDF();

            let rows = [];
            document.querySelectorAll("#commission-table .d-flex").forEach(row => {
                let rowData = [];
                row.querySelectorAll(".comRows").forEach(cell => {
                    rowData.push(cell.textContent.replace(/Php\s*/g, '').trim());
                });
                rows.push(rowData);
            });

            doc.autoTable({
                head: [['Project Name', 'Start Date', 'End Date', 'Net Sales', 'Gross Profit', 'Commission']],
                body: rows
            });

            doc.save('commissions.pdf');
        }

        // Print the table
        function printTable() {
            let printWindow = window.open('', '', 'height=600,width=800');
            let content = document.querySelector("#commission-table").outerHTML;
            printWindow.document.write('<html><head><title>Print Commissions</title></head><body>');
            printWindow.document.write('<h1>Completed Projects Commissions</h1>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

