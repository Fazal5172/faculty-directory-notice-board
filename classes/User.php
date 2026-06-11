<?php
/**
 * User Class
 * Handles all user-related database operations.
 * Passwords are always hashed with bcrypt — never stored in plain text.
 */
class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Register a new user. Password is hashed before storing.
     * Returns true on success, false if email already exists.
     */
    public function register(string $name, string $email, string $password, string $userType): bool
    {
        // Check for duplicate email
        $existing = $this->db->selectOne(
            'SELECT u_id FROM registration WHERE u_email = ?',
            's',
            [$email]
        );

        if ($existing) {
            return false; // Email already taken
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->db->execute(
            'INSERT INTO registration (u_name, u_email, u_password, u_type, status) VALUES (?, ?, ?, ?, ?)',
            'sssss',
            [$name, $email, $hashedPassword, $userType, 'Pending']
        );

        return true;
    }

    /**
     * Attempt a user login.
     * Returns the user row on success, null on failure.
     */
    public function login(string $email, string $password): ?array
    {
        $user = $this->db->selectOne(
            'SELECT * FROM registration WHERE u_email = ? AND status = ?',
            'ss',
            [$email, 'Accepted']
        );

        if (!$user) {
            return null; // Account not found or not approved
        }

        if (!password_verify($password, $user['u_password'])) {
            return null; // Wrong password
        }

        return $user;
    }

    /**
     * Get all registered users.
     */
    public function getAll(): array
    {
        return $this->db->select('SELECT u_id, u_name, u_email, u_type, status FROM registration ORDER BY u_id DESC');
    }

    /**
     * Get all pending registration requests.
     */
    public function getPendingRequests(): array
    {
        return $this->db->select(
            'SELECT * FROM registration WHERE status = ? ORDER BY u_id DESC',
            's',
            ['Pending']
        );
    }

    /**
     * Get a single user by ID.
     */
    public function findById(int $id): ?array
    {
        return $this->db->selectOne(
            'SELECT u_id, u_name, u_email, u_type, status FROM registration WHERE u_id = ?',
            'i',
            [$id]
        );
    }

    /**
     * Update a user's profile. Password is only updated when provided.
     */
    public function update(int $id, string $name, string $email, string $newPassword = ''): bool
    {
        if ($newPassword !== '') {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $affected = $this->db->execute(
                'UPDATE registration SET u_name = ?, u_email = ?, u_password = ? WHERE u_id = ?',
                'sssi',
                [$name, $email, $hashedPassword, $id]
            );
        } else {
            $affected = $this->db->execute(
                'UPDATE registration SET u_name = ?, u_email = ? WHERE u_id = ?',
                'ssi',
                [$name, $email, $id]
            );
        }

        return $affected > 0;
    }

    /**
     * Update a user's approval status (Accepted / Rejected / Pending).
     */
    public function updateStatus(int $id, string $status): bool
    {
        $allowed = ['Accepted', 'Rejected', 'Pending'];
        if (!in_array($status, $allowed, true)) {
            return false;
        }

        $affected = $this->db->execute(
            'UPDATE registration SET status = ? WHERE u_id = ?',
            'si',
            [$status, $id]
        );

        return $affected > 0;
    }

    /**
     * Delete a user by ID.
     */
    public function delete(int $id): bool
    {
        $affected = $this->db->execute(
            'DELETE FROM registration WHERE u_id = ?',
            'i',
            [$id]
        );
        return $affected > 0;
    }

    /**
     * Admin creates a user directly (status = Accepted immediately).
     */
    public function adminCreate(string $name, string $email, string $password, string $userType, string $status): bool
    {
        $existing = $this->db->selectOne(
            'SELECT u_id FROM registration WHERE u_email = ?',
            's',
            [$email]
        );
        if ($existing) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->db->execute(
            'INSERT INTO registration (u_name, u_email, u_password, u_type, status) VALUES (?, ?, ?, ?, ?)',
            'sssss',
            [$name, $email, $hashedPassword, $userType, $status]
        );

        return true;
    }
}
