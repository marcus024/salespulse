$(document).ready(function() {
  // When the "Save" button is clicked
  $("#saveScheduleBtn").on("click", function(e) {
    e.preventDefault(); // Prevent default form submission

    // Collect form data
    let eventName  = $("#eventInput").val().trim();
    let venue      = $("#venueInput").val().trim();
    let startDate  = $("#startDate").val();
    let scheduleTime = $("#timeInput").val();  // <-- changed to timeInput
    let userId     = $("#userID").val();

    // Basic validation check (optional)
    if (!eventName || !venue || !startDate || !scheduleTime) {
      alert("Please fill in all required fields.");
      return;
    }

    // AJAX request
    $.ajax({
      url: "dirback/schedule.php", // The PHP file that will handle the insertion
      type: "POST",
      data: {
        event: eventName,
        venue: venue,
        start: startDate,
        time: scheduleTime,
        user_id_cur: userId
      },
      success: function(response) {
        // The response can be plain text or JSON
        console.log("Server Response:", response);
        
        // If you expect JSON, parse it:
        // const res = JSON.parse(response);
        // if (res.success) { ... } else { ... }

        alert("Schedule inserted successfully!");
        // Optionally hide the modal
        $("#addSchedule").modal("hide");
        // Optionally reload or refresh parts of the UI
        // location.reload();
      },
      error: function(xhr, status, error) {
        console.error("Error in AJAX:", error);
        alert("An error occurred while adding the schedule. Please try again.");
      }
    });
  });
});