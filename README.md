# 🧠 PHP Deserialization Web Challenge — *Idle Transfiguration v2*

A realistic CTF-style web challenge simulating a hardened PHP environment vulnerable to **object injection via insecure deserialization**.

This challenge is ideal for CTF players, red teamers, and students who want to practice advanced PHP security exploitation involving serialized objects, HMAC integrity checks, and bypass logic.


## 🔍 Challenge Overview

- ⚙️ **Base Image**: `php:8.2-apache`
- 🌐 **Port**: `8081`
- 📥 **Input**: Username (via login form)
- 🍪 **Cookies**:
  - `profile`: Serialized and base64-encoded PHP object
  - `token`: HMAC of a secret token tied to the object
- 📦 **Vulnerability**: Insecure deserialization
- 🔐 **Hardening in place**:
  - Dangerous functions disabled: `exec`, `passthru`, `shell_exec`, `system`, `proc_open`, `popen`
  - `allow_url_include=Off`, `expose_php=Off`


## 🗂️ File Structure

```
├── Dockerfile
├── docker-compose.yml
└── web/
├── index.php → Redirects to login.php
├── login.php → Creates and serializes User object
├── user.php → Unserializes and validates User object
├── includes/
│ └── bootstrap.php → Contains SECRET_KEY
├── classes/
│ └── User.php → User class used in serialization
└── assets/
└── logs.txt → Debug logs
```


## 🚀 Getting Started

### 🔧 Prerequisites

- Docker
- Docker Compose

### ▶️ Run the Lab

```bash
git clone https://github.com/HeavyGhost-le/PHP_deserialization_web_chall.git
cd PHP_deserialization_web_chall
docker-compose up --build
```

🧪 Exploitation Objective

    Analyze the structure of the User class (in classes/User.php).

    Craft a malicious serialized object payload that leverages a magic method like __wakeup, __destruct, or __toString.

    Forge or reuse a valid token value by understanding or bypassing the HMAC logic.

    Achieve code execution or flag retrieval.

    Extract the flag located at /var/www/html/flag.txt.

💡 How It Works

    The app takes your username, creates a User object with a random token.

    This object is serialized and base64-encoded into a profile cookie.

    A token cookie is generated using hash_hmac('sha256', $token, SECRET_KEY).

    In user.php, the profile cookie is base64-decoded and unserialized — this is where the vulnerability exists.

    If the User class contains dangerous magic methods, PHP Object Injection is possible.

🧠 Learning Objectives

    Understand how insecure deserialization works in PHP

    Learn how HMAC validation interacts with user-controlled data

    Bypass logic when weak assumptions are made on user input

    Practice real-world exploitation of hardened environments


⚠️ Disclaimer

This project is provided for educational purposes only.
Do NOT deploy in production or use without proper authorization.
Only run and test in local, private, and legal environments.
