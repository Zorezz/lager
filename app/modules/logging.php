<?php
    class Logger {
        public string $path;

        public function __construct() {
            // set default value just in case.
            $this->path="logs/";
        }

        // writes access information to logfile
        public function ACC(): int {
            $log = date("M d H:i:s ") . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI'] . "\n";
            $log_path = $this->path . "access_" . date("Ymd") . ".log";
            if (file_put_contents($log_path, $log, FILE_APPEND)) {
                return 0;
            } else {
                return -1;
            }
        }

        // writes error messages to logfile
        public function ERR(string $logRow): int {
            $log = date("M d H:i:s ") . $logRow . "\n";
            $log_path = $this->path . "error_" . date("Ymd") . ".log";
            if (file_put_contents($log_path, $log, FILE_APPEND)) {
                return 0;
            } else {
                return -1;
            }
        }

        // writes DB changes to logfile
        public function DB(string $logRow): int {
            $log = date("M d H:i:s ") . $logRow . "\n";
            $log_path = $this->path . "db_" . date("Ymd") . ".log";
            if (file_put_contents($log_path, $log, FILE_APPEND)) {
                return 0;
            } else {
                return -1;
            }
        }
    }
?>
