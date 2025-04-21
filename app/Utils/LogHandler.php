<?php

enum LogLevel: string
{
	case INFO = 'INFO';
	case WARNING = 'WARNING';
	case ERROR = 'ERROR';
	case DEBUG = 'DEBUG';
};

class LogHandler
{
	private ?string $filePath = null;

	public function __construct(string $filePath)
	{
		$this->filePath = $filePath;
	}

	public function log(string $message, LogLevel $level = LogLevel::INFO)
	{
		$logMessage = sprintf(
			"[%s] | %s | %s \n",
			date('Y-m-d h:i:s'),
			$level->value,
			$message
		);
		file_put_contents($this->filePath, $logMessage, FILE_APPEND);
	}

	public function info(string $message)
	{
		$this->log($message, LogLevel::INFO);
	}

	public function warning(string $message)
	{
		$this->log($message, LogLevel::WARNING);
	}

	public function error(string $message)
	{
		$this->log($message, LogLevel::ERROR);
	}

	public function debug(string $message)
	{
		$this->log($message, LogLevel::DEBUG);
	}
}
