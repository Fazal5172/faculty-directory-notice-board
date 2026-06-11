<?php
/**
 * Admin Class
 * Handles admin authentication.
 */
class Admin
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Attempt admin login.
     * Returns admin row on success, null on failure.
     */
    public function login(string $email, string $password): ?array
    {
        $admin = $this->db->selectOne(
            'SELECT * FROM admin WHERE email = ?',
            's',
            [$email]
        );

        if (!$admin) {
            return null;
        }

        // Support both legacy plain-text and hashed passwords
        // Once a plain-text password is detected, upgrade it automatically
        if (password_verify($password, $admin['password'])) {
            return $admin;
        }

        // Legacy plain-text fallback (for first login after migration)
        if ($password === $admin['password']) {
            // Auto-upgrade to hashed password
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $this->db->execute(
                'UPDATE admin SET password = ? WHERE id = ?',
                'si',
                [$hashed, $admin['id']]
            );
            $admin['password'] = $hashed;
            return $admin;
        }

        return null;
    }
}
