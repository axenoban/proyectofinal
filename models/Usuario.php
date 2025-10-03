<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }
    
    public function login($username, $password) {
        $this->ensureDefaultAdmin();

        $sql = "SELECT * FROM usuarios WHERE LOWER(username) = LOWER(:username) AND estado = 'activo'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $storedPassword = $user['password'] ?? '';
        $passwordInfo = password_get_info($storedPassword);

        // Caso 1: la contraseña está hasheada con password_hash
        if ($passwordInfo['algo'] !== 0) {
            if (password_verify($password, $storedPassword)) {
                if (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                    $this->rehashPassword((int) $user['id'], $password);
                }
                $this->updateLastLogin((int) $user['id']);
                return $this->getUserWithPassword((int) $user['id']);
            }
        } else {
            // Caso 2: la contraseña está almacenada en texto plano o con algoritmos legados
            if (hash_equals($storedPassword, $password)) {
                if ($this->rehashPassword((int) $user['id'], $password)) {
                    $user = $this->getUserWithPassword((int) $user['id']);
                }
                $this->updateLastLogin((int) $user['id']);
                return $user;
            }

            $lowerStoredPassword = strtolower($storedPassword);
            if (strlen($lowerStoredPassword) === 32 && ctype_xdigit($lowerStoredPassword) && hash_equals($lowerStoredPassword, md5($password))) {
                if ($this->rehashPassword((int) $user['id'], $password)) {
                    $user = $this->getUserWithPassword((int) $user['id']);
                }
                $this->updateLastLogin((int) $user['id']);
                return $user;
            }

            if (strlen($lowerStoredPassword) === 40 && ctype_xdigit($lowerStoredPassword) && hash_equals($lowerStoredPassword, sha1($password))) {
                if ($this->rehashPassword((int) $user['id'], $password)) {
                    $user = $this->getUserWithPassword((int) $user['id']);
                }
                $this->updateLastLogin((int) $user['id']);
                return $user;
            }
        }

        return false;
    }

    private function updateLastLogin(int $id): void {
        $stmt = $this->conn->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    private function rehashPassword(int $id, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'password' => $hash
        ]);
    }

    private function getUserWithPassword(int $id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function ensureDefaultAdmin(): void {
        try {
            $stmt = $this->conn->query('SELECT COUNT(*) FROM usuarios');
            $count = (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw $e;
        }

        if ($count > 0) {
            return;
        }

        $defaultPassword = password_hash('1234', PASSWORD_DEFAULT);
        $seed = $this->conn->prepare("INSERT INTO usuarios (username, password, nombre, rol, estado) VALUES (:username, :password, :nombre, 'admin', 'activo')");
        $seed->execute([
            'username' => 'admin@gmail.com',
            'password' => $defaultPassword,
            'nombre' => 'Administrador'
        ]);
    }

    // Verifica si username existe (para crear)
    public function existsUsername($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM usuarios WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() !== false;
    }

    // Verifica si username existe para otro id (para editar)
    public function existsUsernameExceptId($username, $id) {
        $stmt = $this->conn->prepare("SELECT 1 FROM usuarios WHERE username = :username AND id != :id LIMIT 1");
        $stmt->execute(['username' => $username, 'id' => $id]);
        return $stmt->fetchColumn() !== false;
    }

    // Crear usuario
    public function create($username, $password, $nombre, $rol, $estado = 'activo') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (username, password, nombre, rol, estado) VALUES (:username, :password, :nombre, :rol, :estado)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hash,
            'nombre' => $nombre,
            'rol' => $rol,
            'estado' => $estado
        ]);
    }

    // Obtener todos los usuarios
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, username, nombre, rol, estado FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, nombre, rol, estado FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario (sin cambiar contraseña)
    public function update($id, $username, $nombre, $rol, $estado) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET username = :username, nombre = :nombre, rol = :rol, estado = :estado WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'username' => $username,
            'nombre' => $nombre,
            'rol' => $rol,
            'estado' => $estado
        ]);
    }

    // Actualizar contraseña
    public function updatePassword($id, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'password' => $hash
        ]);
    }

    // Eliminar usuario
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
