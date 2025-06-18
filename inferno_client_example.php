<?php

/**
 * Example usage of the Inferno API client
 */
require_once 'vendor/autoload.php';

use OpenCoreEmr\InfernoClient\InfernoClient;

// Create a new client instance
$client = new InfernoClient(
    'localhost',     // Host name
    4567,            // Port number
    false            // Use HTTPS
);

try {    // Get the Inferno version
    $version = $client->getVersion();
    echo "Inferno Version: " . $version->version . "\n";

    // Get all available test suites
    $testSuites = $client->getTestSuites();
    echo "Found " . count($testSuites) . " test suites\n";

    if (!empty($testSuites)) {
        // Get the first test suite ID
        $testSuiteId = $testSuites[0]->id;
        echo "Using test suite ID: " . $testSuiteId . "\n";

        // Create a new test session with this test suite
        $testSession = $client->createTestSession($testSuiteId);
        echo "Created test session with ID: " . $testSession->id . "\n";

        // Create a test run for the test suite
        $testRun = $client->createTestRun([
            'test_session_id' => $testSession->id,
            'test_suite_id' => $testSuiteId
        ]);

        // Get the test run with results
        if (isset($testRun->id)) {
            echo "Created test run with ID: " . $testRun->id . "\n";

            // Check test run results
            $results = $client->getTestRunResults($testRun->id);
            echo "Got " . count($results) . " test results\n";

            // Display summary of results
            $statusCounts = ['pass' => 0, 'fail' => 0, 'skip' => 0, 'error' => 0, 'other' => 0];

            foreach ($results as $result) {
                if (isset($result->result)) {
                    $status = $result->result;
                    if (array_key_exists($status, $statusCounts)) {
                        $statusCounts[$status]++;
                    } else {
                        $statusCounts['other']++;
                    }
                }
            }

            echo "Results summary:\n";
            foreach ($statusCounts as $status => $count) {
                if ($count > 0) {
                    echo "  - {$status}: {$count}\n";
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
