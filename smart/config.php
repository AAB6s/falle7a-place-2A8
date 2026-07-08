<?php

function load_env_file(string $path): void
{
    if (!is_file($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env_file(dirname(__DIR__) . '/.env');
load_env_file(__DIR__ . '/.env');

function env_value(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

define('STRIPE_SECRET_KEY', env_value('STRIPE_SECRET_KEY'));
define('STRIPE_PUBLISHABLE_KEY', env_value('STRIPE_PUBLISHABLE_KEY'));
define('SMTP_HOST', env_value('SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_USERNAME', env_value('SMTP_USERNAME'));
define('SMTP_PASSWORD', env_value('SMTP_PASSWORD'));
define('SMTP_FROM_EMAIL', env_value('SMTP_FROM_EMAIL', SMTP_USERNAME));
define('SMTP_FROM_NAME', env_value('SMTP_FROM_NAME', 'Falle7a'));
define('SMTP_PORT', (int) env_value('SMTP_PORT', '587'));
define('SMTP_SECURE', env_value('SMTP_SECURE', 'tls'));
define('JWT_SECRET', env_value('JWT_SECRET', 'falle7a-local-secret'));
define('JWT_ALGORITHM', env_value('JWT_ALGORITHM', 'HS256'));

class config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                $host = env_value('DB_HOST', 'localhost');
                $database = env_value('DB_NAME', 'falle7a');
                $user = env_value('DB_USER', 'root');
                $password = env_value('DB_PASSWORD');

                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$database;charset=utf8mb4",
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (Exception $e) {
                die('Database connection failed.');
            }
        }

        return self::$pdo;
    }
}

function configureMailer($mail): void
{
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port = SMTP_PORT;
    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
}
