// Export to PDF
    async function exportToPDF() {
        const { jsPDF } = window.jspdf; // Get jsPDF
        const doc = new jsPDF();

        // Add title to the PDF
        doc.setFontSize(16);
        doc.text("Project Lists", 14, 20);

        // Fetch the table
        const table = document.getElementById("projectTable");

        // Parse table data for autoTable
        const data = [];
        const rows = table.querySelectorAll("tr");
        rows.forEach((row, rowIndex) => {
            const rowData = [];
            const cells = row.querySelectorAll("th, td");
            cells.forEach(cell => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });

        // AutoTable options
        doc.autoTable({
            head: [data[0]], // First row is the table header
            body: data.slice(1), // Remaining rows are the body
            startY: 30, // Start after title
            styles: {
                fontSize: 9, // Font size for table
            },
            headStyles: {
                fillColor: [54, 185, 204], // Header color matching your theme
                textColor: 255, // White text
                halign: "center" // Center align header text
            },
        });

        // Save the PDF
        doc.save("ProjectLists.pdf");
    }

    // Export to CSV
    function exportToCSV() {
        const table = document.getElementById("projectTable");
        const rows = Array.from(table.rows).map(row =>
            Array.from(row.cells).map(cell => cell.innerText)
        );

        let csvContent = "data:text/csv;charset=utf-8,";

        rows.forEach(row => {
            const rowData = row.join(",");
            csvContent += rowData + "\r\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "ProjectLists.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Export to Excel
    function exportToExcel() {
        const table = document.getElementById("projectTable");

        // Convert HTML table to an array of arrays
        const rows = Array.from(table.rows).map(row =>
            Array.from(row.cells).map(cell => cell.innerText)
        );

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows); // Convert array of arrays to a sheet

        // Append worksheet to workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Project Lists");

        // Write file
        XLSX.writeFile(workbook, "ProjectLists.xlsx");
    }

    // Print Table
    function printTable() {
        const printContent = document.getElementById("projectTable").outerHTML;
        const newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Project Lists</title></head><body>");
        newWindow.document.write(printContent);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    }