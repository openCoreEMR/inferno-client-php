<?php

namespace OpenCoreEmr\InfernoClient\Tests;

use PHPUnit\Framework\TestCase;
use OpenCoreEmr\InfernoClient\Models\Version;
use OpenCoreEmr\InfernoClient\Models\TestSuite;
use OpenCoreEmr\InfernoClient\Models\TestGroup;
use OpenCoreEmr\InfernoClient\Models\Test;
use OpenCoreEmr\InfernoClient\Models\Input;
use OpenCoreEmr\InfernoClient\Models\Requirement;
use OpenCoreEmr\InfernoClient\Models\Result;
use OpenCoreEmr\InfernoClient\Models\Request;
use OpenCoreEmr\InfernoClient\Models\RequestSummary;
use OpenCoreEmr\InfernoClient\Models\Message;
use OpenCoreEmr\InfernoClient\Models\TestSession;
use OpenCoreEmr\InfernoClient\Models\TestRun;
use OpenCoreEmr\InfernoClient\Models\SessionData;
use OpenCoreEmr\InfernoClient\Models\SuiteOption;
use OpenCoreEmr\InfernoClient\Models\PresetSummary;

/**
 * Tests for model classes to ensure they match swagger.yml definitions
 */
class ModelDefinitionsTest extends TestCase
{
    /**
     * Test Version model against swagger.yml definition
     */
    public function testVersionModel(): void
    {
        $reflection = new \ReflectionClass(Version::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('version'), "Version model should have 'version' property");
        
        // Test fromArray method
        $versionData = ['version' => '1.0.0'];
        $version = Version::fromArray($versionData);
        $this->assertInstanceOf(Version::class, $version);
        $this->assertEquals('1.0.0', $version->version);
    }
    
    /**
     * Test TestSuite model against swagger.yml definition
     */
    public function testTestSuiteModel(): void
    {
        $reflection = new \ReflectionClass(TestSuite::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "TestSuite model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('title'), "TestSuite model should have 'title' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('short_title'), "TestSuite model should have 'short_title' property");
        $this->assertTrue($reflection->hasProperty('description'), "TestSuite model should have 'description' property");
        $this->assertTrue($reflection->hasProperty('test_groups'), "TestSuite model should have 'test_groups' property");
        
        // Test fromArray method
        $testSuiteData = [
            'id' => 'suite1',
            'title' => 'Test Suite 1',
            'description' => 'A test suite',
            'test_groups' => [
                ['id' => 'group1', 'title' => 'Group 1']
            ]
        ];
        
        $testSuite = TestSuite::fromArray($testSuiteData);
        $this->assertInstanceOf(TestSuite::class, $testSuite);
        $this->assertEquals('suite1', $testSuite->id);
        $this->assertEquals('Test Suite 1', $testSuite->title);
    }

