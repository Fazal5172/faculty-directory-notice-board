<?php
/**
 * Notice Class
 * Handles all notice board CRUD operations.
 */
class Notice
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Publish a new notice.
     */
    public function create(string $subject, string $detail, string $category, string $publisherName, string $publisherRole): int
    {
        $date = date('d-M-Y');

        $this->db->execute(
            'INSERT INTO notices (subject, detail, date, user, category, role) VALUES (?, ?, ?, ?, ?, ?)',
            'ssssss',
            [$subject, $detail, $date, $publisherName, $category, $publisherRole]
        );

        return $this->db->lastInsertId();
    }

    /**
     * Get all notices ordered by newest first.
     */
    public function getAll(): array
    {
        return $this->db->select('SELECT * FROM notices ORDER BY ID DESC');
    }

    /**
     * Get a single notice by ID.
     */
    public function findById(int $id): ?array
    {
        return $this->db->selectOne(
            'SELECT * FROM notices WHERE ID = ?',
            'i',
            [$id]
        );
    }

    /**
     * Get notices visible to a specific user.
     * Returns notices sent to: their email, their user-type group, or everyone.
     */
    public function getForUser(string $email, string $userType): array
    {
        $groupCategory = ($userType === 'Teacher') ? 'All Teachers' : 'All Students';

        return $this->db->select(
            'SELECT * FROM notices
             WHERE category = ? OR category = ? OR category = ?
             ORDER BY ID DESC',
            'sss',
            [$email, $groupCategory, 'All']
        );
    }

    /**
     * Update an existing notice.
     */
    public function update(int $id, string $subject, string $detail, string $category): bool
    {
        $affected = $this->db->execute(
            'UPDATE notices SET subject = ?, detail = ?, category = ? WHERE ID = ?',
            'sssi',
            [$subject, $detail, $category, $id]
        );
        return $affected > 0;
    }

    /**
     * Delete a notice by ID.
     */
    public function delete(int $id): bool
    {
        $affected = $this->db->execute(
            'DELETE FROM notices WHERE ID = ?',
            'i',
            [$id]
        );
        return $affected > 0;
    }
}
