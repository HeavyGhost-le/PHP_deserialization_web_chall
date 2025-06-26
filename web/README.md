🧨 Vulnerability
🔐 PHP Object Injection (POI)

The User object is serialized and sent to the client, then unserialized without validation, creating an attack surface for:

    Magic methods like __wakeup, __destruct, or __toString

    Code execution via gadget chains in custom or built-in classes

    Session manipulation or privilege escalation

Even though the app uses HMAC verification, attackers can:

    Craft a malicious object with a known token

    Bypass logic if token validation is flawed or predictable

    Exploit insecure magic methods if present in User.php or other included classes

🧰 Features

    🔐 Hardened PHP Environment (via Docker):

        Dangerous PHP functions disabled: exec, system, etc.

        allow_url_include=Off, expose_php=Off

    🍪 Cookie-based Session Simulation with serialization

    🐛 Debug Logging via error_log() for development visibility

    🎨 Cyberpunk login interface with animated glitch text

⚙️ Deployment

    Clone the repo:

git clone https://github.com/your-username/php_des1.git
cd php_des1

Start the container:

docker-compose up --build

Access the lab in browser:

    http://localhost:8081

🎯 Objectives (CTF Ideas)

    🧪 Exploit PHP object injection via the profile cookie

    🧩 Bypass token validation or forge a valid token

    🏁 Retrieve the hidden flag from flag.txt

📌 Disclaimer

    This project is intended for educational purposes only. Use it to learn about PHP object injection and how to defend against insecure serialization in real-world applications.
