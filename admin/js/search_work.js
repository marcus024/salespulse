function searchKey() {
    const input = document.getElementById('searchWork'); // Get the search input field
    const filter = input.value.toLowerCase(); // Convert input to lowercase
    const table = document.getElementById('workPulse'); // Get the table element
    const rows = table.getElementsByTagName('tr'); // Get all rows in the table

    // Loop through all table rows (except the first, which is the header)
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td'); // Get all cells in the current row
        let isMatch = false;

        // Check if any cell in the current row matches the search query
        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                isMatch = true;
                break;
            }
        }
        // Show or hide the row based on whether it matches the search query
        rows[i].style.display = isMatch ? '' : 'none';
    }
}