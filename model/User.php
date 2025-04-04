<?php

class User {
    // Properties
    private int $user_id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;
    private string $created_at;

    // Constructor
    public function __construct(int $user_id, string $name, string $email, string $password, string $role = 'user', string $created_at = '') {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->created_at = $created_at ?: date('Y-m-d H:i:s'); // Mặc định là thời gian hiện tại nếu không truyền vào
    }

    // Getters
    public function getUserId(): int {
        return $this->user_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    // Setters
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT); // Hash mật khẩu khi set
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
}

?>
