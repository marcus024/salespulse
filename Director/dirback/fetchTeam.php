<?php
$currentUserId   = $_SESSION['user_id_c'];
$currentUserName = $_SESSION['user_name'];

try {
    // 1. Fetch the user IDs under the current head
    $teamQuery = "SELECT team_user_id FROM team_tb WHERE head_user_id = ?";
    $teamStmt  = $conn->prepare($teamQuery);
    $teamStmt->execute([$currentUserId]);
    $teamUserIds = $teamStmt->fetchAll(PDO::FETCH_COLUMN);

    // 2. If there are no team user IDs, skip the detailed query; 
    //    let the frontend handle "No team members found."
    if (!empty($teamUserIds)) {
        // Build dynamic placeholders for the IN() clause
        $placeholders = implode(", ", array_fill(0, count($teamUserIds), "?"));

        $query = "
            SELECT 
                sa.user_id_current,
                sa.gender,
                sa.role,
                sa.firstname,
                sa.lastname,
                COUNT(CASE WHEN p.status = 'Completed' THEN 1 END) AS completed_projects,
                COUNT(CASE WHEN p.status = 'Ongoing' THEN 1 END) AS ongoing_projects,
                COUNT(CASE WHEN p.status = 'Cancelled' THEN 1 END) AS cancelled_projects,
                ROUND(
                    AVG(
                        CASE 
                            WHEN p.start_date <= p.end_date THEN DATEDIFF(p.end_date, p.start_date)
                            ELSE NULL
                        END
                    ), 2
                ) AS avg_project_duration
            FROM salesauth sa
            LEFT JOIN projecttb p ON sa.user_id_current = p.user_id_cur
            WHERE sa.user_id_current IN ($placeholders)
            GROUP BY sa.user_id_current, sa.gender, sa.role, sa.firstname, sa.lastname
        ";

        function getRoleDisplayName($role) {
            switch ($role) {
                case 'salesdirector':
                    return 'Sales and Marketing Director';
                case 'unithead':
                    return 'Business Unit Head';
                case 'salesmanager':
                    return 'Sales Manager';
                case 'accountmanager':
                    return 'Account Manager';
                default:
                    return 'Unknown Role';
            }
        }

        // 3. Fetch team members
        $stmt = $conn->prepare($query);
        $stmt->execute($teamUserIds);
        $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 4. Format each member’s name and role display
        foreach ($teamMembers as &$member) {
            $member['name'] = ucwords(
                strtolower($member['firstname']) . ' ' . strtolower($member['lastname'])
            );

            if ($member['user_id_current'] == $currentUserId) {
                // If it's the head user themself, just use session's name
                $member['name'] = ucwords(strtolower($currentUserName));
            }

            $member['role_display'] = getRoleDisplayName($member['role']);
        }
        unset($member); // good practice when using references
    }

    // IMPORTANT:
    // We do not echo or return anything here. 
    // The front-end (or included script) can use $teamMembers 
    // or see if it's empty to display "No team members found."

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    // Optionally handle the error, but do not echo or exit if you want no output:
    // e.g., $teamMembers = [];
}
