<?php
require_once '../config.php';
require_once '../model/user.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController {
    
    /**
     * Fetch all users from the database.
     */
    public function getUser() {
        $conn = config::getConnexion();
        $sql = 'SELECT * FROM user';
        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while fetching users. Please try again later.");
        }
    }

    /**
     * Check if a user exists by email.
     */
    public function doesUserExist($email) {
        $conn = config::getConnexion();
        $sql = "SELECT COUNT(*) FROM user WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([ ':email' => $email ]);
            $result = $query->fetchColumn();
            return $result > 0; // If count > 0, the email exists
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while checking if the user exists. Please try again later.");
        }
    }    

    /**
     * Add a new user to the database.
     */
    public function addUser($user) { 
        $conn = config::getConnexion();
        $checkSql = "SELECT COUNT(*) FROM user WHERE LOWER(email) = LOWER(:email) OR LOWER(name) = LOWER(:name)";
        try {
            $query = $conn->prepare($checkSql);
            $query->execute([
                ':email' => $user->getEmail(),
                ':name' => $user->getName()
            ]);
            if ($query->fetchColumn() > 0) {
                return false; // User exists
            }

            $sql = "INSERT INTO user (name, email, password, adresse, avatar) VALUES (:name, :email, :password, :adress, :avatar)";
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $query = $conn->prepare($sql);
            $query->execute([
                ':name' => $user->getName(),
                ':email' => $user->getEmail(),
                ':password' => $hashedPassword,
                ':adress' => $user->getAdress(),
                ':avatar' => 'default-avatar.png' // Default avatar
            ]);
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while adding the user. Please try again later.");
        }
    }

    /**
     * Delete a user by ID.
     */
    public function deleteUser($id) { 
        $conn = config::getConnexion();
        $sql = 'DELETE FROM user WHERE id = :id';
        try {
            $query = $conn->prepare($sql);
            $query->execute([ ':id' => $id ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while deleting the user. Please try again later.");
        }
    }

    /**
     * Update user information by ID.
     */
    public function updateUser($id, $user) {
        $conn = config::getConnexion();
        $sql = "UPDATE user SET name = :name, email = :email, password = :password, adresse = :adress, role = :role WHERE id = :id";
        try {
            $password = $user->getPassword() ? password_hash($user->getPassword(), PASSWORD_DEFAULT) : null;
            $query = $conn->prepare($sql);
            $query->execute([ 
                ':id' => $id,
                ':name' => $user->getName(),
                ':email' => $user->getEmail(),
                ':password' => $password,
                ':adress' => $user->getAdress(),
                ':role' => $user->getRole()
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while updating the user. Please try again later.");
        }
    }

    /**
     * Get user details by ID.
     */
    public function getUserById($id) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM user WHERE id = :id"; 
        try {
            $query = $conn->prepare($sql);
            $query->execute([ ':id' => $id ]);
            return $query->fetch();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while fetching the user by ID. Please try again later.");
        }
    }

    /**
     * Login a user by validating email and password.
     */
    public function loginUser($email, $password) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM user WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([ ':email' => $email ]);
            $user = $query->fetch();

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while logging in. Please try again later.");
        }
    }

    /**
     * Generate a password reset token for the user.
     */
    public function generateResetToken($email) {
        $conn = config::getConnexion();
        $sql = "SELECT id FROM user WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            $userId = $query->fetchColumn();
            if ($userId) {
                $token = bin2hex(random_bytes(16));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $tokenSql = "INSERT INTO password_resets (user_id, token, expiry) VALUES (:user_id, :token, :expiry)";
                $query = $conn->prepare($tokenSql);
                $query->execute([
                    ':user_id' => $userId,
                    ':token' => $token,
                    ':expiry' => $expiry
                ]);

                return $token;
            }
            throw new Exception("Email not registered.");
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while generating the reset token. Please try again later.");
        }
    }

    /**
     * Set a verification code for a user.
     */
    public function setVerificationCode($email, $verificationCode) {
        $conn = config::getConnexion();
        $sql = "UPDATE user SET verification_code = :code, verification_status = 0 WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':code' => $verificationCode,
                ':email' => $email
            ]);
            return $query->rowCount() > 0; // Return true if the email exists and code is updated
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while setting the verification code. Please try again later.");
        }
    }

    /**
     * Validate the verification code entered by the user.
     */
    public function validateVerificationCode($email, $code) {
        $conn = config::getConnexion();
        $sql = "SELECT verification_code FROM user WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            $storedCode = $query->fetchColumn();

            if ($storedCode && $storedCode == $code) {
                // Optionally update verification status
                $updateSql = "UPDATE user SET verification_status = 1 WHERE LOWER(email) = LOWER(:email)";
                $updateQuery = $conn->prepare($updateSql);
                $updateQuery->execute([':email' => $email]);
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while validating the verification code. Please try again later.");
        }
    }

    /**
     * Update a user's password.
     */
    public function updatePassword($email, $newPasswordHash) {
        $conn = config::getConnexion();
        $sql = "UPDATE user SET password = :password WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':password' => $newPasswordHash,
                ':email' => $email
            ]);
            return $query->rowCount() > 0; // Return true if the password was updated
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while updating the password. Please try again later.");
        }
    }

    /**
     * Get user by email.
     */
    public function getUserByEmail($email) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM user WHERE LOWER(email) = LOWER(:email)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([ ':email' => $email ]);
            return $query->fetch();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while fetching the user by email. Please try again later.");
        }
    }

    /**
     * Register a pending user.
     */
    public function registerUser($pendingUser) {
        $conn = config::getConnexion();
        
        // Check if the email or name already exists in the database
        $checkSql = "SELECT COUNT(*) FROM user WHERE LOWER(email) = LOWER(:email) OR LOWER(name) = LOWER(:name)";
        try {
            $query = $conn->prepare($checkSql);
            $query->execute([
                ':email' => $pendingUser->getEmail(),
                ':name' => $pendingUser->getName()
            ]);
            
            if ($query->fetchColumn() > 0) {
                return false; // User exists
            }

            // Insert the pending user into the user table with verification status as 0 (pending)
            $sql = "INSERT INTO user (name, email, password, adresse, avatar, verification_status) 
                    VALUES (:name, :email, :password, :adress, :avatar, :verification_status)";
            
            // Hash the password
            $hashedPassword = password_hash($pendingUser->getPassword(), PASSWORD_DEFAULT);
            
            // Prepare the query and execute
            $query = $conn->prepare($sql);
            $query->execute([
                ':name' => $pendingUser->getName(),
                ':email' => $pendingUser->getEmail(),
                ':password' => $hashedPassword,
                ':adress' => $pendingUser->getAdress(),
                ':avatar' => 'default-avatar.png',  // Default avatar
                ':verification_status' => 0  // Set verification status to '0' (pending)
            ]);
            
            return true; // User registered successfully (pending)
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception("An error occurred while registering the user. Please try again later.");
        }
    }
}
?>
