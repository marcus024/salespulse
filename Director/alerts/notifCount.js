// let allNotifications = []
// let showingAll = false;
// let unreadNotifications = 0;


// async function getAllCurrentUserNotif() {
//     try {
//         const response = await fetch("alerts/current_notif.php");
//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         const data = await response.json();

//         const notificationsContainer = document.getElementById("notifs");
//         notificationsContainer.innerHTML = "";

//         allNotifications = []; 
//         showingAll = false; 
//         unreadNotifications = 0; 

//         if ((!data.projects || data.projects.length === 0) && (!data.stages || data.stages.length === 0)) {
//             notificationsContainer.innerHTML = `
//                 <div style="text-align: center; font-size: 12px; color: #999;font-family:'Poppins'">
//                     No overdue projects or stages found.
//                 </div>
//             `;
//             updateNotificationBadge(); 
//             return;
//         }

//         // Collect notifications for overdue projects
//         if (data.projects && data.projects.length > 0) {
//             data.projects.forEach((project) => {
//                 allNotifications.push({
//                     id: `project-${project.project_unique_id}`, // Unique ID for each notification
//                     content: `
//                         <a href="dirviewproject.php?project_id=${project.project_unique_id}" 
//                            style="text-decoration: none; color: #555; display: block; margin-bottom: 5px;"
//                            data-notification-id="project-${project.project_unique_id}"
//                            onclick="markNotificationRead(this);">
//                             <div style="font-weight: bold; font-family:'Poppins'">
//                                 Overdue Project Start: ${project.company_name} (ID: ${project.project_unique_id})
//                             </div>
//                             <span style="font-size: 11px; color: #999; font-family:'Poppins'">
//                                 The project start date has passed by more than 3 days.
//                             </span>
//                         </a>
//                     `,
//                     read: project.read_status === 1, // Backend indicates read status
//                 });
//             });
//         }

//         // Collect notifications for overdue stages
//         if (data.stages && data.stages.length > 0) {
//             data.stages.forEach((stage) => {
//                 allNotifications.push({
//                     id: `stage-${stage.project_unique_id}-${stage.stage_name}`, // Unique ID for each notification
//                     content: `
//                         <a href="dirviewproject.php?project_id=${stage.project_unique_id}" 
//                            style="text-decoration: none; color: #555; display: block; margin-bottom: 5px;"
//                            data-notification-id="stage-${stage.project_unique_id}-${stage.stage_name}"
//                            onclick="markNotificationRead(this);">
//                             <div style="font-weight: bold; font-family:'Poppins'">
//                                 Overdue ${stage.stage_name} Start (Project ID: ${stage.project_unique_id})
//                             </div>
//                             <span style="font-family: 'Poppins'; font-size: 11px; color: #999;">
//                                 The start date (${stage.start_date}) has passed by more than 3 days.
//                             </span>
//                         </a>
//                     `,
//                     read: stage.read_status === 1, // Backend indicates read status
//                 });
//             });
//         }

//         // Set unread notifications count
//         unreadNotifications = allNotifications.filter((notif) => !notif.read).length;

//         // Render initial notifications
//         renderNotifications();
//         updateNotificationBadge();
//     } catch (error) {
//         console.error("Error fetching notifications:", error);
//     }
// }


// // Function to render notifications dynamically
// function renderNotifications() {
//     const notificationsContainer = document.getElementById("notifs");
//     notificationsContainer.innerHTML = ""; // Clear existing notifications

//     const notificationsToShow = showingAll ? allNotifications : allNotifications.slice(0, 5);

//     notificationsToShow.forEach(notification => {
//         notificationsContainer.insertAdjacentHTML("beforeend", notification.content);
//     });

//     // Update the "Show All Alerts" link
//     const toggleLink = document.getElementById("toggleNotifications");
//     if (allNotifications.length > 5) {
//         toggleLink.style.display = "block";
//         toggleLink.textContent = showingAll ? "Show Less Alerts" : "Show All Alerts";
//         toggleLink.onclick = (event) => {
//             event.preventDefault();
//             showingAll = !showingAll; // Toggle the flag
//             renderNotifications(); // Re-render notifications
//         };
//     } else {
//         toggleLink.style.display = "none"; // Hide the link if there are <= 5 notifications
//     }
// }

// // Function to mark a notification as read
// async function markNotificationRead(element) {
//     const notificationId = element.getAttribute("data-notification-id"); // Get the unique ID of the clicked notification
//     const notification = allNotifications.find((notif) => notif.id === notificationId);

//     if (notification && !notification.read) {
//         try {
//             // Mark notification as read in the backend
//             const response = await fetch("alerts/notifCount.php", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                 },
//                 body: JSON.stringify({ notification_id: notificationId }),
//             });

//             if (!response.ok) {
//                 throw new Error("Failed to mark notification as read.");
//             }

//             const result = await response.json();
//             if (result.success) {
//                 // Mark the notification as read locally
//                 notification.read = true;
//                 unreadNotifications = allNotifications.filter((notif) => !notif.read).length; // Update unread count
//                 updateNotificationBadge(); // Update the badge

//                 // Re-render notifications
//                 renderNotifications();
//             }
//         } catch (error) {
//             console.error("Error marking notification as read:", error);
//         }
//     }
// }

// // Function to update the notification badge
// function updateNotificationBadge() {
//     const notificationCountElement = document.getElementById("notification-count");

//     if (unreadNotifications > 0) {
//         notificationCountElement.textContent = unreadNotifications;
//         notificationCountElement.style.display = "inline"; // Show badge
//     } else {
//         notificationCountElement.style.display = "none"; // Hide badge
//     }
// }

// // Initialize notification fetching on page load
// document.addEventListener("DOMContentLoaded", fetchNotifications);
