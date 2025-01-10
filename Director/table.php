<div class="table-responsive">
                                                <?php
                                                $user_id = $_SESSION['user_id_c'] ?? null; 
                                                if (!$user_id) {
                                                    echo "<script>alert('User not logged in. Please log in.'); window.location.href = '../../login.php';</script>";
                                                    exit; 
                                                }
                                                $projects = [];
                                                try {
                                                    
                                                    $sql = "SELECT * FROM projecttb";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                           
                                                    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    echo $projects;
                                                    $projects = array_filter($projects, function($project) use ($user_id) {
                                                        return $project['user_id_c'] == $user_id;
                                                    });
                                                } catch (PDOException $e) {
                                                    echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
                                                }
                                                ?>
                                                <?php if (!empty($projects)): ?>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Project ID</th>
                                                                <th>Company Name</th>
                                                                <th>Account Manager</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($projects as $project): ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($project['project_unique_id']); ?></td>
                                                                    <td><?php echo htmlspecialchars($project['company_name']); ?></td>
                                                                    <td><?php echo htmlspecialchars($project['account_manager']); ?></td>
                                                                    <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                                                                    <td><?php echo htmlspecialchars($project['end_date']); ?></td>
                                                                    <td><?php echo htmlspecialchars($project['status']); ?></td>
                                                                    <td class="action-buttons">
                                                                        <a href="dirviewproject.php?project_id=<?php echo $project['project_unique_id']; ?>" class="view-btn">
                                                                            <i class="fas fa-eye" style="font-size: 10px; color: #009394;"></i>
                                                                        </a>
                                                                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProjectModal" data-project-id="<?php echo $project['project_unique_id']; ?>">
                                                                            <i class="fas fa-pencil-alt" style="font-size: 10px; color: #009394;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <p>No projects found for the current user.</p>
                                                <?php endif; ?>
                                            </div>