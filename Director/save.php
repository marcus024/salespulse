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

    $step = intval($data['step']);
    $projectUniqueId = $data['project_unique_id'];
    $inputData = $data['data'];

    switch ($step) {
        case 1:
            $message = updateStageOne($conn, $projectUniqueId, $inputData);
            break;

        case 2:
            $message = updateStageTwo($conn, $projectUniqueId, $inputData);
            break;

        case 3:
            $message = updateStageThree($conn, $projectUniqueId, $inputData);
            break;

        case 4:
            $message = updateStageFour($conn, $projectUniqueId, $inputData);
            break;

        case 5:
            $message = updateStageFive($conn, $projectUniqueId, $inputData);
            break;

        default:
            ob_clean();
            echo json_encode(["message" => "Invalid step number"]);
            exit;
    }

    ob_clean();
    echo json_encode([
        "message" => "Step $step data processed successfully",
        "processed_data" => $inputData,
        "details" => $message
    ]);
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

        // 3) Build a final success message
        $message = "Stage One updated successfully.";
        if ($insertedCount > 0 || $updatedCount > 0) {
            $message .= " (Inserted $insertedCount, Updated $updatedCount requirements)";
        }

        return $message;
    } catch (Exception $e) {
        error_log("Error in Stage One: " . $e->getMessage());
        throw $e;
    }
}


function updateStageTwo($conn, $projectUniqueId, $inputData) {
    try {
        // Update main stage two dat
        $query = "UPDATE stagetwo SET 
            stage_two_remarks = ?, 
            technology = ?, 
            deal_size = ?, 
            solution = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['stage_two_remarks'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['deal_size'] ?? null,
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
        // Update main stage three data
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
        error_log("Stage Three Update Failed for Project ID {$projectUniqueId}: " . $e->getMessage());
        throw new Exception("Stage Three Update Failed: " . $e->getMessage());
    }
}

function updateStageFour($conn, $projectUniqueId, $inputData) {
    try {
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

        // Handle requirements
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
            $reqStmt = $conn->prepare($requirementQuery);

            foreach ($inputData['requirement_four'] as $index => $requirement) {
                $reqStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['quantity'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['bill_of_materials'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['pricing'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['date_required'][$index] ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }
        return "Stage Four updated successfully.";
    } catch (Exception $e) {
        error_log("Error in Stage Four: " . $e->getMessage());
        throw $e;
    }



}

function updateStageFive($conn, $projectUniqueId, $inputData) {
    try {
        $query = "UPDATE stagefive SET 
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
                $upsellStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($upsell, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['bills_materials_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['quantity_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['remarks_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($inputData['amount_upsell'][$index] ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }
        return "Stage Five updated successfully.";
    } catch (Exception $e) {
        error_log("Error in Stage Five: " . $e->getMessage());
        throw $e;
    }
}
