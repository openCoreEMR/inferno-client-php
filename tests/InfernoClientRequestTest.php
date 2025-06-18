<?php

namespace OpenCoreEmr\InfernoClient\Tests;

use PHPUnit\Framework\TestCase;
use OpenCoreEmr\InfernoClient\InfernoClient;

/**
 * Test the request method and error handling in the InfernoClient
 */
class InfernoClientRequestTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = new InfernoClient('localhost', 4567, false);
    }

    /**
     * Helper method to call the private request method
     * 
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @param array $data
     * @return array
     */
    protected function callRequestMethod(string $method, string $endpoint, array $params = [], array $data = []): array
    {
        $reflection = new \ReflectionClass($this->client);
        $requestMethod = $reflection->getMethod('request');
        $requestMethod->setAccessible(true);
        
        return $requestMethod->invoke($this->client, $method, $endpoint, $params, $data);
    }

    /**
     * Test that the base URL is constructed correctly
     */
    public function testBaseUrlConstruction(): void
    {
        $reflection = new \ReflectionClass($this->client);
        $baseUrlProperty = $reflection->getProperty('baseUrl');
        $baseUrlProperty->setAccessible(true);
        
        $this->assertEquals('http://localhost:4567/api', $baseUrlProperty->getValue($this->client));
        
        // Test with HTTPS and default port
        $httpsClient = new InfernoClient('example.com', 443, true);
        $baseUrlProperty = $reflection->getProperty('baseUrl');
        $baseUrlProperty->setAccessible(true);
        
        $this->assertEquals('https://example.com/api', $baseUrlProperty->getValue($httpsClient));
    }

    /**
     * Test that the client methods match the API endpoints in swagger.yml
     * These tests validate the mapping between client methods and API endpoints
     */
    public function testApiEndpointMappings(): void
    {
        // Get the methods defined in the InfernoClient class
        $reflection = new \ReflectionClass($this->client);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        // Expected mappings between methods and endpoints
        $expectedMappings = [
            'getTestSuites' => '/test_suites',
            'getTestSuite' => '/test_suites/{testSuiteId}',
            'getTestSuiteRequirements' => '/test_suites/{testSuiteId}/requirements',
            'checkTestSuiteConfiguration' => '/test_suites/{testSuiteId}/check_configuration',
            'createTestSession' => '/test_sessions',
            'getTestSession' => '/test_sessions/{testSessionId}',
            'getTestSessionResults' => '/test_sessions/{testSessionId}/results',
            'getSessionData' => '/test_sessions/{testSessionId}/session_data',
            'applySessionDataPreset' => '/test_sessions/{testSessionId}/session_data/apply_preset',
            'createTestRun' => '/test_runs',
            'getTestRun' => '/test_runs/{testRunId}',
            'cancelTestRun' => '/test_runs/{testRunId}',
            'getLastTestRun' => '/test_sessions/{testSessionId}/last_test_run',
            'getTestRunResults' => '/test_runs/{testRunId}/results',
            'getRequest' => '/request/{requestId}',
            'getRequirement' => '/requirements/{requirementId}',
            'getVersion' => '/version'
        ];
        
        // Get the source code of the InfernoClient class
        $source = file_get_contents(__DIR__ . '/../src/InfernoClient.php');
        
        // Check that each expected endpoint is implemented
        foreach ($expectedMappings as $methodName => $endpoint) {
            // Check if the method exists
            $this->assertTrue($reflection->hasMethod($methodName), 
                "Method $methodName should exist to handle $endpoint endpoint");
                
            // For URLs with variable parts, only test for the fixed parts
            $endpointBase = explode('{', $endpoint)[0];
            if ($endpointBase === $endpoint) {
                // For fixed URLs, match exactly
                $this->assertStringContainsString($endpoint, $source,
                    "Method $methodName should use the endpoint $endpoint");
            } else {
                // For URLs with variable parts, match the base path
                $this->assertStringContainsString($endpointBase, $source,
                    "Method $methodName should use the endpoint base $endpointBase");
            }
        }
    }

    /**
     * Test that the method parameters match the API parameters
     * This specifically tests method signatures against swagger.yml expectations
     */
    public function testMethodParametersMatchApiDefinition(): void
    {
        $reflection = new \ReflectionClass($this->client);
        
        // Define expected method parameters
        $methodParameters = [
            'getTestSuites' => [],
            'getTestSuite' => ['testSuiteId'],
            'getTestSuiteRequirements' => ['testSuiteId', 'sessionId?'],
            'checkTestSuiteConfiguration' => ['testSuiteId'],
            'createTestSession' => ['testSuiteId', 'presetId?'],
            'getTestSession' => ['testSessionId'],
            'getTestSessionResults' => ['testSessionId', 'all?'],
            'getSessionData' => ['testSessionId'],
            'applySessionDataPreset' => ['testSessionId', 'presetId'],
            'createTestRun' => ['testRun'],
            'getTestRun' => ['testRunId', 'includeResults?', 'after?'],
            'cancelTestRun' => ['testRunId'],
            'getLastTestRun' => ['testSessionId'],
            'getTestRunResults' => ['testRunId'],
            'getRequest' => ['requestId'],
            'getRequirement' => ['requirementId'],
            'getVersion' => []
        ];
        
        // Check parameters for each method
        foreach ($methodParameters as $methodName => $expectedParams) {
            $method = $reflection->getMethod($methodName);
            $actualParams = $method->getParameters();
            
            // Check parameter count
            $this->assertCount(count($expectedParams), $actualParams,
                "Method $methodName should have " . count($expectedParams) . " parameter(s)");
                
            // Check each parameter
            foreach ($expectedParams as $i => $paramName) {
                $isOptional = str_ends_with($paramName, '?');
                $baseName = $isOptional ? substr($paramName, 0, -1) : $paramName;
                
                $this->assertEquals($baseName, $actualParams[$i]->getName(),
                    "Parameter $i of $methodName should be named $baseName");
                    
                if ($isOptional) {
                    $this->assertTrue($actualParams[$i]->isOptional(),
                        "Parameter $baseName of $methodName should be optional");
                } else {
                    $this->assertFalse($actualParams[$i]->isOptional(),
                        "Parameter $baseName of $methodName should be required");
                }
            }
        }
        
        // Test createTestSession method parameters
        $method = $reflection->getMethod('createTestSession');
        $parameters = $method->getParameters();
        $this->assertCount(2, $parameters);
        $this->assertEquals('testSuiteId', $parameters[0]->getName());
        $this->assertTrue($parameters[0]->isRequired());
        $this->assertEquals('presetId', $parameters[1]->getName());
        $this->assertFalse($parameters[1]->isRequired());
    }

    /**
     * Test that the method return types match the API response types
     */
    public function testMethodReturnTypesMatchApiDefinition(): void
    {
        $reflection = new \ReflectionClass($this->client);
        
        // Define expected return types
        $methodReturnTypes = [
            'getTestSuites' => 'array',
            'getTestSuite' => 'OpenCoreEmr\InfernoClient\Models\TestSuite',
            'getTestSuiteRequirements' => 'array',
            'checkTestSuiteConfiguration' => 'array',
            'createTestSession' => 'OpenCoreEmr\InfernoClient\Models\TestSession',
            'getTestSession' => 'OpenCoreEmr\InfernoClient\Models\TestSession',
            'getTestSessionResults' => 'array',
            'getSessionData' => 'array',
            'applySessionDataPreset' => 'bool',
            'createTestRun' => 'OpenCoreEmr\InfernoClient\Models\TestRun',
            'getTestRun' => 'OpenCoreEmr\InfernoClient\Models\TestRun',
            'cancelTestRun' => 'OpenCoreEmr\InfernoClient\Models\TestRun',
            'getLastTestRun' => 'OpenCoreEmr\InfernoClient\Models\TestRun',
            'getTestRunResults' => 'array',
            'getRequest' => 'OpenCoreEmr\InfernoClient\Models\Request',
            'getRequirement' => 'OpenCoreEmr\InfernoClient\Models\Requirement',
            'getVersion' => 'OpenCoreEmr\InfernoClient\Models\Version'
        ];
        
        // Check return type for each method
        foreach ($methodReturnTypes as $methodName => $expectedType) {
            $method = $reflection->getMethod($methodName);
            $actualType = $method->getReturnType();
            
            $this->assertNotNull($actualType,
                "Method $methodName should have a return type");
                
            $this->assertEquals($expectedType, $actualType->getName(),
                "Method $methodName should return $expectedType");
        }
    }
}
