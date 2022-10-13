<?php
// library built at Averise Web Solutions... 08186870849 or 09072219905

// Error code definations for clases 
// 360 :: Result not found
// 100 - 190 :: account / sign / user related errors
	// 104 | password must be above 4 Characters
	// 105 | passwords do not match
	// 106 | Invalid Login Credentials
	// 107 | username already in use
	// 108 | phone number already in use
	// 109 | email already in use
	// 110 | User not found
	// 111 | File Upload Error!
	// 112 | Sizes too Big
	// 113 | Temporal upload Error!
	// 114 | Not allowed file type!

// function clases

include 'dbcon.php';
 ###########################################################################
// Database related
class getDbData extends dataBase{
	
	// multiple rows collection
	function multiple($sql){
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			while($rows = $query->fetch_assoc()){
				$rowdata[] = $rows;
			}
			return $rowdata;
		} else {
			return '360';
		}
	}

	// single data collection

	function single($sql){
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$data = $query->fetch_assoc();
			return $data;
		} else {
			return '360';
		}
	}

	// Query database
	function dbQuery($sql){
		if($this->connect()->query($sql)){
			return '1';
		} else {
			return '2';
		}
	}
	function plainQuery($sql){
		return $this->connect()->query($sql);
	}

	// Query result count
	function queryCount($sql){
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		return $count;
	}

	// Query result Fetch
	function queryFetch($sql){
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$result = $query->fetch_assoc();
			return $result;
		} else {
			return '360';
		}
	}

	// File uploads

	public function fileUpload($file){

		$file = $file;
    
	    $imgname = $file['name'];
	    $imgtype = $file['type'];
	    $imgtmpname = $file['tmp_name'];
	    $imgerror = $file['error'];
	    $imgsize = $file['size'];
	    $imgext = explode('.', $imgname);
	    $imgactext = strtolower(end($imgext));
	    
	    $allowedext = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'wmv','avi', 'mp3', '3gp', 'wav', 'm4a');

	    if (in_array( $imgactext, $allowedext)) {

	    	if($imgactext == 'jpg' || $imgactext == 'jpeg' || $imgactext == 'gif' || $imgactext == 'png'){
	    		$filetype = 'image';
	    	} elseif($imgactext == 'mp4' || $imgactext == 'wmv' || $imgactext == 'avi') {
	    		$filetype = 'video';
	    	} else {
	    		$filetype = 'audio';
	    	}

            if($imgerror == 0){

                if($imgsize < 20000000){
                    
                    $imgfullname = uniqid("bigvibes-mag-".$filetype.'-', false) .'.'.$imgactext;
                    $imgdest = '../../images/uploads/' .$imgfullname;

                    if(move_uploaded_file($imgtmpname, $imgdest)) {

                    	return $imgfullname. ' | '.$filetype;

                    } else {
                    	return '111';
                    }

                } else {
                	return '112';
                } 

            }else{
                return '113';
            }

        } else {
        	return '114';
        }
    }

	// File upload replacement
	public function replaceUpload($file, $getFilename){

		$file = $file;
    
	    $imgname = $file['name'];
	    $imgtype = $file['type'];
	    $imgtmpname = $file['tmp_name'];
	    $imgerror = $file['error'];
	    $imgsize = $file['size'];
	    $imgext = explode('.', $imgname);
	    $imgactext = strtolower(end($imgext));
	    
	    $allowedext = array('jpg', 'jpeg', 'png', 'gif');

	    if (in_array( $imgactext, $allowedext)) {

	    	// if($imgactext == 'jpg' || $imgactext == 'jpeg' || $imgactext == 'gif' || $imgactext == 'png'){
	    	// 	$filetype = 'image';
	    	// } else {
	    	// 	$filetype = 'video';
	    	// }

            if($imgerror == 0){

                if($imgsize < 20000000){
                    
                    $imgfullname = $getFilename;
                    $imgdest = '../../images/uploads/' .$imgfullname;

                    if(move_uploaded_file($imgtmpname, $imgdest)) {

                    	return $imgfullname. ' | '.$filetype;

                    } else {
                    	return '111';
                    }

                } else {
                	return '112';
                } 

            }else{
                return '113';
            }

        } else {
        	return '114';
        }
    }


}

