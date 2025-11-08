<?php

/**
 * 
 */
class User{

private $db;

	public function __construct(){
		$this->db = new Database;
	}


public function addUserAdmin($data){
	 // prepare Query	
	$this->db->query('INSERT INTO user(email,FullName, organization, status, password,background_width,background_height,XWidth,YHeight,AvatarOutputX,AvatarOutputY,zoom,theme) VALUES(:email, :fullname, :organization, :admin, :password,:background_width, :background_height, :XWidth, :YHeight, :AvatarOutputX, :AvatarOutputY, :zoom, :theme)');
	// Bind Values	
	$this->db->bind(':email',$data['email']);	
	$this->db->bind(':fullname',$data['FullName']);	
	$this->db->bind(':organization',$data['organization']);	
	$this->db->bind(':admin',$data['admin']);	
	$this->db->bind(':password',$data['password']);	
	$this->db->bind(':background_width',"110");	
	$this->db->bind(':background_height',"113");	
	$this->db->bind(':XWidth',"33");	
	$this->db->bind(':YHeight',"135");	
	$this->db->bind(':AvatarOutputX',"170");	
	$this->db->bind(':AvatarOutputY',"1");	
	$this->db->bind(':zoom',"210");	
	$this->db->bind(':theme',"white");	
// Execute	
if ($this->db->execute()){
		return true;
	}else{
		return false;
	}	
}
    
public function addUser($data){
	 // prepare Query	
	$this->db->query('INSERT INTO user(email,FullName, organization,background_image,password,background_width,background_height,XWidth,YHeight,AvatarOutputX,AvatarOutputY,zoom,theme) VALUES(:email, :fullname, :organization, :background_image, :password, :background_width, :background_height, :XWidth, :YHeight, :AvatarOutputX, :AvatarOutputY, :zoom, :theme)');
	// Bind Values	
	$this->db->bind(':email',$data['email']);	
	$this->db->bind(':fullname',$data['FullName']);	
	$this->db->bind(':organization',$data['organization']);	
	$this->db->bind(':background_image',$data['background_image']);	
	$this->db->bind(':password',$data['password']);	
	$this->db->bind(':background_width',$data['background_width']);	
	$this->db->bind(':background_height',$data['background_height']);	
	$this->db->bind(':XWidth',$data['XWidth']);	
	$this->db->bind(':YHeight',$data['YHeight']);	
	$this->db->bind(':AvatarOutputX',$data['AvatarOutputX']);	
	$this->db->bind(':AvatarOutputY',$data['AvatarOutputY']);	
	$this->db->bind(':zoom',$data['zoom']);	
	$this->db->bind(':theme',$data['theme']);	
// Execute	
if ($this->db->execute()){
		return true;
	}else{
		return false;
	}	
}    
    
public function countUsers($email){

	$this->db->query('SELECT * FROM user WHERE email = :email ');
	$this->db->bind(':email', $email);	

	$result = $this->db->rowCount();
	return $result;	
}
    
public function getForget_password($token){
	 // prepare Query	
	$this->db->query('SELECT email FROM forgot_password WHERE token = :token');
	// Bind Values	
	$this->db->bind(':token',$token);
	$result = $this->db->resultset();	
	
	return $result;				
	
}    

public function countorganization($organization){

	$this->db->query('SELECT * FROM user WHERE organization = :organization ');
	$this->db->bind(':organization', $organization);	

	$result = $this->db->rowCount();
	return $result;	
}
    
    
public function Getusers($organization,$limit = null){


		$this->db->query("SELECT * FROM user WHERE organization = :organization AND status != 1 LIMIT " . $limit);
		$this->db->bind(':organization',$organization);	

		$result = $this->db->resultset();	
		return $result;	


	}  
    
public function Getuser($email,$storedPassword){

	$this->db->query('SELECT * FROM user WHERE email = :email AND password = :storedPassword');
	$this->db->bind(':email', $email);
	$this->db->bind(':storedPassword', $storedPassword);	

	$result = $this->db->resultset();	
	return $result;	
}
    
public function GetOrganization($organization){

	$this->db->query('SELECT * FROM user WHERE organization = :organization');
	$this->db->bind(':organization', $organization);

	$result = $this->db->resultset();	
	return $result;	
}    
    
public function storedPassword($email){


	$this->db->query('SELECT * FROM user WHERE email = :email ');
	$this->db->bind(':email', $email);	

	$result = $this->db->resultset();	
	return $result;	
} 
    
 public function updatepassword($password,$mail){

	$this->db->query('UPDATE user SET password = :password WHERE email = :mail ');
	$this->db->bind(':password', $password);	
	$this->db->bind(':mail', $mail);	
if($this->db->execute()){
		return true;
	}else{
		return false;
	}
}

    
public function removeforgottentoken($token){
	 // prepare Query	
	$this->db->query('DELETE FROM forgot_password WHERE token = :token');
	// Bind Values	
	$this->db->bind(':token',$token);		
// Execute	
if($this->db->execute()){
		return true;
	}else{
		return false;
	}	
}

    public function CountForget_password($token){
	 // prepare Query	
	$this->db->query('SELECT email FROM forgot_password WHERE token = :token');
	// Bind Values	
	$this->db->bind(':token',$token);
	$result = $this->db->rowCount();
	
	return $result;				
	
}
    
public function forgot_password($email, $token){
	 // prepare Query	
	$this->db->query('INSERT INTO forgot_password(email,token) VALUES(:email, :token)');
	// Bind Values	
	$this->db->bind(':email',$email);	
	$this->db->bind(':token',$token);	
// Execute	
if($this->db->execute()){
		return true;
	}else{
		return false;
	}	
}


public function redirect($location){
    
     header("Location: $location ");
 }    

}