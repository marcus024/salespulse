   allNotifications = [];
   showingAll = false;
   unreadNotifications = 0;
   let currentUserId = null

async function fetchNotifications() {
    try {
        const response = await fetch("alerts/notif.php");
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();



        currentUserId = data.user_id_cur;


        const notifications = {
            allNotifications: [],
            unreadNotifications: 0,
            newNotifications: [],
            userId: data.user_id_cur,
        };


        if (data.projects && data.projects.length > 0) {
            data.projects.forEach((project) => {
                const notification = {
                    id: `project-${project.project_unique_id}`,
                    content: `Overdue Project: ${project.company_name} (ID: ${project.project_unique_id})`,
                    readStatus: project.read_status === 1,
                    type: "Project",
                    relatedId: project.project_unique_id,
                };

                notifications.allNotifications.push(notification);
                if (!notification.readStatus) {
                    notifications.unreadNotifications++;
                    notifications.newNotifications.push({
                        user_id: notifications.userId,
                        content: `Overdue Project: ${project.company_name}`,
                        type: "Project",
                        related_id: project.project_unique_id,
                    });
                }
            });
        }

        // Collect notifications for overdue stages
        if (data.stages && data.stages.length > 0) {
            data.stages.forEach((stage) => {
                const notification = {
                    id: `stage-${stage.project_unique_id}-${stage.stage_name}`,
                    content: `${stage.project_unique_id} has been active for 3 days. Please review and update its status to ensure timely progress.`,
                    readStatus: stage.read_status === 1,
                    type: "Stage",
                    relatedId: `${stage.project_unique_id}`,
                };

                notifications.allNotifications.push(notification);
                if (!notification.readStatus) {
                    notifications.unreadNotifications++;
                    notifications.newNotifications.push({
                        user_id: notifications.userId,
                        content: `${stage.project_unique_id} has been active for 3 days. Please review and update its status to ensure timely progress.`,
                        type: "Stage",
                        related_id: `${stage.project_unique_id}`,
                    });
                }
            });
        }

        // Insert new notifications into the database if any
        if (notifications.newNotifications.length > 0) {
            await insertNotifications(notifications.newNotifications);
        }

        // Render notifications and update the badge
        
        return notifications; // Return the processed data

    } catch (error) {
        console.error("Error fetching notifications:", error);
        throw error; // Re-throw the error for the calling code to handle
    }
}

async function markNotificationRead(element, userId) {
    const notificationId = element.getAttribute("data-notification-id");
    console.log("Notification ID from attribute:", notificationId);
    console.log("User ID:", userId);

    if (!notificationId || !userId) {
        alert("Notification ID or User ID is missing!");
        return;
    }

    try {
        const payload = JSON.stringify({
            notification_id: notificationId,
            user_id: userId,
        });

        console.log("Sending payload:", payload);

        const response = await fetch("alerts/notifCount.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: payload,
        });

        console.log("HTTP Response Status:", response.status);

        if (!response.ok) {
            const errorDetails = await response.text();
            const backendError = JSON.parse(errorDetails).error;
            throw new Error(backendError || "Unknown backend error.");
        }

        const result = await response.json();
        if (result.success) {
            console.log("Backend Response:", result);
            alert(`Notification with ID ${notificationId} marked as read successfully.`);

            
        } else {
            throw new Error(result.message || "Unknown failure.");
        }
    } catch (error) {
        console.error("Error Details:", error.message);
        
        // Specific error handling
        if (error.message.includes("No rows updated")) {
            alert("Notification was not updated. It may already be read or does not exist.");
        } else if (error.message.includes("Failed to fetch")) {
            alert("Unable to connect to the server. Please check your connection or try again later.");
        } else {
            alert(`Error marking notification as read: ${error.message}`);
        }
    }
}


function updateNotificationBadge(currentUserId) {
    const notificationCountElement = document.getElementById("notification-count");

    // Append the user ID (string) to the request URL
    fetch(`alerts/get_unread_count.php?user_id=${encodeURIComponent(currentUserId)}`)
        .then(response => response.json())
        .then(data => {
            const unreadNotifications = data.unread_count;

            if (unreadNotifications > 0) {
                notificationCountElement.textContent = unreadNotifications;
                notificationCountElement.style.display = "inline";
            } else {
                notificationCountElement.style.display = "none";
            }
        })
        .catch(error => {
            console.error("Error fetching notification count:", error);
            notificationCountElement.style.display = "none";
        });
}


// Function to insert notifications into the database
async function insertNotifications(notifications) {
    try {
        const response = await fetch("alerts/insertNotif.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ notifications }),
        });

        if (!response.ok) {
            throw new Error(`Failed to insert notifications: ${response.statusText}`);
        }

        const result = await response.json();
        if (!result.success) {
            console.error("Failed to insert notifications:", result.message);
        }
    } catch (error) {
        console.error("Error inserting notifications:", error);
    }
}

