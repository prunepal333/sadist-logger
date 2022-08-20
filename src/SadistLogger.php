<?php

namespace Sadist\Logger;
use Psr\Log\LogLevel;
class SadistLogger extends \Psr\Log\AbstractLogger
{
    const LOG_LEVEL_NONE = 'none';
    const LogLevel = [
        self::LOG_LEVEL_NONE => -1,
        LogLevel::DEBUG      => 0,
        LogLevel::INFO       => 1,
        LogLevel::NOTICE     => 2,
        LogLevel::WARNING    => 3,
        LogLevel::ERROR      => 4,
        LogLevel::CRITICAL   => 5,
        LogLevel::ALERT      => 6,
        LogLevel::EMERGENCY  => 7,
    ];

    /**
     * @var
     */
    private $stream; //➔ stdout, stderr, file
    private $logLevel;
    /**
     * @throws \Exception
     */
    public function __construct($stream, $logLevel='none')
    {
        $this->stream = is_file($stream) ? $this->getOutputStreamByFile($stream) : $stream;
        $this->ensureValidChannel($logLevel);
        $this->logLevel = $logLevel;
    }

    /**
     * @throws \Exception
     */
    protected function ensureValidChannel($channel){
        if(!array_key_exists($channel, self::LogLevel)){
            throw new \Exception("Invalid channel, channels must be one of " . implode(", ", array_keys(self::LogLevel)));
        }
    }
    /**
     * @inheritDoc
     */
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        if(self::LogLevel[$level] >= self::LogLevel[$this->logLevel]){
            $channel = strtoupper($level);
            fwrite($this->stream, $this->interpolate("[$channel]: {$message}\n", $context));
        }
    }

    /**
     * @throws \Exception
     */
    public function getOutputStreamByFile($file)
    {
        if(!is_file($file)){
            throw new \Exception("{$file} is a not a valid filepath, file expected");
        }
        return fopen($file, "w+");
    }
    /**
     * Interpolates context values into the message placeholders.
     */
    protected function interpolate($message, array $context = array()): string
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }


}