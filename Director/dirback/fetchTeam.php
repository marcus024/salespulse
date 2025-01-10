<?php
// Fetch the current user's role, user_id, and full name from the session
$currentUserId = $_SESSION['user_id_c'];
$currentUserRole = $_SESSION['role']; // e.g., 'ithead', 'salesmember', etc.
$currentUserName = $_SESSION['user_name']; // Full name of the current user

// Determine roles to fetch based on the current user's role
$fetchRoles = [];
if (in_array($currentUserRole, ['ithead', 'itmember'])) {
    $fetchRoles = ['ithead', 'itmember', 'director'];
} elseif (in_array($currentUserRole, ['saleshead', 'salesmember'])) {
    $fetchRoles = ['saleshead', 'salesmember', 'director'];
} elseif ($currentUserRole === 'director') {
    $fetchRoles = ['ithead', 'itmember', 'saleshead', 'salesmember', 'director'];
} else {
    $fetchRoles = [$currentUserRole]; // Default to the current user's role
}

// Prepare SQL query to fetch team members with project stats and full name
$query = "
    SELECT 
        sa.user_id_current,
        sa.role,
        sa.gender,
        sa.firstname,
        sa.lastname,
        COUNT(CASE WHEN p.status = 'Completed' THEN 1 END) AS completed_projects,
        COUNT(CASE WHEN p.status = 'Ongoing' THEN 1 END) AS ongoing_projects,
        COUNT(CASE WHEN p.status = 'Cancelled' THEN 1 END) AS cancelled_projects
    FROM salesauth sa
    LEFT JOIN projecttb p ON sa.user_id_current = p.user_id_cur
    WHERE sa.role IN (" . implode(", ", array_fill(0, count($fetchRoles), "?")) . ")
    GROUP BY sa.user_id_current, sa.role, sa.gender, sa.firstname, sa.lastname
";

try {
    // Prepare and execute the query with parameterized roles
    $stmt = $conn->prepare($query);
    $stmt->execute($fetchRoles);

    // Fetch all team members
    $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add the current user's name to the result set
    foreach ($teamMembers as &$member) {
        // Concatenate first name and last name for full name
        $member['name'] = $member['firstname'] . ' ' . $member['lastname'];
        
        if ($member['user_id_current'] == $currentUserId) {
            // Set the current user's full name
            $member['name'] = $currentUserName;
        }
    }
    unset($member); // Break reference to avoid potential issues
} catch (PDOException $e) {
    // Handle SQL errors
    error_log("Database Error: " . $e->getMessage());
    echo "An error occurred while fetching team members. Please try again later.";
}

?>
