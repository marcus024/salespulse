<?php
 
$user_id = $_SESSION['user_id_c'] ?? null;
if (!$user_id) {
    echo "<script>alert('User not logged in. Please log in.'); window.location.href = '../../login.php';</script>";
    exit;
}

$completedCount = 0;
$ongoingCount   = 0;
$cancelledCount = 0;
 
$avgDuration    = 0.0;

try {
     
    $sql = "
        SELECT 
            p.status AS pstatus,
            COUNT(p.project_unique_id) AS project_count,
            (
                SELECT AVG(p2.duration)
                FROM projecttb p2
                WHERE p2.user_id_cur = s.user_id_current
            ) AS avg_duration
        FROM projecttb p
        INNER JOIN salesauth s 
            ON p.user_id_cur = s.user_id_current
        WHERE s.user_id_current = :current_user
        GROUP BY p.status
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_user', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($statuses)) {
         
        $avgDuration = $statuses[0]['avg_duration'] ?? 0.0;
    }

     
    foreach ($statuses as $status) {
        if ($status['pstatus'] === 'Completed') {
            $completedCount = $status['project_count'];
        } elseif ($status['pstatus'] === 'Ongoing') {
            $ongoingCount   = $status['project_count'];
        } elseif ($status['pstatus'] === 'Cancelled') {
            $cancelledCount = $status['project_count'];
        }
    }
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>


