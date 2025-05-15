<?php

require_once UTILS . "/LogHandler.php";
require_once UTILS . '/HttpMethod.php';

const CURRENT_CALLER_INDEX = 2;

/**
 * Class BaseResponseHandler
 *
 * This class is responsible for handling and formatting responses
 * within the application. It provides utility methods to standardize
 * the structure and content of responses sent to the client.
 *
 * @package App\Utils
 */
class BaseResponseHandler
{
	/**
	 * @var array $data
	 * An array to store data for the response handler.
	 */
	private array $data = [];

	/**
	 * Indicates whether the operation was successful.
	 *
	 * @var bool $success False by default, set to true if the operation succeeds.
	 */
	private bool $success = false;
	/**
	 * @var int|null The HTTP status code for the response.
	 */
	private ?int $statusCode;

	/**
	 * @var LogHandler $logger
	 * A logger instance used for handling logging operations within the BaseResponseHandler utility.
	 */
	public LogHandler $logger;


	/**
	 * Constructor for the BaseResponseHandler class.
	 *
	 * @param LogHandler $logger An instance of LogHandler for logging purposes.
	 */
	public function __construct()
	{
		$this->logger = LogHandler::getInstance();
	}

	/**
	 * Sets the response data for the application.
	 *
	 * @param array $data The data to be included in the response.
	 * @param bool $successStatus Indicates whether the response represents a successful operation.
	 * @param int $statusCode The HTTP status code to be associated with the response.
	 *
	 * @return void
	 */
	public function setResponseData(array $data, bool $successStatus, int $statusCode): void
	{
		$this->data = $data;
		$this->success = $successStatus;
		$this->statusCode = $statusCode;
	}

	/**
	 * Sends a response to the client.
	 *
	 * This method is responsible for handling and sending the appropriate
	 * response back to the client. It does not return any value.
	 *
	 * @return void
	 */
	public function sendResponse(): void
	{
		header('Content-Type: application/json');
		http_response_code($this->statusCode ?? 200);

		$json = json_encode([
			'success' => $this->success,
			'data' => $this->data,
		]);

		if ($json === false) {
			http_response_code(500);
			$this->logger->info("Encoding a response failed", callerIndex: CURRENT_CALLER_INDEX);
		} else {
			echo $json;
		}
	}
}

/**
 * Trait GenericResponseHandler
 *
 * A utility trait designed to handle generic responses within the application.
 * This trait provides reusable methods and logic for managing and formatting
 * responses in a consistent manner across different parts of the application.
 *
 * @package App\Utils
 */
trait GenericResponseHandler
{
	/**
	 * Handles cases where an incorrect or unsupported HTTP method is provided.
	 *
	 * @param HttpMethod|null $method The HTTP method that is supported . Can be null if no method is provided.
	 *
	 * @return void
	 */
	public function incorrectMethod(?HttpMethod $method): void
	{
		$this->logger->info('Sending "Incorrect Method" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => "Incorrect method used " . (isset($method) ? ", {$method->value} is required" : "")], false, 405);
		$this->sendResponse();
	}

	/**
	 * Handles the response for cases where the input provided is insufficient.
	 *
	 * @return void
	 */
	public function insufficientInput(): void
	{
		$this->logger->info('Sending "Insufficient input" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => "Required data was not sent"], false, 400);
		$this->sendResponse();
	}

	/**
	 * Handles database-related errors and provides a standardized response.
	 *
	 * @return void
	 */
	public function databaseError(): void
	{
		$this->logger->info('Sending "Database error" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => "A database error occured"], false, 500);
		$this->sendResponse();
	}

	public function serverError(): void
	{
		$this->logger->info('Sending "Server error" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => "A server error occured"], false, 500);
		$this->sendResponse();
	}
}

/**
 * Trait UserManagementResponseHandler
 *
 * This trait provides utility methods for handling user management-related responses
 * within the application. It is designed to streamline and standardize the way
 * responses are generated and processed in the context of user management.
 *
 * @package App\Utils
 */
trait UserManagementResponseHandler
{
	/**
	 * Handles the response for a successfully created user.
	 *
	 * @return void
	 */
	public function userCreated(): void
	{
		$this->logger->info('Sending "User created" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => 'User created succesfully'], true, 201);
		$this->sendResponse();
	}

	public function userExists(string $takenParam) : void{

		$this->logger->info("Sending \"$takenParam already taken\" response", callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => "$takenParam already taken"], false, 422);
		$this->sendResponse();
	}

	/**
	 * Handles the response for an incorrect email format.
	 *
	 * @return void
	 */
	public function incorrectMailFormat(): void
	{
		$this->logger->info('Sending "Incorrect mail format" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => 'Incorrect mail format was used'], false, 422);
		$this->sendResponse();
	}

	/**
	 * Handles the response for an incorrect username format.
	 *
	 * @return void
	 */
	public function incorrectUsernameFormat(): void
	{
		$this->logger->info('Sending "Incorrect username format" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => 'Incorrect username format was used'], false, 422);
		$this->sendResponse();
	}

	/**
	 * Handles the response for an incorrect password format scenario.
	 *
	 * @return void
	 */
	public function incorrectPasswordFormat(): void
	{
		$this->logger->info('Sending "Incorrect password format" response', callerIndex: CURRENT_CALLER_INDEX);
		$this->setResponseData(['message' => 'Incorrect password format was used'], false, 422);
		$this->sendResponse();
	}
}

/**
 * Class AllResponseHandler
 *
 * This class extends the BaseResponseHandler class and is responsible for handling
 * all types of responses within the application. It provides methods and logic
 * to process and manage responses effectively.
 *
 * @package App\Utils
 */
class AllResponseHandler extends BaseResponseHandler
{
	use GenericResponseHandler, UserManagementResponseHandler;

	private static ?AllResponseHandler $instance = null;
	
	public static function getInstance(){
		if (self::$instance == null){
			self::$instance = new AllResponseHandler();
		}
		return self::$instance;
	}
}
