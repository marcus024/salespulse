$(document).ready(function() {
  $("#saveScheduleBtn").on("click", function(e) {
    e.preventDefault();

    let eventName = $("#eventInput").val().trim();
    let venue = $("#venueInput").val().trim();
    let startDate = $("#startDate").val();
    let scheduleTime = $("#timeInput").val();
    let userId = $("#userID").val();

    if (!eventName || !venue || !startDate || !scheduleTime) {
      alert("Please fill in all required fields.");
      return;
    }

    $.ajax({
      url: "dirback/schedule.php",
      type: "POST",
      data: {
        event: eventName,
        venue: venue,
        start: startDate,
        time: scheduleTime,
        user_id_cur: userId
      },
      success: function(response) {
        console.log("Server Response:", response);
        alert("Schedule inserted successfully!");
        $("#addSchedule").modal("hide");
        setTimeout(function() {
          window.location.reload(true);
        }, 500);
      },
      error: function(xhr, status, error) {
        console.error("Error in AJAX:", error);
        alert("An error occurred while adding the schedule. Please try again.");
      }
    });
  });
});
