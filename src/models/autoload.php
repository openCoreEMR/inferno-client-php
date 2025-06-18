<?php

/**
 * Autoload file for Inferno API models
 */

$modelFiles = [
    'BaseModel.php',
    'Version.php',
    'Message.php',
    'SessionData.php',
    'PresetSummary.php',
    'Input.php',
    'SuiteOption.php',
    'RequestSummary.php',
    'Request.php',
    'Result.php',
    'Requirement.php',
    'Test.php',
    'TestGroup.php',
    'TestSuite.php',
    'TestRun.php',
    'TestSession.php',
];

$modelBasePath = __DIR__ . '/';

foreach ($modelFiles as $file) {
    require_once $modelBasePath . $file;
}
