$(document).ready(function() {
  $(document).on('click', '.view-schedule-btn', function() {
    console.log("View button clicked.");

    const scheduleId = $(this).data('sched-id');
    console.log("Schedule ID is:", scheduleId);

    $.ajax({
      url: `dirback/fetchSched.php?sched_id=${scheduleId}`,
      method: "GET",
      dataType: "json",
      success: function(response) {
        console.log("Raw response:", response);

        if (response.error) {
          console.error("Error fetching schedule:", response.message);
          alert("Could not load schedule details.");
        } else {
          const sched = response.data;
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
