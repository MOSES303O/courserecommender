<?php
class dbclass{
    public $host;
    public $username;
    public $password;
    public $database;
    public $connection;
    private $sess;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->password = $password;
        $this->username = $username;
        $this->database = $database;

        // Establish the database connection
        $this->connection = mysqli_connect($host, $username, $password, $database);

        // Check if the connection was successful
        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    public function getConnection() { 
        echo 'very nice';
        return $this->connection;
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
    private function session(){

        return rand(time(), 100000000);
    }
    public function validatelogin($email,$passs){    
        //WORKING    
        $emel = mysqli_real_escape_string($this->connection, $email);
        $pass = mysqli_real_escape_string($this->connection, $passs);
        if(!empty($emel) && !empty($pass)){
        $sql = mysqli_query($this->connection, "SELECT * FROM user WHERE email = '{$emel}'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($pass);
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                header("Location:../congratulations.php");
                $_SESSION['id'] = $row['session'];
            }else{
                echo "email or Password is Incorrect!";
            }
        }else{
            echo "$email - This phone does not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
    }
    public function signup($name,$email,$password){
       $jina = mysqli_real_escape_string($this->connection, $name);
       $emaili = mysqli_real_escape_string($this->connection, $email);
        $pasi= mysqli_real_escape_string($this->connection, $password);
        $sess=$this->session();
        $sql=mysqli_query($this->connection,"INSERT INTO user values('{$jina}','{$emaili}','{$pasi}',{$sess})");
        if ($sql) {            
            if(mysqli_num_rows(mysqli_query($this->connection,"SELECT*FROM user WHERE email='{$emaili}'"))>0){            
                $rest=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM users WHERE email='{$emaili}'"));
                if($rest){
                session_start();
                $_SESSION['session'] = $rest['session']; 
                }               
            }            
            header('Location: congratulations.php');
                exit();      
            
        } else {
            header('Location:signup.php');
            exit();
        }
        //mysqli_close($this->connection);
        

    }
     public function userchoice($id,$coursecodee){
        $me=mysqli_fetch_assoc(mysqli_query($this->connection,"select*from user where session='{$id}'"));
        $jina=$me['name'];
        $mail=$me['email'];

        $choice=mysqli_fetch_assoc(mysqli_query($this->connection,"insert into selection value('{$img}','{$jina}','{$mail}')"));

        $table=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT COUNT(*) FROM information_schema.tables
        WHERE table_schema = 'customermatch'
        AND table_name = '{$id}'"));
        if($table==0){
            mysqli_query($this->connection,"CREATE TABLE '{$id}'(coursecode)");
            $result =mysqli_query($this->connection,"insert into '{$id}' values('{$coursecodee}')");
            return $result;
        }else{
            // echo "Table already exists.";
            $result =mysqli_query($this->connection,"insert into '{$id}' values('{$coursecodee}')");
            return $result;  
        }
    }
    public function getRandomCourses(){
        $courses=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM coursedescription"));
        return $courses;
    }
    private function gradevalue($grade){
        switch($grade){
             case 'A': 
                return 12;
             case 'A-': 
                return 11;
             case 'B+': 
                return 10;
             case 'B': 
                return 9;
             case 'B-': 
                return 8;
             case 'C+': 
                return 7;
             case 'C': 
                return 6;
             case 'C-': 
                return 5;
             case 'D+': 
                return 4;
             case 'D': 
                return 3;
             case 'D-': 
                return 2;
            default:
                return 1;
    
            }
        }
        private function getreqdb($coursecode){
            $result = mysqli_fetch_assoc(mysqli_query($this->connection, "SELECT clusterpoints from coursedescription WHERE code='{$coursecode}'"));

            // Check if the result exists
            if ($result !== null) {
                return $result;
            } else {
                return []; // Return an empty array if the result does not exist
            }
        }
        private function compareGrades($userGrades, $coursecode) {
            // Get the grades from the database
            $dbGrades = $this->getreqdb($coursecode);
        
            // Check if all subjects from the database are present in the user's grades array
            $dbSubjects = array_keys($dbGrades);
            $userSubjects = array_map(function ($userGrade) {
                preg_match('/([^=]+)=>([^,]+)/', $userGrade, $matches);
                return trim($matches[1]);
            }, $userGrades);
        
            $missingSubjects = array_diff($dbSubjects, $userSubjects);
            if (!empty($missingSubjects)) {
                echo "Subjects not found in user's grades: " . implode(", ", $missingSubjects) . ".\n";
                return false;
            }
        
            // Compare the grades
            foreach ($userGrades as $userGrade) {
                preg_match('/([^=]+)=>([^,]+)/', $userGrade, $matches);
                $userSubject = trim($matches[1]);
                $userGradeValue = $this->gradevalue(trim($matches[2])); // Convert letter grade to numerical value
        
                // Check if the user has a higher or equal grade for each subject
                if ($userGradeValue < $dbGrades[$userSubject]) {
                    echo "User has a lower grade for $userSubject.\n";
                    return false;
                }
            }
        
            // If all comparisons passed, return true
            return true;
        }
        public function selectionChoice($coursecode,$id) {
            $rest=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM users WHERE ID='{$id}'"));
            $cos=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM coursedescription WHERE code='{$coursecode}'"));
            $jina=$cos['name'];
            $picha=$cos['image'];
            $email=$rest['email'];
            mysqli_query($this->connection,"INSERT INTO selection values('{$picha}','{$jina}','{$email}')");
        }
        public function selectedcourses($id){
            $rest=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM users WHERE ID='{$id}'"));
            $email=$rest['email'];
            $courses=mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM selection WHERE email='{$email}'"));
            return $courses;
        }
        public function  getCourseDetails() {
            return mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM coursedescription"));
        }
        public function search($input){
           return  mysqli_fetch_assoc(mysqli_query($this->connection,"SELECT*FROM coursedescription WHERE  courses LIKE '%$input%' OR Description LIKE '%$input%'"));
        }
}

?>