    /**
     * Test TestGroup model against swagger.yml definition
     */
    public function testTestGroupModel(): void
    {
        $reflection = new \ReflectionClass(TestGroup::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "TestGroup model should have 'id' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('title'), "TestGroup model should have 'title' property");
        $this->assertTrue($reflection->hasProperty('tests'), "TestGroup model should have 'tests' property");
        
        // Test fromArray method
        $testGroupData = [
            'id' => 'group1',
            'title' => 'Test Group 1',
            'tests' => [
                ['id' => 'test1', 'name' => 'Test 1']
            ]
        ];
        
        $testGroup = TestGroup::fromArray($testGroupData);
        $this->assertInstanceOf(TestGroup::class, $testGroup);
        $this->assertEquals('group1', $testGroup->id);
        $this->assertEquals('Test Group 1', $testGroup->title);
    }
    
    /**
     * Test Test model against swagger.yml definition
     */
    public function testTestModel(): void
    {
        $reflection = new \ReflectionClass(Test::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "Test model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('title'), "Test model should have 'title' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('description'), "Test model should have 'description' property");
        $this->assertTrue($reflection->hasProperty('inputs'), "Test model should have 'inputs' property");
        
        // Test fromArray method
        $testData = [
            'id' => 'test1',
            'title' => 'Test 1',
            'description' => 'A test',
            'inputs' => [
                ['name' => 'input1', 'value' => 'value1']
            ]
        ];
        
        $test = Test::fromArray($testData);
        $this->assertInstanceOf(Test::class, $test);
        $this->assertEquals('test1', $test->id);
        $this->assertEquals('Test 1', $test->title);
    }
    
    /**
     * Test Input model against swagger.yml definition
     */
    public function testInputModel(): void
    {
        $reflection = new \ReflectionClass(Input::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('name'), "Input model should have 'name' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('value'), "Input model should have 'value' property");
        $this->assertTrue($reflection->hasProperty('title'), "Input model should have 'title' property");
        
        // Test fromArray method
        $inputData = [
            'name' => 'input1',
            'value' => 'value1',
            'title' => 'Input 1',
            'description' => 'An input',
            'optional' => true
        ];
        
        $input = Input::fromArray($inputData);
        $this->assertInstanceOf(Input::class, $input);
        $this->assertEquals('input1', $input->name);
        $this->assertEquals('value1', $input->value);
    }
    
    /**
     * Test Requirement model against swagger.yml definition
     */
    public function testRequirementModel(): void
    {
        $reflection = new \ReflectionClass(Requirement::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "Requirement model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('requirement'), "Requirement model should have 'requirement' property");
        $this->assertTrue($reflection->hasProperty('conformance'), "Requirement model should have 'conformance' property");
        $this->assertTrue($reflection->hasProperty('actor'), "Requirement model should have 'actor' property");
        
        // Test fromArray method
        $requirementData = [
            'id' => 'req1',
            'requirement' => 'Must support Patient resource',
            'conformance' => 'SHALL',
            'actor' => 'Client',
            'conditionality' => 'Optional',
            'url' => 'http://example.com/requirements'
        ];
        
        $requirement = Requirement::fromArray($requirementData);
        $this->assertInstanceOf(Requirement::class, $requirement);
        $this->assertEquals('req1', $requirement->id);
        $this->assertEquals('Must support Patient resource', $requirement->requirement);
        $this->assertEquals('SHALL', $requirement->conformance);
    }
    
    /**
     * Test Result model against swagger.yml definition
     */
    public function testResultModel(): void
    {
        $reflection = new \ReflectionClass(Result::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "Result model should have 'id' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('result'), "Result model should have 'result' property");
        $this->assertTrue($reflection->hasProperty('result_message'), "Result model should have 'result_message' property");
        $this->assertTrue($reflection->hasProperty('requests'), "Result model should have 'requests' property");
        
        // Test fromArray method
        $resultData = [
            'id' => 'result1',
            'test_id' => 'test1',
            'result' => 'pass',
            'result_message' => 'Test passed',
            'created_at' => '2025-06-18T12:00:00Z'
        ];
        
        $result = Result::fromArray($resultData);
        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals('result1', $result->id);
        $this->assertEquals('pass', $result->result);
    }
    
    /**
     * Test Request model against swagger.yml definition
     */
    public function testRequestModel(): void
    {
        $reflection = new \ReflectionClass(Request::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "Request model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('index'), "Request model should have 'index' property");
        $this->assertTrue($reflection->hasProperty('created_at'), "Request model should have 'created_at' property");
        $this->assertTrue($reflection->hasProperty('verb'), "Request model should have 'verb' property");
        $this->assertTrue($reflection->hasProperty('url'), "Request model should have 'url' property");
        $this->assertTrue($reflection->hasProperty('direction'), "Request model should have 'direction' property");
        $this->assertTrue($reflection->hasProperty('result_id'), "Request model should have 'result_id' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('request_headers'), "Request model should have 'request_headers' property");
        $this->assertTrue($reflection->hasProperty('response_headers'), "Request model should have 'response_headers' property");
        
        // Test fromArray method
        $requestData = [
            'id' => 'req1',
            'index' => 1,
            'created_at' => '2025-06-18T12:00:00Z',
            'verb' => 'GET',
            'url' => 'https://example.com/fhir/Patient/123',
            'direction' => 'out',
            'status' => 200,
            'result_id' => 'result1',
            'request_headers' => [['name' => 'Accept', 'value' => 'application/json']],
            'response_headers' => [['name' => 'Content-Type', 'value' => 'application/json']],
            'request_body' => '{}',
            'response_body' => '{"resourceType":"Patient"}'
        ];
        
        $request = Request::fromArray($requestData);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req1', $request->id);
        $this->assertEquals('GET', $request->verb);
        $this->assertEquals('out', $request->direction);
    }
    
    /**
     * Test RequestSummary model against swagger.yml definition
     */
    public function testRequestSummaryModel(): void
    {
        $reflection = new \ReflectionClass(RequestSummary::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "RequestSummary model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('index'), "RequestSummary model should have 'index' property");
        $this->assertTrue($reflection->hasProperty('created_at'), "RequestSummary model should have 'created_at' property");
        $this->assertTrue($reflection->hasProperty('verb'), "RequestSummary model should have 'verb' property");
        $this->assertTrue($reflection->hasProperty('url'), "RequestSummary model should have 'url' property");
        $this->assertTrue($reflection->hasProperty('direction'), "RequestSummary model should have 'direction' property");
        $this->assertTrue($reflection->hasProperty('result_id'), "RequestSummary model should have 'result_id' property");
        
        // Test fromArray method
        $requestSummaryData = [
            'id' => 'req1',
            'index' => 1,
            'created_at' => '2025-06-18T12:00:00Z',
            'verb' => 'GET',
            'url' => 'https://example.com/fhir/Patient/123',
            'direction' => 'out',
            'status' => 200,
            'result_id' => 'result1'
        ];
        
        $requestSummary = RequestSummary::fromArray($requestSummaryData);
        $this->assertInstanceOf(RequestSummary::class, $requestSummary);
        $this->assertEquals('req1', $requestSummary->id);
        $this->assertEquals('GET', $requestSummary->verb);
    }
    
    /**
     * Test Message model against swagger.yml definition
     */
    public function testMessageModel(): void
    {
        $reflection = new \ReflectionClass(Message::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('type'), "Message model should have 'type' property");
        $this->assertTrue($reflection->hasProperty('message'), "Message model should have 'message' property");
        
        // Test fromArray method
        $messageData = [
            'type' => 'info',
            'message' => 'Information message'
        ];
        
        $message = Message::fromArray($messageData);
        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('info', $message->type);
        $this->assertEquals('Information message', $message->message);
    }

    /**
     * Test TestSession model against swagger.yml definition
     */
    public function testTestSessionModel(): void
    {
        $reflection = new \ReflectionClass(TestSession::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "TestSession model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('test_suite'), "TestSession model should have 'test_suite' property");
        
        // Test fromArray method
        $testSessionData = [
            'id' => 'session1',
            'test_suite' => [
                'id' => 'suite1',
                'title' => 'Test Suite 1'
            ]
        ];
        
        $testSession = TestSession::fromArray($testSessionData);
        $this->assertInstanceOf(TestSession::class, $testSession);
        $this->assertEquals('session1', $testSession->id);
    }
    
    /**
     * Test TestRun model against swagger.yml definition
     */
    public function testTestRunModel(): void
    {
        $reflection = new \ReflectionClass(TestRun::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('id'), "TestRun model should have 'id' property");
        $this->assertTrue($reflection->hasProperty('test_session_id'), "TestRun model should have 'test_session_id' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('test_suite_id'), "TestRun model should have 'test_suite_id' property");
        $this->assertTrue($reflection->hasProperty('test_group_id'), "TestRun model should have 'test_group_id' property");
        $this->assertTrue($reflection->hasProperty('test_id'), "TestRun model should have 'test_id' property");
        
        // Test fromArray method
        $testRunData = [
            'id' => 'run1',
            'test_session_id' => 'session1',
            'test_count' => 5,
            'inputs' => [
                ['name' => 'input1', 'value' => 'value1']
            ]
        ];
        
        $testRun = TestRun::fromArray($testRunData);
        $this->assertInstanceOf(TestRun::class, $testRun);
        $this->assertEquals('run1', $testRun->id);
        $this->assertEquals('session1', $testRun->test_session_id);
    }
    
    /**
     * Test SessionData model against swagger.yml definition
     */
    public function testSessionDataModel(): void
    {
        $reflection = new \ReflectionClass(SessionData::class);
        
        // Check required properties
        $this->assertTrue($reflection->hasProperty('name'), "SessionData model should have 'name' property");
        
        // Check optional properties
        $this->assertTrue($reflection->hasProperty('value'), "SessionData model should have 'value' property");
        
        // Test fromArray method
        $sessionDataArray = [
            'name' => 'param1',
            'value' => 'value1'
        ];
        
        $sessionData = SessionData::fromArray($sessionDataArray);
        $this->assertInstanceOf(SessionData::class, $sessionData);
        $this->assertEquals('param1', $sessionData->name);
        $this->assertEquals('value1', $sessionData->value);
    }
}
