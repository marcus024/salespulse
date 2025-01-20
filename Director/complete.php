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
        // Update the stageone table
        $query = "UPDATE stageone SET 
            solution = ?, 
            technology = ?, 
            deal_size = ?, 
            distributor = ?, 
            stage_one_remarks = ?, 
            product = ?, 
            requirement_id_one = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['solution'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['distributor'] ?? null,
            $inputData['stage_one_remarks'] ?? null,
            $inputData['product'] ?? null,
            null,
            $projectUniqueId
        ]);

        // Handle requirements (update or insert based on presence of requirement_id_one)
        if (!empty($inputData['requirement_one'])) {
            $reqStmt = $conn->prepare("
                INSERT INTO requirementone_tb (project_unique_id, requirement_one) 
                VALUES (?, ?)
            ");
            
            // Loop through requirements and check for existing IDs
            foreach ($inputData['requirement_one'] as $index => $requirement) {
                // Check if there's a requirement_id for update
                if (isset($inputData['requirement_ids'][$index])) {
                    $requirementId = $inputData['requirement_ids'][$index];
                    // Update existing requirement
                    $updateQuery = "
                        UPDATE requirementone_tb 
                        SET requirement_one = ? 
                        WHERE requirement_id_one = ? AND project_unique_id = ?
                    ";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->execute([
                        htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8'),
                        $requirementId,
                        $projectUniqueId
                    ]);
                } else {
                    // Insert new requirement if no ID exists
                    $reqStmt->execute([
                        $projectUniqueId,
                        htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8')
                    ]);
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

        // Handle requirements for requirement_two
        if (!empty($inputData['requirement_two'])) {
            $requirementQuery = "INSERT INTO requirement_twotb (project_unique_id, requirement_two, requirement_date, requirement_remarks) 
                                VALUES (?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE requirement_two = ?, requirement_date = ?, requirement_remarks = ?";
            $stmt = $conn->prepare($requirementQuery);

            // Process parallel arrays
            foreach ($inputData['requirement_two'] as $index => $requirementTwo) {
                $requirementDate = $inputData['requirement_date'][$index] ?? null;
                $requirementRemarks = $inputData['requirement_remarks'][$index] ?? null;

                if (empty($requirementTwo)) {
                    error_log("Empty requirement_two for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $stmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($requirementTwo, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementRemarks ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementTwo, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementRemarks ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        // Handle engagements for engagement_type
        if (!empty($inputData['engagement_type'])) {
            $engagementQuery = "INSERT INTO engagement_twotb (project_unique_id, engagement_type, engagement_date, engagement_remarks) 
                                VALUES (?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE engagement_type = ?, engagement_date = ?, engagement_remarks = ?";
            $stmt = $conn->prepare($engagementQuery);

            // Process parallel arrays
            foreach ($inputData['engagement_type'] as $index => $engagementType) {
                $engagementDate = $inputData['engagement_date'][$index] ?? null;
                $engagementRemarks = $inputData['engagement_remarks'][$index] ?? null;

                if (empty($engagementType)) {
                    error_log("Empty engagement_type for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $stmt->execute([
                    htmlspecialchars($projectUniqueId, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementType, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementRemarks ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementType, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementRemarks ?? '', ENT_QUOTES, 'UTF-8')
                ]);
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
            product = ?, 
            deal_size = ?, 
            technology = ?, 
            solution = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['stage_three_remarks'] ?? null,
            $inputData['product'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['solution'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirements for requirement_three
        if (!empty($inputData['requirement_three'])) {
            $requirementQuery = "INSERT INTO requirement_threetb (
                                    project_unique_id, 
                                    requirement_three, 
                                    quantity, 
                                    bill_of_materials, 
                                    requirement_remarks_three, 
                                    pricing
                                 ) VALUES (?, ?, ?, ?, ?, ?) 
                                 ON DUPLICATE KEY UPDATE 
                                    requirement_three = VALUES(requirement_three), 
                                    quantity = VALUES(quantity), 
                                    bill_of_materials = VALUES(bill_of_materials), 
                                    requirement_remarks_three = VALUES(requirement_remarks_three), 
                                    pricing = VALUES(pricing)";
            $stmt = $conn->prepare($requirementQuery);

            // Process parallel arrays
            foreach ($inputData['requirement_three'] as $index => $requirementThree) {
                $quantity = $inputData['quantity'][$index] ?? null;
                $billOfMaterials = $inputData['bill_of_materials'][$index] ?? null;
                $requirementRemarks = $inputData['requirement_remarks_three'][$index] ?? null;
                $pricing = $inputData['pricing'][$index] ?? null;

                if (empty($requirementThree)) {
                    error_log("Empty requirement_three for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $stmt->execute([
                    htmlspecialchars($projectUniqueId, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementThree, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($quantity ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($billOfMaterials ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementRemarks ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($pricing ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        // Handle engagements for engagement_three
        if (!empty($inputData['engagement_three'])) {
            $engagementQuery = "INSERT INTO enagement_threetb (
                                    project_unique_id, 
                                    engagement_three, 
                                    engagement_date, 
                                    engagement_remarks_three
                                 ) VALUES (?, ?, ?, ?) 
                                 ON DUPLICATE KEY UPDATE 
                                    engagement_three = VALUES(engagement_three), 
                                    engagement_date = VALUES(engagement_date), 
                                    engagement_remarks_three = VALUES(engagement_remarks_three)";
            $stmt = $conn->prepare($engagementQuery);

            // Process parallel arrays
            foreach ($inputData['engagement_three'] as $index => $engagementThree) {
                $engagementDate = $inputData['engagement_date'][$index] ?? null;
                $engagementRemarks = $inputData['engagement_remarks_three'][$index] ?? null;

                if (empty($engagementThree)) {
                    error_log("Empty engagement_three for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $stmt->execute([
                    htmlspecialchars($projectUniqueId, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementThree, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementRemarks ?? '', ENT_QUOTES, 'UTF-8')
                ]);
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

        // Handle requirements for requirement_four
        if (!empty($inputData['requirement_four'])) {
            $requirementQuery = "INSERT INTO requirement_fourtb (
                                    project_unique_id, 
                                    requirement_four, 
                                    quantity, 
                                    bill_of_materials, 
                                    pricing, 
                                    date_required
                                ) VALUES (?, ?, ?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE 
                                    requirement_four = VALUES(requirement_four), 
                                    quantity = VALUES(quantity), 
                                    bill_of_materials = VALUES(bill_of_materials), 
                                    pricing = VALUES(pricing), 
                                    date_required = VALUES(date_required)";
            $stmt = $conn->prepare($requirementQuery);

            // Process parallel arrays
            foreach ($inputData['requirement_four'] as $index => $requirementFour) {
                $quantity = $inputData['quantity'][$index] ?? null;
                $billOfMaterials = $inputData['bill_of_materials'][$index] ?? null;
                $pricing = $inputData['pricing'][$index] ?? null;
                $dateRequired = $inputData['date_required'][$index] ?? null;

                if (empty($requirementFour)) {
                    error_log("Empty requirement_four for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $stmt->execute([
                    htmlspecialchars($projectUniqueId, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementFour, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($quantity ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($billOfMaterials ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($pricing ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($dateRequired ?? '', ENT_QUOTES, 'UTF-8')
                ]);
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

        // Handle requirements
        if (!empty($inputData['req_five'])) {
            $requirementQuery = "INSERT INTO requirementfive_tb (
                                    project_unique_id, 
                                    req_five, 
                                    quantity, 
                                    bills_materials_req, 
                                    remarks_req
                                ) VALUES (?, ?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE 
                                    req_five = VALUES(req_five), 
                                    quantity = VALUES(quantity), 
                                    bills_materials_req = VALUES(bills_materials_req), 
                                    remarks_req = VALUES(remarks_req)";
            $reqStmt = $conn->prepare($requirementQuery);

            foreach ($inputData['req_five'] as $index => $requirement) {
                $quantity = $inputData['quantity'][$index] ?? null;
                $billsMaterialsReq = $inputData['bills_materials_req'][$index] ?? null;
                $remarksReq = $inputData['remarks_req'][$index] ?? null;

                if (empty($requirement)) {
                    error_log("Empty requirement at index {$index} for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $reqStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8'),
                    $quantity ?? 0, // Numeric fields don't need htmlspecialchars
                    htmlspecialchars($billsMaterialsReq ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($remarksReq ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        // Handle upsells
        if (!empty($inputData['upsell'])) {
            $upsellQuery = "INSERT INTO upsell_tb (
                                project_unique_id, 
                                upsell, 
                                bills_materials_upsell, 
                                quantity_upsell, 
                                remarks_upsell, 
                                amount_upsell
                            ) VALUES (?, ?, ?, ?, ?, ?) 
                            ON DUPLICATE KEY UPDATE 
                                upsell = VALUES(upsell), 
                                bills_materials_upsell = VALUES(bills_materials_upsell), 
                                quantity_upsell = VALUES(quantity_upsell), 
                                remarks_upsell = VALUES(remarks_upsell), 
                                amount_upsell = VALUES(amount_upsell)";
            $upsellStmt = $conn->prepare($upsellQuery);

            foreach ($inputData['upsell'] as $index => $upsell) {
                $billsMaterialsUpsell = $inputData['bill_materials_upsell'][$index] ?? null;
                $quantityUpsell = $inputData['quantity_upsell'][$index] ?? null;
                $remarksUpsell = $inputData['remarks_upsell'][$index] ?? null;
                $amountUpsell = $inputData['amount_upsell'][$index] ?? null;

                if (empty($upsell)) {
                    error_log("Empty upsell at index {$index} for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $upsellStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($upsell, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($billsMaterialsUpsell ?? '', ENT_QUOTES, 'UTF-8'),
                    $quantityUpsell ?? 0, // Numeric fields don't need htmlspecialchars
                    htmlspecialchars($remarksUpsell ?? '', ENT_QUOTES, 'UTF-8'),
                    $amountUpsell ?? 0
                ]);
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
    } catch (Exception $e) {
        $conn->rollBack(); // Rollback on error
        throw new Exception("Stage Five Update Failed: " . $e->getMessage());
    }
}



