<?php

    include 'header.php';
    SESSION_START();
    if(isset($_POST['submit'])){
        $registerno = $_POST['regno'];
        $session = $_POST['session'];

        $_SESSION['e_session'] = $session;

        $name = "SELECT sname,email,prgm_name,dept_name FROM u_student s INNER JOIN u_prgm p ON s.prgm_id = p.prgm_id INNER JOIN u_dept d ON d.dept_id = p.dept_id WHERE regno = '$registerno' ";
        $result1 = mysqli_query($conn,$name);
        $x = mysqli_fetch_assoc($result1);
        
        $_SESSION['r_no'] = $registerno;
        $_SESSION['stuname'] = $x['sname'];
        $_SESSION['s_email'] = $x['email'];
        $_SESSION['pr_name'] = $x['prgm_name'];
        $_SESSION['dep_name'] = $x['dept_name'];

        if (str_contains($_SESSION['pr_name'],"Master of Technology"))
        {
            $_SESSION['pr_name'] = substr($_SESSION['pr_name'],23) ;
        }
        if (str_contains($_SESSION['pr_name'],"Master of Science"))
        {
            $_SESSION['pr_name'] = substr($_SESSION['pr_name'],20) ;
        }
        if (str_contains($_SESSION['pr_name'],"Master of Business Administration"))
        {
            $_SESSION['pr_name'] = substr($_SESSION['pr_name'],36) ;
        }


        if (str_contains($session,"A"))
        {
            $session = 'MAR';
        }
        else 
        {
            $session = 'NOV';
        }
        $yr = date("Y");
        $_SESSION['session'] = $session ." ". $yr;
    }

?>  