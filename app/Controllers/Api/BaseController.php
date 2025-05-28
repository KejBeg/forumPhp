<?php

require_once UTILS . '/HttpMethod.php';
require_once UTILS . '/ResponseHandler.php';
require_once UTILS . '/LogHandler.php';

class BaseController
{
	protected ?HttpMethod $requiredMethod = null;
	protected ?array $requiredInputs = null;
	protected LogHandler $logger;
	protected AllResponseHandler $responseHandler;
	protected ?array $requestJson = null;
	public ?string $accessToken = null;

	public function __construct()
	{
		$this->logger = LogHandler::getInstance();
		$this->responseHandler = AllResponseHandler::getInstance();
	}

	public function verifyMethod(): void
	{
		if ($_SERVER['REQUEST_METHOD'] != $this->requiredMethod->value) {
			$this->responseHandler->incorrectMethod($this->requiredMethod);
			exit;
		}
	}

	public function checkRequiredInputs(): void
	{
		if ($this->requestJson== null) {
			return;
		}

		foreach ($this->requiredInputs as $var) {
			if (!isset($this->requestJson[$var])) {
				$this->responseHandler->insufficientInput();
				exit;
			}
		}
	}
}
