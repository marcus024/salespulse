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

        // 2) Handle requirement items in requirementone_tb
        $insertedCount = 0;
        $updatedCount  = 0;

        if (!empty($inputData['requirement_one'])) {
            // Prepare statements
            $insertStmt = $conn->prepare("
                INSERT INTO requirementone_tb
                    (requirement_one, project_unique_id, distributor_one, product_one, requirement_id_1)
                VALUES (?, ?, ?, ?, ?)
            ");

            $updateStmt = $conn->prepare("
                UPDATE requirementone_tb
                   SET requirement_one = ?,
                       distributor_one = ?,
                       product_one    = ?
                 WHERE requirement_id_1 = ?
                   AND project_unique_id = ?
            ");

            // We'll also need a check statement to see if the row truly exists
            $checkStmt = $conn->prepare("
                SELECT 1 
                  FROM requirementone_tb
                 WHERE requirement_id_1 = ? 
                   AND project_unique_id = ?
                LIMIT 1
            ");

            // Loop each row by index
            foreach ($inputData['requirement_one'] as $index => $reqValue) {
                // Sanitize
                $requirementOne = htmlspecialchars($reqValue ?? '', ENT_QUOTES, 'UTF-8');
                $productOne     = htmlspecialchars($inputData['product_one'][$index]     ?? '', ENT_QUOTES, 'UTF-8');
                $distributorOne = htmlspecialchars($inputData['distributor_one'][$index] ?? '', ENT_QUOTES, 'UTF-8');
                $requirementId  = $inputData['requirement_id_1'][$index]                ?? '';

                if (!empty($requirementId)) {
                    // Attempt UPDATE first
                    $updateStmt->execute([
                        $requirementOne,
                        $distributorOne,
                        $productOne,
                        $requirementId,
                        $projectUniqueId
                    ]);

                    $updatedRows = $updateStmt->rowCount();
                    if ($updatedRows > 0) {
                        // Data was actually changed
                        $updatedCount += $updatedRows;
                    } else {
                        // rowCount=0 => either row not found OR data unchanged
                        // Let's check if the row truly exists
                        $checkStmt->execute([$requirementId, $projectUniqueId]);
                        if ($checkStmt->rowCount() === 0) {
                            // No row => do Insert
                            $insertStmt->execute([
                                $requirementOne,
                                $projectUniqueId,
                                $distributorOne,
                                $productOne,
                                $requirementId
                            ]);
                            // MySQL often returns 0 for rowCount on INSERT, so manually increment
                            $insertedCount++;
                        } 
                        // else row found, but data is unchanged => do nothing
                    }
                } else {
                    // No requirementId => new row => always INSERT
                    $insertStmt->execute([
                        $requirementOne,
                        $projectUniqueId,
                        $distributorOne,
                        $productOne,
                        '' // or generate an ID if you want
                    ]);
                    // Manually increment for a successful insert
                    $insertedCount++;
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



