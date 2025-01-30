<?php
header('Content-Type: application/json');

ini_set('display_errors', 0); // Disable error output
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

include("../auth/db.php");

try {
    ob_start(); // Start output buffering

    // Get raw POST data
    $rawData = file_get_contents('php://input');
    file_put_contents(__DIR__ . '/debug.log', "Raw Input: $rawData\n", FILE_APPEND); // Log raw input
    $data = json_decode($rawData, true);

    if (!isset($data['step'], $data['project_unique_id'], $data['data'])) {
        ob_clean();
        echo json_encode(["message" => "Invalid input data"]);
        exit;
    }

    $step = $data['step'];
    $projectUniqueId = $data['project_unique_id'];
    $inputData = $data['data'];

    switch ($step) {
        case 1:
            updateStageOne($conn, $projectUniqueId, $inputData);
            break;

        case 2:
            updateStageTwo($conn, $projectUniqueId, $inputData);
            break;

        case 3:
            updateStageThree($conn, $projectUniqueId, $inputData);
            break;

        case 4:
            updateStageFour($conn, $projectUniqueId, $inputData);
            break;

        case 5:
            updateStageFive($conn, $projectUniqueId, $inputData);
            break;

        default:
            ob_clean();
            echo json_encode(["message" => "Invalid step number"]);
            exit;
    }

    ob_clean();
    echo json_encode(["message" => "Step $step data processed successfully", "processed_data" => $inputData]);
} catch (Exception $e) {
    ob_clean();
    file_put_contents(__DIR__ . '/debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(["message" => "Error occurred", "error" => $e->getMessage()]);
}

function updateStageOne($conn, $projectUniqueId, $inputData) {
    try {
         // 1) Update main stageone table
        $query = "UPDATE stageone 
                     SET solution = ?, 
                         technology = ?, 
                         deal_size = ?, 
                         stage_one_remarks = ?
                   WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['solution']          ?? null,
            $inputData['technology']        ?? null,
            $inputData['deal_size']         ?? null,
            $inputData['stage_one_remarks'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirement items in requirementone_tb
        $insertedRequirementCount = 0;
        $updatedRequirementCount = 0;

        if (!empty($inputData['requirement_one'])) {
            // Prepare statements
            $insertReqStmt = $conn->prepare("
                INSERT INTO requirementone_tb
                    (requirement_one, project_unique_id, distributor_one, product_one, requirement_id_1)
                VALUES (?, ?, ?, ?, ?)
            ");

            $updateReqStmt = $conn->prepare("
                UPDATE requirementone_tb
                SET requirement_one = ?,
                    distributor_one = ?,
                    product_one = ?
                WHERE requirement_id_1 = ?
                AND project_unique_id = ?
            ");

            $checkReqStmt = $conn->prepare("
                SELECT 1 
                FROM requirementone_tb
                WHERE requirement_id_1 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['requirement_one'] as $index => $requirement) {
                // Sanitize input
                $sanitizedRequirement = htmlspecialchars($requirement ?? '', ENT_QUOTES, 'UTF-8');
                $productOne = htmlspecialchars($inputData['product_one'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $distributorOne = htmlspecialchars($inputData['distributor_one'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId = $inputData['requirement_id_1'][$index] ?? '';

                // Skip insert if either product_one or distributor_one is 'Select'
                if ($productOne === 'Select' || $distributorOne === 'Select') {
                    error_log("Skipping insert for Project ID {$projectUniqueId} because product or distributor is 'Select'.");
                    continue;
                }

                // Only proceed if at least one field (requirement_one, product_one, distributor_one) is not empty
                if (empty($sanitizedRequirement) && empty($productOne) && empty($distributorOne)) {
                    error_log("Skipping blank requirement entry for Project ID {$projectUniqueId}. All fields are empty.");
                    continue;
                }

                // If requirement_id_1 exists and at least one field is not empty, proceed with update or insert
                if (!empty($requirementId)) {
                    $updateReqStmt->execute([
                        $sanitizedRequirement,
                        $distributorOne,
                        $productOne,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateReqStmt->rowCount();
                    if ($updatedRows > 0) {
                        $updatedRequirementCount += $updatedRows;
                    } else {
                        // Check if requirement_id_1 exists, then insert if it doesn't
                        $checkReqStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkReqStmt->rowCount() === 0) {
                            // Insert the new requirement
                            $insertReqStmt->execute([
                                $sanitizedRequirement,
                                $projectUniqueId,
                                $distributorOne,
                                $productOne,
                                $requirementId
                            ]);
                            $insertedRequirementCount++;
                        }
                    }
                } else {
                    error_log("Empty requirement_id_1 for Project ID {$projectUniqueId}. Skipping insert.");
                }
            }
        }


        // Insert data into stagetwo table
        $stagetwoQuery = "INSERT INTO stagetwo (start_date_stage_two, end_date_stage_two, status_stage_two, project_unique_id) 
                          VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($stagetwoQuery);
        $stmt->execute([
            date('Y-m-d'),
            'Not Yet Ended',
            'Ongoing',
            $projectUniqueId
        ]);

        // Update the stageone table to mark as Completed
        $updateStageOneStatusQuery = "UPDATE stageone SET 
            status_stage_one = 'Completed', 
            end_date_stage_one = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageOneStatusQuery);
        $stmt->execute([
            date('Y-m-d'),
            $projectUniqueId
        ]);

        // Update projecttb current_stage to the next stage
        $updateProjectStageQuery = "UPDATE projecttb
                                    SET current_stage = 'Stage 2'
                                    WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateProjectStageQuery);
        $stmt->execute([$projectUniqueId]);

         // 3) Build a final success message
        $message = "Stage One updated successfully.";
        if ($insertedCount > 0 || $updatedCount > 0) {
            $message .= " (Inserted $insertedCount, Updated $updatedCount requirements)";
        }

    } catch (Exception $e) {
        throw new Exception("Stage One Update Failed: " . $e->getMessage());
    }
}

function updateStageTwo($conn, $projectUniqueId, $inputData) {
    try {
        // Update the stagetwo table
        $query = "UPDATE stagetwo SET 
            stage_two_remarks = ?, 
            technology = ?, 
            deal_size = ?, 
            product = ?, 
            solution = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['stage_two_remarks'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['product'] ?? null,
            $inputData['solution'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirement items in requirement_twotb
        $insertedRequirementCount = 0;
        $updatedRequirementCount = 0;

        if (!empty($inputData['requirement_two'])) {
            // Prepare statements
            $insertReqStmt = $conn->prepare("
                INSERT INTO requirement_twotb
                    (requirement_two, requirement_date, requirement_remarks, project_unique_id, requirement_id_2, product_two, distributor_two)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $updateReqStmt = $conn->prepare("
                UPDATE requirement_twotb
                SET requirement_two = ?,
                    requirement_date = ?,
                    requirement_remarks = ?,
                    product_two = ?,
                    distributor_two = ?
                WHERE requirement_id_2 = ?
                AND project_unique_id = ?
            ");

            $checkReqStmt = $conn->prepare("
                SELECT 1 
                FROM requirement_twotb
                WHERE requirement_id_2 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['requirement_two'] as $index => $requirement) {
                // Sanitize input
                $sanitizedRequirement = htmlspecialchars($requirement ?? '', ENT_QUOTES, 'UTF-8');
                $requirementDate = htmlspecialchars($inputData['requirement_date'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementRemarks = htmlspecialchars($inputData['requirement_remarks'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $productTwo = htmlspecialchars($inputData['product_two'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $distributorTwo = htmlspecialchars($inputData['distributor_two'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId = $inputData['requirement_id_2'][$index] ?? '';

                // Skip insert if either product_two or distributor_two is 'Select'
                if ($productTwo === 'Select' || $distributorTwo === 'Select') {
                    error_log("Skipping insert for Project ID {$projectUniqueId} because product or distributor is 'Select'.");
                    continue;
                }

                // Only proceed if at least one field (requirement_two, product_two, distributor_two) is not empty
                if (empty($sanitizedRequirement) && empty($productTwo) && empty($distributorTwo)) {
                    error_log("Skipping blank requirement entry for Project ID {$projectUniqueId}. All fields are empty.");
                    continue;
                }

                // If requirement_id_2 exists and at least one field is not empty, proceed with the update or insert
                if (!empty($requirementId)) {
                    $updateReqStmt->execute([
                        $sanitizedRequirement,
                        $requirementDate,
                        $requirementRemarks,
                        $productTwo,
                        $distributorTwo,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateReqStmt->rowCount();
                    if ($updatedRows > 0) {
                        $updatedRequirementCount += $updatedRows;
                    } else {
                        // Check if requirement_id_2 exists, then insert if it doesn't
                        $checkReqStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkReqStmt->rowCount() === 0) {
                            // Insert the new requirement
                            $insertReqStmt->execute([
                                $sanitizedRequirement,
                                $requirementDate,
                                $requirementRemarks,
                                $projectUniqueId,
                                $requirementId,
                                $productTwo,
                                $distributorTwo
                            ]);
                            $insertedRequirementCount++;
                        }
                    }
                } else {
                    error_log("Empty requirement_id_2 for Project ID {$projectUniqueId}. Skipping insert.");
                }
            }
        }


// Handle engagement items in engagement_twotb
        $insertedEngagementCount = 0;
        $updatedEngagementCount = 0;

        if (!empty($inputData['engagement_type'])) {
            $insertEngStmt = $conn->prepare("
                INSERT INTO engagement_twotb
                    (engagement_type, engagement_date, engagement_remarks, project_unique_id, engagement_id_2)
                VALUES (?, ?, ?, ?, ?)
            ");

            $updateEngStmt = $conn->prepare("
                UPDATE engagement_twotb
                SET engagement_type = ?,
                    engagement_date = ?,
                    engagement_remarks = ?
                WHERE engagement_id_2 = ?
                AND project_unique_id = ?
            ");

            $checkEngStmt = $conn->prepare("
                SELECT 1 
                FROM engagement_twotb
                WHERE engagement_id_2 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['engagement_type'] as $index => $engagementType) {
                $sanitizedEngagementType = htmlspecialchars($engagementType ?? '', ENT_QUOTES, 'UTF-8');
                $engagementDate = htmlspecialchars($inputData['engagement_date'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $engagementRemarks = htmlspecialchars($inputData['engagement_remarks'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $engagementId = htmlspecialchars($inputData['engagement_id_2'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                if (empty($sanitizedEngagementType) || empty($engagementDate) || empty($engagementRemarks) || empty($engagementId)) {
                    error_log("Skipping blank or incomplete engagement entry for project ID: $projectUniqueId.");
                    continue;
                }

                $updateEngStmt->execute([
                    $sanitizedEngagementType,
                    $engagementDate,
                    $engagementRemarks,
                    $engagementId,
                    $projectUniqueId
                ]);

                $updatedRows = $updateEngStmt->rowCount();
                if ($updatedRows > 0) {
                    $updatedEngagementCount += $updatedRows;
                } else {
                    $checkEngStmt->execute([$engagementId, $projectUniqueId]);
                    if ($checkEngStmt->rowCount() === 0) {
                        $insertEngStmt->execute([
                            $sanitizedEngagementType,
                            $engagementDate,
                            $engagementRemarks,
                            $projectUniqueId,
                            $engagementId
                        ]);
                        $insertedEngagementCount++;
                    }
                }
            }
        }


        // Insert data into stagethree table
        $stagethreeQuery = "INSERT INTO stagethree (start_date_stage_three, end_date_stage_three, status_stage_three, project_unique_id) 
                            VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($stagethreeQuery);
        $stmt->execute([
            date('Y-m-d'),
            'Not Yet Ended',
            'Ongoing',
            $projectUniqueId
        ]);

        // Update the stagetwo table to mark as Completed
        $updateStageTwoStatusQuery = "UPDATE stagetwo SET 
            status_stage_two = 'Completed', 
            end_date_stage_two = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageTwoStatusQuery);
        $stmt->execute([
            date('Y-m-d'),
            $projectUniqueId
        ]);

        // Update projecttb current_stage to the next stage
        $updateProjectStageQuery = "UPDATE projecttb
                                    SET current_stage = 'Stage 3'
                                    WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateProjectStageQuery);
        $stmt->execute([$projectUniqueId]);

        // Build final success message
        $message = "Stage Two updated successfully.";
        if ($insertedRequirementCount > 0 || $updatedRequirementCount > 0) {
            $message .= " (Requirements: Inserted $insertedRequirementCount, Updated $updatedRequirementCount)";
        }
        if ($insertedEngagementCount > 0 || $updatedEngagementCount > 0) {
            $message .= " (Engagements: Inserted $insertedEngagementCount, Updated $updatedEngagementCount)";
        }
        return $message;

    } catch (Exception $e) {
        error_log("Stage Two Update Failed for Project ID {$projectUniqueId}: " . $e->getMessage());
        throw new Exception("Stage Two Update Failed: " . $e->getMessage());
    }
}



function updateStageThree($conn, $projectUniqueId, $inputData) {
    try {
        // Update the stagethree table
        $query = "UPDATE stagethree SET 
            stage_three_remarks = ?, 
            deal_size = ?, 
            technology = ?, 
            solution = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['stage_three_remarks'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['solution'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirement items in requirement_threetb
        $insertedRequirementCount = 0;
        $updatedRequirementCount = 0;

        if (!empty($inputData['requirement_three'])) {
            // Prepare statements
            $insertReqStmt = $conn->prepare("
                INSERT INTO requirement_threetb
                    (requirement_three, product_three, distributor_three, quantity, pricing, requirement_date, requirement_remarks_three, project_unique_id, requirement_id_3)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $updateReqStmt = $conn->prepare("
                UPDATE requirement_threetb
                SET requirement_three = ?,
                    product_three = ?,
                    distributor_three = ?,
                    quantity = ?,
                    pricing = ?,
                    requirement_date = ?,
                    requirement_remarks_three = ?
                WHERE requirement_id_3 = ?
                AND project_unique_id = ?
            ");

            $checkReqStmt = $conn->prepare("
                SELECT 1 
                FROM requirement_threetb
                WHERE requirement_id_3 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['requirement_three'] as $index => $requirement) {
                // Sanitize inputs
                $sanitizedRequirement = htmlspecialchars($requirement ?? '', ENT_QUOTES, 'UTF-8');
                $productThree = htmlspecialchars($inputData['product_three'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $distributorThree = htmlspecialchars($inputData['distributor_three'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($inputData['quantity'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $pricing = htmlspecialchars($inputData['pricing'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementDate = htmlspecialchars($inputData['requirement_date'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementRemarks = htmlspecialchars($inputData['requirement_remarks_three'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId = htmlspecialchars($inputData['requirement_id_3'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                // Skip insert if either product_three or distributor_three is 'Select'
                if ($productThree === 'Select' || $distributorThree === 'Select') {
                    error_log("Skipping insert for Project ID {$projectUniqueId} because product or distributor is 'Select'.");
                    continue;
                }

                // Only proceed if at least one field (requirement_three, product_three, distributor_three) is not empty
                if (empty($sanitizedRequirement) && empty($productThree) && empty($distributorThree)) {
                    error_log("Skipping blank requirement entry for Project ID {$projectUniqueId}. All fields are empty.");
                    continue;
                }

                // If requirement_id_3 exists and at least one field is not empty, proceed with the update or insert
                if (!empty($requirementId)) {
                    $updateReqStmt->execute([
                        $sanitizedRequirement,
                        $productThree,
                        $distributorThree,
                        $quantity,
                        $pricing,
                        $requirementDate,
                        $requirementRemarks,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateReqStmt->rowCount();
                    if ($updatedRows > 0) {
                        $updatedRequirementCount += $updatedRows;
                    } else {
                        // Check if requirement_id_3 exists, then insert if it doesn't
                        $checkReqStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkReqStmt->rowCount() === 0) {
                            // Insert the new requirement
                            $insertReqStmt->execute([
                                $sanitizedRequirement,
                                $productThree,
                                $distributorThree,
                                $quantity,
                                $pricing,
                                $requirementDate,
                                $requirementRemarks,
                                $projectUniqueId,
                                $requirementId
                            ]);
                            $insertedRequirementCount++;
                        }
                    }
                } else {
                    error_log("Empty requirement_id_3 for Project ID {$projectUniqueId}. Skipping insert.");
                }
            }
        }

        // Handle engagement items in engagement_threetb
        $insertedEngagementCount = 0;
        $updatedEngagementCount = 0;

        if (!empty($inputData['engagement_three'])) {
            // Prepare statements for insert, update, and check
            $insertEngStmt = $conn->prepare("
                INSERT INTO enagement_threetb
                    (engagement_three, engagement_date, engagement_remarks_three, project_unique_id, engagement_id_3)
                VALUES (?, ?, ?, ?, ?)
            ");

            $updateEngStmt = $conn->prepare("
                UPDATE enagement_threetb
                SET engagement_three = ?,
                    engagement_date = ?,
                    engagement_remarks_three = ?
                WHERE engagement_id_3 = ?
                AND project_unique_id = ?
            ");

            $checkEngStmt = $conn->prepare("
                SELECT 1 
                FROM enagement_threetb
                WHERE engagement_id_3 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['engagement_three'] as $index => $engagementType) {
                // Sanitize inputs
                $sanitizedEngagementType = htmlspecialchars($engagementType ?? '', ENT_QUOTES, 'UTF-8');
                $engagementDate = htmlspecialchars($inputData['engagement_date'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $engagementRemarks = htmlspecialchars($inputData['engagement_remarks_three'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $engagementId = htmlspecialchars($inputData['engagement_id_3'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                // Skip if any required fields are empty
                if (empty($sanitizedEngagementType) || empty($engagementDate) || empty($engagementRemarks) || empty($engagementId) || empty($projectUniqueId)) {
                    error_log("Skipping incomplete engagement entry for project ID: $projectUniqueId.");
                    continue;
                }

                // Attempt to update the engagement entry
                $updateEngStmt->execute([
                    $sanitizedEngagementType,
                    $engagementDate,
                    $engagementRemarks,
                    $engagementId,
                    $projectUniqueId
                ]);

                $updatedRows = $updateEngStmt->rowCount();
                if ($updatedRows > 0) {
                    // Increment count if updated
                    $updatedEngagementCount += $updatedRows;
                } else {
                    // Check if the engagement already exists, and if not, insert
                    $checkEngStmt->execute([$engagementId, $projectUniqueId]);
                    if ($checkEngStmt->rowCount() === 0) {
                        // Insert the engagement entry if not found
                        $insertEngStmt->execute([
                            $sanitizedEngagementType,
                            $engagementDate,
                            $engagementRemarks,
                            $projectUniqueId,
                            $engagementId
                        ]);
                        $insertedEngagementCount++;
                    }
                }
            }
        }

        
        // Insert data into stagefour table
        $stagefourQuery = "INSERT INTO stagefour (start_date_stage_four, end_date_stage_four, status_stage_four, project_unique_id) 
                           VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($stagefourQuery);
        $stmt->execute([
            date('Y-m-d'),
            'Not Yet Ended',
            'Ongoing',
            $projectUniqueId
        ]);

        // Update the stagethree table to mark as Completed
        $updateStageThreeStatusQuery = "UPDATE stagethree SET 
            status_stage_three = 'Completed', 
            end_date_stage_three = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageThreeStatusQuery);
        $stmt->execute([
            date('Y-m-d'),
            $projectUniqueId
        ]);

        // Update projecttb current_stage to the next stage
        $updateProjectStageQuery = "UPDATE projecttb
                                    SET current_stage = 'Stage 4'
                                    WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateProjectStageQuery);
        $stmt->execute([$projectUniqueId]);

        // Build final success message
        $message = "Stage Three updated successfully.";
        if ($insertedRequirementCount > 0 || $updatedRequirementCount > 0) {
            $message .= " (Requirements: Inserted $insertedRequirementCount, Updated $updatedRequirementCount)";
        }
        if ($insertedEngagementCount > 0 || $updatedEngagementCount > 0) {
            $message .= " (Engagements: Inserted $insertedEngagementCount, Updated $updatedEngagementCount)";
        }
        return $message;

    } catch (Exception $e) {
        throw new Exception("Stage Three Update Failed: " . $e->getMessage());
    }
}


function updateStageFour($conn, $projectUniqueId, $inputData) {
    try {
        // Update the stagefour table
        $query = "UPDATE stagefour SET 
            stage_four_remarks = ?, 
            product = ?, 
            deal_size = ?, 
            technology = ?, 
            solution = ?
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['stage_four_remarks'] ?? null,
            $inputData['product'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['solution'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirement items in requirement_fourtb
        $insertedRequirementCount = 0;
        $updatedRequirementCount = 0;

        if (!empty($inputData['requirement_four'])) {
            // Prepare statements
            $insertReqStmt = $conn->prepare("
                INSERT INTO requirement_fourtb
                    (requirement_four, product_four, distributor_four, quantity, pricing, date_required, requirement_remarks_four, project_unique_id, requirement_id_4)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $updateReqStmt = $conn->prepare("
                UPDATE requirement_fourtb
                SET requirement_four = ?,
                    product_four = ?,
                    distributor_four = ?,
                    quantity = ?,
                    pricing = ?,
                    date_required = ?,
                    requirement_remarks_four = ?
                WHERE requirement_id_4 = ?
                AND project_unique_id = ?
            ");

            $checkReqStmt = $conn->prepare("
                SELECT 1 
                FROM requirement_fourtb
                WHERE requirement_id_4 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['requirement_four'] as $index => $requirement) {
                // Sanitize inputs
                $sanitizedRequirement = htmlspecialchars($requirement ?? '', ENT_QUOTES, 'UTF-8');
                $productFour = htmlspecialchars($inputData['product_four'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $distributorFour = htmlspecialchars($inputData['distributor_four'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($inputData['quantity'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $pricing = htmlspecialchars($inputData['pricing'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $dateRequired = htmlspecialchars($inputData['date_required'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementRemarks = htmlspecialchars($inputData['requirement_remarks_four'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId = htmlspecialchars($inputData['requirement_id_4'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                // Skip insert if either product_four or distributor_four is 'Select'
                if ($productFour === 'Select' || $distributorFour === 'Select') {
                    error_log("Skipping insert for Project ID {$projectUniqueId} because product or distributor is 'Select'.");
                    continue;
                }

                // Only proceed if at least one field (requirement_four, product_four, distributor_four) is not empty
                if (empty($sanitizedRequirement) && empty($productFour) && empty($distributorFour)) {
                    error_log("Skipping blank requirement entry for Project ID {$projectUniqueId}. All fields are empty.");
                    continue;
                }

                // If requirement_id_4 exists and at least one field is not empty, proceed with the update or insert
                if (!empty($requirementId)) {
                    $updateReqStmt->execute([
                        $sanitizedRequirement,
                        $productFour,
                        $distributorFour,
                        $quantity,
                        $pricing,
                        $dateRequired,
                        $requirementRemarks,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateReqStmt->rowCount();
                    if ($updatedRows > 0) {
                        $updatedRequirementCount += $updatedRows;
                    } else {
                        // Check if requirement_id_4 exists, then insert if it doesn't
                        $checkReqStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkReqStmt->rowCount() === 0) {
                            // Insert the new requirement
                            $insertReqStmt->execute([
                                $sanitizedRequirement,
                                $productFour,
                                $distributorFour,
                                $quantity,
                                $pricing,
                                $dateRequired,
                                $requirementRemarks,
                                $projectUniqueId,
                                $requirementId
                            ]);
                            $insertedRequirementCount++;
                        }
                    }
                } else {
                    error_log("Empty requirement_id_4 for Project ID {$projectUniqueId}. Skipping insert.");
                }
            }
        }

        
        // Insert into stagefive with automated SPR_number
        $stagefiveQuery = "INSERT INTO stagefive (start_date_stage_five, end_date_stage_five, status_stage_five, project_unique_id) 
                        VALUES ( ?, ?, ?, ?)";
        $stmt = $conn->prepare($stagefiveQuery);
        $stmt->execute([
            date('Y-m-d'),
            'Not Yet Ended',
            'Ongoing',
            $projectUniqueId
        ]);


        // Update the stagefour table to mark as Completed
        $updateStageFourStatusQuery = "UPDATE stagefour SET 
            status_stage_four = 'Completed', 
            end_date_stage_four = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageFourStatusQuery);
        $stmt->execute([
            date('Y-m-d'),
            $projectUniqueId
        ]);

        // Update projecttb current_stage to the next stage
        $updateProjectStageQuery = "UPDATE projecttb
                                    SET current_stage = 'Stage 5'
                                    WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateProjectStageQuery);
        $stmt->execute([$projectUniqueId]);

        // Build final success message
        $message = "Stage Four Completed successfully.";
        if ($insertedRequirementCount > 0 || $updatedRequirementCount > 0) {
            $message .= " (Requirements: Inserted $insertedRequirementCount, Updated $updatedRequirementCount)";
        }
        return $message;
    } catch (Exception $e) {
        throw new Exception("Stage Four Update Failed: " . $e->getMessage());
    }
}


function updateStageFive($conn, $projectUniqueId, $inputData) {
    try {
        // Begin a transaction for atomicity
        $conn->beginTransaction();

        // Update the stagefive table
        $query = "UPDATE stagefive SET 
            SPR_number = ?,
            contract_duration = ?, 
            billing_type = ?, 
            pricing = ?, 
            solution = ?, 
            technology = ?, 
            deal_size = ?, 
            product = ?, 
            remarks_stage_five = ?
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['SPR_number'] ?? null,
            $inputData['contract_duration'] ?? null,
            $inputData['billing_type'] ?? null,
            $inputData['pricing'] ?? null,
            $inputData['solution'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['product'] ?? null,
            $inputData['remarks_stage_five'] ?? null,
            $projectUniqueId
        ]);

       // Handle requirement items in requirement_fivetb
        $insertedRequirementCount = 0;
        $updatedRequirementCount = 0;

        if (!empty($inputData['req_five'])) {
            // Prepare statements
            $insertReqStmt = $conn->prepare("
                INSERT INTO requirementfive_tb
                    (req_five, product_five, distributor_five, quantity, pricing, date_required, remarks_req, project_unique_id, requirement_id_5)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $updateReqStmt = $conn->prepare("
                UPDATE requirementfive_tb
                SET req_five = ?,
                    product_five = ?,
                    distributor_five = ?,
                    quantity = ?,
                    pricing = ?,
                    date_required = ?,
                    remarks_req = ?
                WHERE requirement_id_5 = ?
                AND project_unique_id = ?
            ");

            $checkReqStmt = $conn->prepare("
                SELECT 1 
                FROM requirementfive_tb
                WHERE requirement_id_5 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['req_five'] as $index => $requirement) {
                // Sanitize inputs
                $sanitizedRequirement = htmlspecialchars($requirement ?? '', ENT_QUOTES, 'UTF-8');
                $productFive = htmlspecialchars($inputData['product_five'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $distributorFive = htmlspecialchars($inputData['distributor_five'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($inputData['quantity'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $pricing = htmlspecialchars($inputData['pricing'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $dateRequired = htmlspecialchars($inputData['date_required'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementRemarks = htmlspecialchars($inputData['remarks_req'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId = htmlspecialchars($inputData['requirement_id_5'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                // Skip insert if either product_five or distributor_five is 'Select'
                if ($productFive === 'Select' || $distributorFive === 'Select') {
                    error_log("Skipping insert for Project ID {$projectUniqueId} because product or distributor is 'Select'.");
                    continue;
                }

                // Only proceed if at least one field (requirement_five, product_five, distributor_five) is not empty
                if (empty($sanitizedRequirement) && empty($productFive) && empty($distributorFive)) {
                    error_log("Skipping blank requirement entry for Project ID {$projectUniqueId}. All fields are empty.");
                    continue;
                }

                // If requirement_id_5 exists and at least one field is not empty, proceed with the update or insert
                if (!empty($requirementId)) {
                    $updateReqStmt->execute([
                        $sanitizedRequirement,
                        $productFive,
                        $distributorFive,
                        $quantity,
                        $pricing,
                        $dateRequired,
                        $requirementRemarks,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateReqStmt->rowCount();
                    if ($updatedRows > 0) {
                        $updatedRequirementCount += $updatedRows;
                    } else {
                        // Check if requirement_id_5 exists, then insert if it doesn't
                        $checkReqStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkReqStmt->rowCount() === 0) {
                            // Insert the new requirement
                            $insertReqStmt->execute([
                                $sanitizedRequirement,
                                $productFive,
                                $distributorFive,
                                $quantity,
                                $pricing,
                                $dateRequired,
                                $requirementRemarks,
                                $projectUniqueId,
                                $requirementId
                            ]);
                            $insertedRequirementCount++;
                        }
                    }
                } else {
                    error_log("Empty requirement_id_5 for Project ID {$projectUniqueId}. Skipping insert.");
                }
            }
        }

       // Handle upsell items in upsell_tb
        $insertedUpsellCount = 0;
        $updatedUpsellCount = 0;

        if (!empty($inputData['upsell'])) {
            // Prepare statements for upsell
            $insertUpsellStmt = $conn->prepare("
                INSERT INTO upsell_tb
                    (upsell, quantity_upsell, amount_upsell, remarks_upsell, project_unique_id, upsell_stage_5)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $updateUpsellStmt = $conn->prepare("
                UPDATE upsell_tb
                SET upsell = ?,
                    quantity_upsell = ?,
                    amount_upsell = ?,
                    remarks_upsell = ?
                WHERE upsell_stage_5 = ?
                AND project_unique_id = ?
            ");

            $checkUpsellStmt = $conn->prepare("
                SELECT 1
                FROM upsell_tb
                WHERE upsell_stage_5 = ?
                AND project_unique_id = ?
                LIMIT 1
            ");

            foreach ($inputData['upsell'] as $index => $upsell) {
                $sanitizedUpsell = htmlspecialchars($upsell ?? '', ENT_QUOTES, 'UTF-8');
                $quantityUpsell = htmlspecialchars($inputData['quantity_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $amountUpsell = htmlspecialchars($inputData['amount_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $remarksUpsell = htmlspecialchars($inputData['remarks_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $upsellId = htmlspecialchars($inputData['upsell_stage_5'][$index] ?? '', ENT_QUOTES, 'UTF-8');

                if (empty($sanitizedUpsell) || empty($quantityUpsell) || empty($amountUpsell)) {
                    error_log("Skipping blank upsell entry for Project ID {$projectUniqueId}.");
                    continue;
                }

                if (!empty($upsellId)) {
                    $updateUpsellStmt->execute([
                        $sanitizedUpsell,
                        $quantityUpsell,
                        $amountUpsell,
                        $remarksUpsell,
                        $upsellId,
                        $projectUniqueId
                    ]);

                    if ($updateUpsellStmt->rowCount() > 0) {
                        $updatedUpsellCount++;
                    } else {
                        $checkUpsellStmt->execute([$upsellId, $projectUniqueId]);
                        if ($checkUpsellStmt->rowCount() === 0) {
                            $insertUpsellStmt->execute([
                                $sanitizedUpsell,
                                $quantityUpsell,
                                $amountUpsell,
                                $remarksUpsell,
                                $projectUniqueId,
                                $upsellId
                            ]);
                            $insertedUpsellCount++;
                        }
                    }
                }
            }
        }

       

        // Update the stagefive table to mark as Completed (final stage)
        $updateStageFiveStatusQuery = "UPDATE stagefive SET 
            status_stage_five = 'Completed', 
            end_date_stage_five = ? 
            WHERE project_unique_id = ?";
        $statusStmt = $conn->prepare($updateStageFiveStatusQuery);
        $statusStmt->execute([
            date('Y-m-d'),
            $projectUniqueId
        ]);

        // Update projecttb current_stage to the next stage
        $updateProjectStageQuery = "UPDATE projecttb
                                    SET current_stage = 'Stage 5'
                                    WHERE project_unique_id = ?";
        $stageStmt = $conn->prepare($updateProjectStageQuery);
        $stageStmt->execute([$projectUniqueId]);

        // Commit the transaction
        $conn->commit();

       // Build final success message
        $message = "Stage Five updated successfully.";
        if ($insertedRequirementCount > 0 || $updatedRequirementCount > 0) {
            $message .= " (Requirements: Inserted $insertedRequirementCount, Updated $updatedRequirementCount)";
        }

        if ($insertedUpsellCount > 0 || $updatedUpsellCount > 0) {
            $message .= " (Upsells: Inserted $insertedUpsellCount, Updated $updatedUpsellCount)";
        }
        return $message;



    } catch (Exception $e) {
        $conn->rollBack(); // Rollback on error
        throw new Exception("Stage Five Update Failed: " . $e->getMessage());
    }
}



