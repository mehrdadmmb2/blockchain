<?php

namespace App\Models;

use App\Models\Database; // Ensure correct namespace for Database

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Finds a user by username or email.
     * @param string $identifier Username or email.
     * @return array|false User data if found, false otherwise.
     */
    public function findByIdentifier($identifier)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :identifier OR email = :identifier LIMIT 1");
        $stmt->execute([':identifier' => $identifier]);
        return $stmt->fetch();
    }

    /**
     * Creates a new user.
     * @param string $username
     * @param string $email
     * @param string $password_hash Hashed password.
     * @return int|false The ID of the new user or false on failure.
     */
    public function create($username, $email, $password_hash)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, email, password) VALUES (:username, :email, :password)");
        if ($stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password_hash
        ])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Checks if a username or email already exists.
     * @param string $username
     * @param string $email
     * @return bool True if exists, false otherwise.
     */
    public function exists($username, $email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}