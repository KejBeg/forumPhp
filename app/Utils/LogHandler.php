<?php
const DEFAULT_CALLER_INDEX = 1;

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
	private static ?LogHandler $instance = null;

	private function __construct()
	{
		$this->filePath = LOG_FILE_PATH;
	}

	  public static function getInstance() {
		if (self::$instance == null){
			self::$instance = new LogHandler();
		}
        return self::$instance;
    }

	public function log(string $message, LogLevel $level = LogLevel::INFO, int $callerIndex =  DEFAULT_CALLER_INDEX): void
	{

		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
		$caller = $backtrace[$callerIndex] ?? null;

		$callerFile = isset($caller['file']) ? basename($caller['file']) : 'unknown';
		$callerLine = $caller['line'] ?? 0;

		$logMessage = sprintf(
			"[%s] | %s | %s | %s | %s \n",
			date('Y-m-d h:i:s'),
			$level->value,
			$callerFile,
			$callerLine,
			$message
		);
		file_put_contents($this->filePath, $logMessage, FILE_APPEND);
	}

	public function info(string $message, int $callerIndex =  DEFAULT_CALLER_INDEX): void
	{
		$this->log($message, LogLevel::INFO, callerIndex: $callerIndex);
	}

	public function warning(string $message, int $callerIndex =  DEFAULT_CALLER_INDEX): void
	{
		$this->log($message, LogLevel::WARNING, callerIndex: $callerIndex);
	}

	public function error(string $message, int $callerIndex =  DEFAULT_CALLER_INDEX): void
	{
		$this->log($message, LogLevel::ERROR, callerIndex: $callerIndex);
	}

	public function debug(string $message, int $callerIndex =  DEFAULT_CALLER_INDEX): void
	{
		$this->log($message, LogLevel::DEBUG, callerIndex: $callerIndex);
	}
}
