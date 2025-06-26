<?php
class Logger {
    private $logFile = "/var/www/html/assets/logs.txt";
    protected $logData;

    public function log($data) {
        try {
            if (!isset($this->logData)) {
                $this->logData = date('[Y-m-d H:i:s]') . " " . $data . PHP_EOL;
            }
            file_put_contents($this->logFile, $this->logData, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            error_log("Logger error: " . $e->getMessage());
        }
    }

    public function __wakeup() {
        if (isset($this->logData) && strpos($this->logData, '<?') !== false) {
            $this->logData = "Blocked malicious input";
        }
    }
}
