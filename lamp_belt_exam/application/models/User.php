<?php
class User extends CI_Model {
     public function addUser($newUser)
     {
     	$querystr="INSERT INTO users (name, alias, email, password, dob, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $values = array($newUser['name'], $newUser['alias'], $newUser['email'],$newUser['password'], $newUser['dob']); 
        $this->db->query($querystr,$values);
     }
     public function loginUser($newUser)
     {

     	 $querystr = "SELECT * FROM users WHERE email = ? AND password = ?";
     	 $values = array($newUser['email'],$newUser['password']);
     	 if($this->db->query($querystr, $values)->row_array()== null)
         {
            $this->session->set_userdata('loginError', "This user is not in the database.");
            redirect('/Homepage/SignIn');
            
         }
         else
         {
            return $this->db->query($querystr, $values)->row_array();
         }
     }
     public function getUserInfo($userID)
     {
     	$sqlStr = "SELECT * FROM users WHERE users.id = ?";
        $values = $userID;
        return $this->db->query($sqlStr,$values)->row_array();
     }
     public function getAllUsers()
     {
     	$querystr = "SELECT * FROM users";
     	return $this->db->query($querystr)->result_array();
     }
     public function getUserByID($userID) {
            $sqlStr = "SELECT * FROM users WHERE id = ?";
            return $this->db->query($sqlStr, $userID)->row_array();
     }
     public function deleteUser($userID)
     {
     	$sqlStr = "DELETE FROM users WHERE id = ?";
     	return $this->db->query($sqlStr, $userID);
     }
     public function getAllFriends($userID)
     {
        $sqlStr = "SELECT users.id, users.name, users.alias, users.email FROM users LEFT JOIN friendships ON users.id = friendships.user_id1 OR users.id = friendships.user_id2 WHERE (friendships.user_id1 = ? OR friendships.user_id2 = ?) AND users.id != ?";
        $values = array($userID, $userID, $userID);
        return $this->db->query($sqlStr, $values)->result_array();

     }
    public function getAllNonFriends($userID)
     {
        $sqlStr = "SELECT DISTINCT users.id, users.name, users.alias, users.email, users.dob FROM users LEFT JOIN friendships ON users.id = friendships.user_id1 OR users.id = friendships.user_id2 WHERE users.id NOT IN (SELECT user_id1 FROM friendships WHERE friendships.user_id2 = ? OR friendships.user_id1 = ?) AND users.id NOT IN (SELECT user_id2 FROM friendships WHERE friendships.user_id1 = ? OR friendships.user_id2 = ?) AND users.id !=?";
        $values = array($userID, $userID, $userID, $userID, $userID);
        return $this->db->query($sqlStr, $values)->result_array();

     }
     public function insertFriend($friendID)
     {
        $sqlStr = "INSERT INTO friendships (user_id1, user_id2) VALUES (?, ?)";
        $values = array($this->session->userdata['currentUser']['id'], $friendID);
        $this->db->query($sqlStr, $values);
     }
     public function deleteFriend($userID, $friendID)
     {
        $sqlStr = "DELETE FROM friendships WHERE (friendships.user_id1 = ? AND friendships.user_id2 = ?) OR (friendships.user_id1 = ? AND friendships.user_id2 = ?)";
        $values = array($userID, $friendID, $friendID, $userID);
        return $this->db->query($sqlStr, $values);
     }
}
?>