<?php
/**
 * Auth Class
 * Manages sessions and access control.
 */
class Auth
{
    /**
     * Start a secure session.
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_strict_mode', 1);
            session_set_cookie_params(['samesite' => 'Strict']);
            session_start();
        }
    }

    /**
     * Log in a regular user and store their data in the session.
     */
    public static function loginUser(array $user): void
    {
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id']   = $user['u_id'];
        $_SESSION['user_name'] = $user['u_name'];
        $_SESSION['user_email']= $user['u_email'];
        $_SESSION['user_type'] = $user['u_type'];
        $_SESSION['role']      = 'user';
    }

    /**
     * Log in an admin and store their data in the session.
     */
    public static function loginAdmin(array $admin): void
    {
        session_regenerate_id(true);
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        $_SESSION['admin_email']= $admin['email'];
        $_SESSION['admin_role'] = $admin['role'];
        $_SESSION['role']       = 'admin';
    }

    /**
     * Require user to be logged in. Redirect to login if not.
     */
    public static function requireUser(): void
    {
        self::startSession();
        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'user') {
            header('Location: ' . APP_URL . '/index.php');
            exit;
        }
    }

    /**
     * Require admin to be logged in. Redirect to admin login if not.
     */
    public static function requireAdmin(): void
    {
        self::startSession();
        if (empty($_SESSION['admin_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . APP_URL . '/admin/index.php');
            exit;
        }
    }

    /**
     * Destroy session and log out.
     */
    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Check if a user is currently logged in.
     */
    public static function isUserLoggedIn(): bool
    {
        self::startSession();
        return !empty($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'user';
    }

    /**
     * Check if an admin is currently logged in.
     */
    public static function isAdminLoggedIn(): bool
    {
        self::startSession();
        return !empty($_SESSION['admin_id']) && ($_SESSION['role'] ?? '') === 'admin';
    }
}
