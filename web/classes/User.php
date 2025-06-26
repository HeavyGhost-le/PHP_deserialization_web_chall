<?php
class User {
    private $name;
    private $token;
    private $logger;
    private $isAdmin = false;

    public function __construct($name, $token) {
        $this->name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->token = $token;
        $this->logger = new Logger();

        if ($name === 'admin' && $token === 'supersecret') {
            $this->isAdmin = true;
        }
    }

    public function getWelcomeMessage() {
        $msg = "<h1>Welcome, <span style=\"color:#00ffaa\">" .
               htmlspecialchars($this->name) . "</span></h1>";

        if ($this->isAdmin) {
            $msg .= "<div class=\"admin-panel\">" .
                    file_get_contents('flag.txt') .
                    "</div>";
        }

        return $msg;
    }

    public function getToken() {
        return $this->token;
    }

    public function __serialize() {
        return [
            'name' => $this->name,
            'token' => $this->token,
            'isAdmin' => $this->isAdmin
        ];
    }

    public function __unserialize($data) {
        $this->name = $data['name'];
        $this->token = $data['token'];
        $this->isAdmin = $data['isAdmin'];
        $this->logger = new Logger();
    }

    public function __destruct() {
        $this->logger->log("User  " . $this->name . " action");
    }
}
