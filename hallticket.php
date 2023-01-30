<?php
	
    include 'header.php';
    //include 'data.php';
	//echo "$_SESSION[c_code]";
    /*echo "$_SESSION[stuname]";
    echo "$_SESSION[pr_name]";
    echo "$_SESSION[dep_name]";
    echo "$_SESSION[s_email]";*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hall Ticket</title>
  <link rel="stylesheet" href="style.css">
  <script src=
"https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
    </script>
</head>

<body>
    <?php 
        include 'data.php';

    ?>
	<button id="button">Generate PDF</button>

	<div class="page" id  = "makepdf">

		<div class = "logo-img">
			<img src = "ptu-logo.png" alt = "ptu-logo" class = "logo">
		</div>

		<div class = "border">
			<div class = "box">
				<p class="thicker "> PUDUCHERRY TECHNOLOGICAL UNIVERSITY </p>
				<p style="font-family:Helvetica;font-size:15px;text-align:center;line-height:0.01;"> EXAMINATION WING </p>
				<p style="font-family:Helvetica;font-size:15px;text-align:center;line-height:0.6;"> SEMESTER EXAMINATIONS -- <?php echo "$_SESSION[session]" ?></p>
				
			</div>
		</div>
		<p style="font-family:Arial;font-weight:650;font-size:20px;text-align:center;line-height:1.5;color:darkblue;"> HALL TICKET </p>

		<div>
			<div class="photo">
                <!-- to display the pic of the selected student -->
                <?php
                   $src = "18-BT-IMG\\".$_SESSION['r_no'].".png";
                   echo "<img src=$src alt = 'photo' class = 'stu_photo'>"
                ?>
			</div>
		
			
		</div>
		<br>
		<div class="float_left">
			<ul>
			<li> <b class = "names">STUDENT NAME</b> <t>: <?php echo "$_SESSION[stuname]" ?> </t> </li> <br>
			<li> <b class = "names">REGISTER NO</b> <t>: <?php echo "$_SESSION[r_no]" ?> </t> </li> <br>
			<li> <b class = "names">INSTITUTE</b> <t>: <?php echo "PTU" ?>  </t> </li> <br>
			<li> <b class = "names">PROGRAMME</b> <t>: <?php echo "$_SESSION[dep_name]" ?> </t> </li> <br>
			<li> <b class = "names">DEPARTMENT/SPECIALIZATION</b> <t>: <?php echo "$_SESSION[pr_name]" ?> </t> </li> <br>
			</ul>
		</div>
		<br><br><br>
		<div>
			<?php
				echo "<table>";
					echo "<tr>";
						echo "<th>DATE</th>";
						echo "<th>SESSION</th>";
						echo "<th>SUBJECT CODE</th>";
						echo "<th>SUBJECT NAME</th>";
						echo "<th>COURSE TYPE</th>";
						echo "<th>SEMESTER</th>";
						echo "<th>REG/ARR</th>";
					echo "</tr>";
					$sub = "SELECT e.course_code,course_name,course_type,sem FROM u_external_marks e 
							INNER JOIN u_course c ON e.course_code = c.course_code 
							INNER JOIN u_course_regn co ON e.course_code = co.course_code
							WHERE e.regno = '$_SESSION[r_no]' AND e.session = '$_SESSION[e_session]' AND co.session = '$_SESSION[e_session]'";


					/*$sub = "SELECT c.course_code,course_name,course_type,sem,DATE_FORMAT(ex_date,'%d-%m-%Y'),t.session 
							FROM u_external_marks e INNER JOIN u_course c ON e.course_code = c.course_code 
							INNER JOIN time_table t ON t.course_code = e.course_code 
							INNER JOIN u_course_regn co ON co.course_code = e.course_code
							WHERE e.regno = '$_SESSION[r_no]' 
							AND e.session = '$_SESSION[e_session]' 
							AND t.ex_session = '$_SESSION[e_session]'
							AND co.regno = '$_SESSION[r_no]'";*/
        			$result2 = mysqli_query($conn,$sub);
					//$date = "SELECT DATE_FORMAT(ex_date,'%d-%m-%Y'), t.session FROM time_table t INNER JOIN u_external_marks e ON t.course_code = e.course_code WHERE e.regno = '$_SESSION[r_no]' AND e.session = '$_SESSION[e_session]'";
					//$result3 = mysqli_query($conn,$date);
					//$sem = ' ';
					$exam_type = ' '; 
					$date =' ';
					$session = ' '; 

					$regular = "SELECT e.course_code,course_name,course_type,sem,exam_type,DATE_FORMAT(ex_date,'%d-%m-%Y'),t.session FROM u_external_marks e 
								INNER JOIN u_course_regn co on e.course_code = co.course_code 
								INNER JOIN u_course c ON e.course_code = c.course_code 
								INNER JOIN time_table t ON t.course_code = e.course_code
								where e.session = '23B' and e.regno = '18IT1015' AND e.session <> co.session AND exam_type = 'A' AND ex_session = '$_SESSION[e_session]'";
					$result5 = mysqli_query($conn,$regular);
					//$y = mysqli_fetch_assoc($result5);

					//$time = "SELECT ex_date,t.session,exam_type FROM time_table t INNER JOIN u_external_marks e ON t.course_code = e.course_code";
					//$result3 = mysqli_query($conn,$time);


					//$sem = "SELECT curr_sem FROM u_student WHERE regno = '$_SESSION[r_no]'";
					//$result3 = mysqli_query($conn,$sem);
					//$z = mysqli_fetch_assoc($result3);
				
					while ($row = mysqli_fetch_array($result2))
					{
						//$pass = "SELECT grade FROM u_external_marks WHERE course_code = '$row[course_code]' AND session = '$_SESSION[e_session]'";
						//$result3 = mysqli_query($conn,$pass);
						//$y = mysqli_fetch_assoc($result3);
						$date1 = "SELECT DATE_FORMAT(ex_date,'%d-%m-%Y'),t.session,exam_type FROM time_table t  WHERE t.course_code = '$row[course_code]' AND ex_session = '$_SESSION[e_session]' ";
						$result4 = mysqli_query($conn,$date1);
						$x = mysqli_fetch_assoc($result4);
						if ($x["DATE_FORMAT(ex_date,'%d-%m-%Y')"] == "00-00-0000")
							{
								$x["DATE_FORMAT(ex_date,'%d-%m-%Y')"] = ' ';
							}

						echo "<tr>";
							echo "<td>" .$x["DATE_FORMAT(ex_date,'%d-%m-%Y')"]. "</td>";
							echo "<td>" .$x['session']. "</td>";
							echo "<td>" .$row['course_code']. "</td>";
							echo "<td>" .$row['course_name']. "</td>";
							echo "<td>" .$row['course_type']. "</td>";
							echo "<td>" .$row['sem']. "</td>";
							echo "<td>" .$x['exam_type']. "</td>";
						echo "</tr>";
					/*	echo "<tr>";
							echo "<td>" .$date. "</td>";
							echo "<td>" .$session. "</td>";
							echo "<td>" .$y['course_code']. "</td>";
							echo "<td>" .$y['course_name']. "</td>";
							echo "<td>" .$y['course_type']. "</td>";
							echo "<td>" .$y['sem']. "</td>";
							echo "<td>" .$exam_type. "</td>";
						echo "</tr>";*/
					}
					if (mysqli_num_rows($result5) > 0 )
					{
						while ($y = mysqli_fetch_array($result5))
						{
							echo "<tr>";
									echo "<td>" .$y["DATE_FORMAT(ex_date,'%d-%m-%Y')"]. "</td>";
									echo "<td>" .$y['session']. "</td>";
									echo "<td>" .$y['course_code']. "</td>";
									echo "<td>" .$y['course_name']. "</td>";
									echo "<td>" .$y['course_type']. "</td>";
									echo "<td>" .$y['sem']. "</td>";
									echo "<td>" .$y['exam_type']. "</td>";
							echo "</tr>";
						}
					}
				echo "</table>";
			?>
		
		</div>
				<div class="topleft">
					<div> <img src = "director.png" alt = "director" class = "logo1"> </div>
					<div >Director(Examinations)<br><br>Dated : <?php echo date('d-m-Y') ?></div>

				</div>
		
			<div class="toright">
				<div >Signature of the Student</div>
			</div>
		
	
	</div>
	<script>
        var button = document.getElementById("button");
        var makepdf = document.getElementById("makepdf");
  
        button.addEventListener("click", function () {
            html2pdf().from(makepdf).save();
        });
    </script>


</body>
</html>
