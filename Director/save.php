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

     // Process file uploads
    $uploadedFiles = [];
    if (!empty($_FILES)) {
        foreach ($_FILES as $fieldName => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $uniqueFileName = uniqid() . '_' . basename($file['name']);
                $uploadFilePath = $uploadDir . $uniqueFileName;

                if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                    $uploadedFiles[$fieldName] = $uploadFilePath; // Store file paths
                } else {
                    error_log("Failed to move uploaded file: {$file['name']}");
                }
            }
        }
    }

    // Add uploaded file paths to inputData for database handling
    foreach ($uploadedFiles as $field => $filePath) {
        $inputData[$field] = $filePath;
    }


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
        "uploaded_files" => $uploadedFiles, // Include uploaded file paths for debugging
        "processed_data" => $inputData,
        "details" => $message
    ]);
} catch (Exception $e) {
    ob_clean();
    file_put_contents(__DIR__ . '/debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(["message" => "Error occurred", "error" => $e->getMessage()]);
}

// Helper functions for different stages

function updateStageOne($conn, $projectUniqueId, $inputData) {
    // Implementation already provided
    try {
        $query = "UPDATE stageone SET 
            solution = ?, 
            technology = ?, 
            deal_size = ?, 
            distributor = ?, 
            stage_one_remarks = ?, 
            product = ? 
            WHERE project_unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $inputData['solution'] ?? null,
            $inputData['technology'] ?? null,
            $inputData['deal_size'] ?? null,
            $inputData['distributor'] ?? null,
            $inputData['stage_one_remarks'] ?? null,
            $inputData['product'] ?? null,
            $projectUniqueId
        ]);

        // Handle requirements
        if (!empty($inputData['requirement_one'])) {
            $requirementQuery = "INSERT INTO requirementone_tb (project_unique_id, requirement_one) 
                                 VALUES (?, ?)";
            $reqStmt = $conn->prepare($requirementQuery);

            foreach ($inputData['requirement_one'] as $requirement) {
                if (!empty($requirement)) {
                    $reqStmt->execute([$projectUniqueId, htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8')]);
                }
            }
        }
        return "Stage One updated successfully.";
    } catch (Exception $e) {
        error_log("Error in Stage One: " . $e->getMessage());
        throw $e;
    }
}

function updateStageTwo($conn, $projectUniqueId, $inputData) {
    try {
        // Update main stage two data
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

        // Insert or update requirements
        if (!empty($inputData['requirement_two'])) {
            $requirementQuery = "INSERT INTO requirement_twotb (project_unique_id, requirement_two, requirement_date, requirement_remarks) 
                                 VALUES (?, ?, ?, ?) 
                                 ON DUPLICATE KEY UPDATE 
                                 requirement_two = VALUES(requirement_two), 
                                 requirement_date = VALUES(requirement_date), 
                                 requirement_remarks = VALUES(requirement_remarks)";
            $reqStmt = $conn->prepare($requirementQuery);

            foreach ($inputData['requirement_two'] as $index => $requirement) {
                $requirementDate = $inputData['requirement_date'][$index] ?? null;
                $requirementRemarks = $inputData['requirement_remarks'][$index] ?? null;

                if (empty($requirement)) {
                    error_log("Empty requirement_two for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $reqStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementDate, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($requirementRemarks, ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        // Insert or update engagements
        if (!empty($inputData['engagement_type'])) {
            $engagementQuery = "INSERT INTO engagement_twotb (project_unique_id, engagement_type, engagement_date, engagement_remarks) 
                                VALUES (?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE 
                                engagement_type = VALUES(engagement_type), 
                                engagement_date = VALUES(engagement_date), 
                                engagement_remarks = VALUES(engagement_remarks)";
            $engStmt = $conn->prepare($engagementQuery);

            foreach ($inputData['engagement_type'] as $index => $engagementType) {
                $engagementDate = $inputData['engagement_date'][$index] ?? null;
                $engagementRemarks = $inputData['engagement_remarks'][$index] ?? null;

                if (empty($engagementType)) {
                    error_log("Empty engagement_type for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $engStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($engagementType, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementDate, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementRemarks, ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        return "Stage Two updated successfully.";
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

        // Handle requirements
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
            $reqStmt = $conn->prepare($requirementQuery);

            foreach ($inputData['requirement_three'] as $index => $requirement) {
                $quantity = $inputData['quantity'][$index] ?? null;
                $billOfMaterials = $inputData['bill_of_materials'][$index] ?? null;
                $requirementRemarks = $inputData['requirement_remarks_three'][$index] ?? null;
                $pricing = $inputData['pricing'][$index] ?? null;

                if (empty($requirement)) {
                    error_log("Empty requirement_three for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $reqStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8'),
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
            $engStmt = $conn->prepare($engagementQuery);

            foreach ($inputData['engagement_three'] as $index => $engagement) {
                $engagementDate = $inputData['engagement_date'][$index] ?? null;
                $engagementRemarks = $inputData['engagement_remarks_three'][$index] ?? null;

                if (empty($engagement)) {
                    error_log("Empty engagement_three for Project ID {$projectUniqueId}. Skipping insert.");
                    continue;
                }

                $engStmt->execute([
                    $projectUniqueId,
                    htmlspecialchars($engagement, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementDate ?? '', ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($engagementRemarks ?? '', ENT_QUOTES, 'UTF-8')
                ]);
            }
        }

        return "Stage Three updated successfully.";
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