// Function to render notifications dynamically
function renderNotifications() {
    const notificationsContainer = document.getElementById("notifs");
    notificationsContainer.innerHTML = "";

    const notificationsToShow = showingAll ? allNotifications : allNotifications.slice(0, 5);

    notificationsToShow.forEach(notification => {
        notificationsContainer.insertAdjacentHTML("beforeend", notification.content);
    });

    const toggleLink = document.getElementById("toggleNotifications");
    if (allNotifications.length > 5) {
        toggleLink.style.display = "block";
        toggleLink.textContent = showingAll ? "Show Less Alerts" : "Show All Alerts";
        toggleLink.onclick = (event) => {
            event.preventDefault();
            showingAll = !showingAll;
            renderNotifications();
        };
    } else {
        toggleLink.style.display = "none";
    }
}

// Function to mark a notification as read
async function markNotificationRead(element) {
    const notificationId = element.getAttribute("data-notification-id"); // Get the unique ID of the clicked notification

    try {
        // Send the notification ID to the backend
        const response = await fetch("alerts/markread.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ notification_id: notificationId }),
        });

        if (!response.ok) {
            throw new Error("Failed to mark notification as read.");
        }

        const result = await response.json();
        if (result.success) {
            // Find the notification in the local list and update its status
            const notification = allNotifications.find((notif) => notif.id === notificationId);
            if (notification) {
                notification.read = true; // Update the local read status
            }

            // Update the badge and re-render notifications
            unreadNotifications = allNotifications.filter((notif) => !notif.read).length;
            renderNotifications();
            updateNotificationBadge(currentUserId);
        } else {
            throw new Error(result.message || "Unknown error occurred.");
        }
    } catch (error) {
        console.error("Error marking notification as read:", error);
    }
}

// Updated getAllCurrentUserNotif with clickable notifications
async function getAllCurrentUserNotif(currentUserId) {
    try {
        const response = await fetch("alerts/currentall_notif.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ user_id: currentUserId }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        const notificationsContainer = document.getElementById("notifs");
        notificationsContainer.innerHTML = "";

        allNotifications = [];
        showingAll = false;
        unreadNotifications = 0;

        if (!data.notifications || data.notifications.length === 0) {
            notificationsContainer.innerHTML = `
                <div style="text-align: center; font-size: 12px; color: #999;font-family:'Poppins'">
                    No notifications found.
                </div>
            `;
            updateNotificationBadge(currentUserId);
            return;
        }

        data.notifications.forEach((notif) => {
            const isUnread = notif.read_status === 0;
            const notificationContent = `
                <a style="text-decoration: none; color: #555; display: block; margin-bottom: 5px;"
            data-notification-id="${notif.notif_id}"
            data-bs-toggle="modal" 
            data-bs-target="#multiStepModal"
            onclick="markNotificationRead(this); ">
                <div style="display: flex; align-items: center;">
                    ${isUnread ? `<div style="width: 8px; height: 8px; background-color: #36b9cc; border-radius: 50%; margin-right: 8px;"></div>` : ''}
                    <div style="font-weight: bold; font-family:'Poppins'">
                        ${notif.type}: ${notif.content}
                    </div>
                </div>
                <span style="font-family: 'Poppins'; font-size: 11px; color: #999;">
                    ${formatDate(notif.created_at)}
                </span>
            </a>

            `;
            allNotifications.push({
                id: notif.id,
                content: notificationContent,
                read: notif.read_status === 1,
            });
        });

        unreadNotifications = allNotifications.filter((notif) => !notif.read).length;

        renderNotifications();
        updateNotificationBadge(currentUserId);
    } catch (error) {
        console.error("Error fetching notifications:", error);
    }
}

// Helper Function to get notification URLs based on type
// Helper Function to get notification URLs based on type
function getNotificationURL(type, relatedId) {
    switch (type) {
        case "Project":
            return `dirviewproject.php?project_id=${relatedId}`;
        case "Stage":
            // Open the modal and pass the project ID
            return `javascript:openModal('${relatedId}', '#multistepModal')`;
        default:
            return "#";
    }
}



// Helper Function to format dates for display
function formatDate(dateString) {
    const options = { year: "numeric", month: "short", day: "numeric", hour: "2-digit", minute: "2-digit" };
    const date = new Date(dateString);
    return date.toLocaleDateString(undefined, options);
}


document.addEventListener("DOMContentLoaded", async () => {
    await fetchNotifications(); // Fetch notifications and set currentUserId
    if (currentUserId) {
        await getAllCurrentUserNotif(currentUserId); // Fetch all notifications for the current user
    } else {
        console.error("Current user ID is not set. Unable to fetch user-specific notifications.");
    }
});