#########################################################################################################
// account handeling == passwords, usersnames, login and signup
class accountHandle extends dataBase {

	// making password
	function makePassword($pwd, $repwd){
		// confirming passwords
		if($pwd === $repwd){
			// checking is the password is upto 4 characters
			if(strlen($pwd) > 4){
				$hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
				return $hashPwd;
			} else {
				return "104"; // password must be above 4 characters
			}
		} else {
			return "105"; // passwords do not  match
		}
	}

	// verufy password
	function verifyPassword($inputPwd, $dbPwd){
		if(password_verify($inputPwd, $dbPwd)){
			return 'ok';
		} else {
			return '106';
		}
	}

	// Create new user
	function checkUser($email, $phone){
		// checking email availability
		$sql = "SELECT * from users where user_email = '$email'; ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count < 1){

			// checking phone availability
			$sql = "SELECT * from users where user_phone = '$phone'; ";
			$query = $this->connect()->query($sql);
			$count = $query->num_rows;
			if($count < 1){

				return 'ok';
				
			} else {
				return '108';
			}

		} else {
			return '109';
		}
	}

	// Verify user
	function verifyUser($userId){
		$sql = "SELECT * from users where user_email = '$userId' or user_phone = '$userId'; ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$userRow = $query->fetch_assoc();
			return $userRow;
		} else {
			return '110';
		}
	}

	
}


####################################################################################
// getting post data
class postData extends dataBase{

	// All post data
	function getPostData($postCode){
		$sql = "SELECT * from skha_posts where post_code = '$postCode' ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$userInfo = $query->fetch_assoc();
			return $postInfo;
		} else {
			return '306';
		}
	}

	// All comments
	function getPostComments($postCode){
		$sql = "SELECT * from avr_comments where com_item = '$postCode' ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$userInfo = $query->fetch_assoc();
			return $postInfo;
		} else {
			return '306';
		}
	}

	// All comments Count
	function getPostCommentCount($postCode){
		$sql = "SELECT * FROM `avr_comments` WHERE `com_item` = '$postCode'; ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		return $count;
	}


	// All comments Count
	function getPostLikesCount($postCode){
		$sql = "SELECT * FROM `post_likes` WHERE `like_item` = '$postCode'; ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		return $count;
	}
}

####################################################################################
// getting user information

class userData extends dataBase{

	function getUserData($userCode){
		$sql = "SELECT * from users where user_code = '$userCode'; ";
		$query = $this->connect()->query($sql);
		$count = $query->num_rows;
		if($count > 0){
			$userInfo = $query->fetch_assoc();
			return $userInfo;
		} else {
			return '306';
		}
	}

	// getting user fullname 
	function fullName($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_fullname'];
		} else {
			return $data;
		}
	}

	// getting user email 
	function email($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_email'];
		} else {
			return $data;
		}
	}

	// getting user phone 
	function phone($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_phone'];
		} else {
			return $data;
		}
	}

	// getting user phone 
	function pass($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_pass'];
		} else {
			return $data;
		}
	}

	// getting user fullname 
	function joinDate($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_joindate'];
		} else {
			return $data;
		}
	}

	// getting user type 
	function userType($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_type'];
		} else {
			return $data;
		}
	}
	// getting user type 
	function useraccount($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_bal'];
		} else {
			return $data;
		}
	}

	// getting user type 
	function userImage($userCode){
		$data = $this->getUserData($userCode);
		if($data != '306'){
			return $data['user_image'];
		} else {
			return $data;
		}
	}

}

#####################################################################################

// $w = new accountHandle;
// print_r($w->verifyUser("jaiks"));