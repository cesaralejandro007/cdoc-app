<?php

namespace App\Models;

use \Firebase\JWT\JWT;
use App\Core\Model;

class Token extends Model {
    
    public function verifyToken($token) {
        $query = "SELECT tokens_login.has AS token FROM usuarios JOIN tokens_login ON usuarios.id = tokens_login.usuario_id AND tokens_login.has = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    public function byToken($token) {
        $token_formateado = '';
        if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $token_formateado = $matches[1];
        }
        $query = "SELECT tokens_login.has AS token FROM usuarios JOIN tokens_login ON usuarios.id = tokens_login.usuario_id AND tokens_login.has = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token_formateado);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    public function deleteToken($token) {
        $token_formateado = '';
        if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $token_formateado = $matches[1];
        }
        $query = "DELETE FROM tokens_login WHERE has = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token_formateado);
        return $stmt->execute(); 
    }
    
}
