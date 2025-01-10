$(document).ready(function() {
  // Listen for click on the "View" button
  $(document).on('click', '.view-schedule-btn', function() {
    // Show an alert or console message to confirm the function is called
    console.log("View button clicked.");

    // 1. Get the schedule ID from data attribute
    const scheduleId = $(this).data('sched-id');
    console.log("Schedule ID is:", scheduleId);

    // 2. Make AJAX call to fetchSched.php, passing sched_id
    $.ajax({
      url: `dirback/fetchSched.php?sched_id=${scheduleId}`, // Adjust path if needed
      method: "GET",
      dataType: "json",
      success: function(response) {
        console.log("Raw response:", response);

        // If there's an 'error' key with value = true
        if (response.error) {
          console.error("Error fetching schedule:", response.message);
          alert("Could not load schedule details.");
        } else {
          // We have a single object in response.data
          const sched = response.data; 
          // Example: { sched_id: 7, event: "Meeting...", start: "2024-12-15", time: "10:00", venue: "..." }

          // Populate the modal fields
          $("#scheduleModalLabel").text("Schedule Details for " + sched.event);
          $("#modalEvent").text(sched.event);
          $("#modalDate").text(sched.start);
          $("#modalTime").text(sched.time);
          $("#modalVenue").text(sched.venue);
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX error:", error);
        alert("An error occurred while fetching the schedule details.");
      }
    });
  });
});