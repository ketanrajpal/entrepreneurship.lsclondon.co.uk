<?php
ob_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$allfiles = array();
	$filename = array();
	if(count($_FILES['upload']['name']) > 0){
		for($i=0; $i<count($_FILES['upload']['name']); $i++) {
			$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
			if($tmpFilePath != ""){
				$shortname = $_FILES['upload']['name'][$i];
                $filePath = "../uploads/" .$_POST["first_name"]." ".$_POST["last_name"].'-'.MD5(date("Y-m-d H:i:s").$_POST["email"]).'-'.$_FILES['upload']['name'][$i];
				array_push($allfiles, $filePath);
				array_push($filename,$_FILES['upload']['name'][$i]);
                if(move_uploaded_file($tmpFilePath, $filePath)) {
                    $files[] = $shortname;
                }
             }
        }
	}
	$htmlfile='../entries/'.$_POST["first_name"]." ".$_POST["last_name"].'-'.MD5($_POST["date"].$_POST["email"].date("Y-m-d H:i:s")).'.html';
	$file = fopen($htmlfile,'w');
	$cvsData="<h1>Entry for LSC Entrepreneurship Awards</h1><p style='font-family:Arial;font-size:14px;line-height:150%;'>Full Name: <b>".$_POST["first_name"]." ".$_POST["last_name"];
	$cvsData.="</b><br>Email: <b>".$_POST["email"];
	$cvsData.="</b><br>Phone: <b>".$_POST["phone"];
	$cvsData.="</b><br>Date of Birth: <b>".$_POST["date"];
	$cvsData.="</b><br>Gender: <b>".$_POST["gender"];
	$cvsData.="</b><br>Course Studied: <b>".$_POST["course_studied"];
	$cvsData.="</b><br>Year of Graduation: <b>".$_POST["year_graduation"];
	$cvsData.="</b><br>Nationality: <b>".$_POST["nationality"];
	$cvsData.="</b><br>Campus: <b>".$_POST["campus"]."</b><br><br><b>Uploads</b>";
	$i=1;
	$j=0;
	foreach($allfiles as $myfile){
		$cvsData.="<br>File ".$i.": <a href='http://lsclondon.co.uk/entrepreneurship".substr($myfile,2)."'>".$filename[$j]."</a>";
		$i++;
		$j++;
	}
	$cvsData.="</b><br>Business Plan: <b>".$_POST["business_plan"];
	$cvsData.="</b><br>Date and Time: <b>".date("Y-m-d H:i:s");
	$cvsData.="</b><br>IP Address: <b>".$_POST["last_login_ip"]."</b></p>";
	fwrite($file, $cvsData);
	fclose($file);
	$to="ketan.rajpal@lsclondon.co.uk";
	$subject = $_POST["first_name"]." ".$_POST["last_name"]."'s Entry for LSC Entrepreneurship Awards";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <no-reply@lsclondon.co.uk>' . "\r\n";
	mail("ketan.rajpal@lsclondon.co.uk",$subject,$cvsData,$headers);
	//mail("helenalim_mall@me.com",$subject,$cvsData,$headers);
	mail("guru.srinivasan@lsclondon.co.uk",$subject,$cvsData,$headers);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Submit your Entry &bull; LSC Entrepreneurship Awards</title>
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery.fileupload.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
.error {
	color: #F00;
	font-size: 13px;
}
#loader {
	position: fixed;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	z-index: 99999;
	background-color: #FFF;
	display:none;
}
#loader img{
	width:146px;
	margin:auto;
	display:block;
	margin-top:50px;
}
.submit_entry{
	background-color: #e30513;
	padding:15px 30px;
	font-size:20px;
	display:inline-block;
	margin-top:20px;
	text-transform:uppercase;
	border-radius:4px;
	color:#fff;
}
</style>
</head>
<body>
<div id="loader"> <img src="../img/loader.gif">
  <h2 style="text-align:center;">Thankyou for Submitting your entry for LSC Entrepreneurship Awards 2016</h2>
  <p style="text-align:center;">Please Wait while we submit your entry. Please do not refresh or close the page.</p>
</div>
<div class="container">
  <header>
  <?php if($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
    <h1>Thankyou for Submitting your entry for LSC Entrepreneurship Awards 2016</h1>
  <?php }else{ ?>
    <h1>Submit your Entry</h1>
  <?php } ?>
    <p class="flow-text">The 2016 LSC Entrepreneurship Awards have been developed to give aspiring LSC entrepreneurs, business owners and social entrepreneurs the opportunity to transform their ideas into reality.<br>
      <br>
      If have always wanted to embark on your own business or social enterprise venture, this is your chance to turn your ideas into commercially viable technologies, products or services. If you believe you have the entrepreneurial aptitude, commercial acumen, vision, ambition and drive to build a successful enterprise, this is the perfect opportunity to make your dream materialise into a reality.<br>
      <br>
      <?php if($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
      <strong>You can also email your business plan and creative to <a href="mailto:entrepreneurship@lsclondon.co.uk">entrepreneurship@lsclondon.co.uk</a></strong>
      <center><a href="../" class="submit_entry">Go back to LSC Entrepreneurship Awards 2016 Website</a></center><br><br>
      <?php } else { ?>
      <strong>Submit your business plan and creative below or Email the entries at <a href="mailto:entrepreneurship@lsclondon.co.uk">entrepreneurship@lsclondon.co.uk</a></strong>
      <?php } ?>
      
      </p>
  </header>
  <?php if($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
  <?php } else { ?>
  
  
  <section class="row">
    <form class="col s12" id="main-form" name="main-form" enctype="multipart/form-data" method="post" onSubmit="return exit_page();">
    <input type="hidden" id="last_login_ip" name="last_login_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
      <article class="row">
        <div class="col s6">
          <label for="first_name">First Name</label>
          <input type="text" name="first_name" id="first_name" class="validate" required>
        </div>
        <div class="col s6">
          <label for="last_name">Last Name</label>
          <input type="text" name="last_name" id="last_name" class="validate" required>
        </div>
      </article>
      <article class="row">
        <div class="col s6">
          <label for="email">Email Address</label>
          <input type="text" name="email" id="email" class="validate" required>
        </div>
        <div class="col s6">
          <label for="phone">Phone Number</label>
          <input type="number" name="phone" id="phone" class="validate" required>
        </div>
      </article>
      <article class="row">
        <div class="col s6">
          <label for="date">Date of Birth</label>
          <input type="text" name="date" id="date" class="validate datepicker" required>
        </div>
        <div class="col s6">
          <label for="gender">Select your Gender</label>
          <select id="gender" name="gender">
            <option value="" disabled selected>Choose your gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
        </div>
      </article>
      <article class="row">
        <div class="col s6">
          <label for="course_studied">Course Studied</label>
          <select id="course_studied" name="course_studied">
            <option value="" disabled selected>Choose the Course you studied</option>
            <option value="Master of Business Administration">Master of Business Administration</option>
            <option value="MBA for executives">MBA for executives</option>
            <option value="Doctor of Business Administration">Doctor of Business Administration</option>
            <option value="MSc Information Technology">MSc Information Technology</option>
            <option value="MSc International Hospitality Management">MSc International Hospitality Management</option>
            <option value="MSc International Tourism Management">MSc International Tourism Management</option>
            <option value="BA (Hons) Business Studies">BA (Hons) Business Studies</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="col s6">
          <label for="year_graduation">Year of Graduation</label>
          <select id="year_graduation" name="year_graduation">
            <option value="" disabled selected>Year of Graduation</option>
            <?php for($i=1990;$i<=2016;$i++){ ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
          </select>
        </div>
      </article>
      <article class="row">
        <div class="col s6">
          <label for="campus">Campus</label>
          <select id="campus" name="campus">
            <option value="" disabled selected>Choose the Campus</option>
            <option value="London School of Commerce, London">London School of Commerce, London</option>
            <option value="London School of Commerce, Belgrade">London School of Commerce, Belgrade</option>
            <option value="British School of Business, Armenia">British School of Business, Armenia</option>
            <option value="London School of Commerce, Malta">London School of Commerce, Malta</option>
            <option value="Indian School of Business and Computing, Bangalore">Indian School of Business and Computing, Bangalore</option>
            <option value="London School of Commerce, Dhaka">London School of Commerce, Dhaka</option>
            <option value="British School of Commerce, Colombo">British School of Commerce, Colombo</option>
            <option value="Westminster International College, Malaysia">Westminster International College, Malaysia</option>
          </select>
        </div>
        <div class="col s6">
          <label for="nationality">Nationality</label>
          <select id="nationality" name="nationality">
            <option value="" selected="" disabled="">Select a Nationality</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
            <option value="Argentina">Argentina</option>
            <option value="Armenia">Armenia</option>
            <option value="Aruba">Aruba</option>
            <option value="Ascension Islands">Ascension Islands</option>
            <option value="Australia">Australia</option>
            <option value="Austria">Austria</option>
            <option value="Azerbaijan">Azerbaijan</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Belarus">Belarus</option>
            <option value="Belgium">Belgium</option>
            <option value="Belize">Belize</option>
            <option value="Benin">Benin</option>
            <option value="Bermuda">Bermuda</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
            <option value="Botswana">Botswana</option>
            <option value="Brazil">Brazil</option>
            <option value="British Virgin Islands">British Virgin Islands</option>
            <option value="Bulgaria">Bulgaria</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Burundi">Burundi</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Canada">Canada</option>
            <option value="Cape Verde">Cape Verde</option>
            <option value="Cayman Islands">Cayman Islands</option>
            <option value="Central African Republic">Central African Republic</option>
            <option value="Chad">Chad</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Colombia">Colombia</option>
            <option value="Comoros">Comoros</option>
            <option value="Congo - Democratic Republic of">Congo - Democratic Republic of</option>
            <option value="Congo - Republic of">Congo - Republic of</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Croatia">Croatia</option>
            <option value="Cyprus">Cyprus</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Denmark">Denmark</option>
            <option value="Djibouti">Djibouti</option>
            <option value="Dominica">Dominica</option>
            <option value="Dominican Republic">Dominican Republic</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Egypt">Egypt</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Equatorial Guinea">Equatorial Guinea</option>
            <option value="Eritrea">Eritrea</option>
            <option value="Estonia">Estonia</option>
            <option value="Ethiopia">Ethiopia</option>
            <option value="Faroe Islands">Faroe Islands</option>
            <option value="Finland">Finland</option>
            <option value="France">France</option>
            <option value="Gabon">Gabon</option>
            <option value="Gambia">Gambia</option>
            <option value="Georgia">Georgia</option>
            <option value="Germany">Germany</option>
            <option value="Ghana">Ghana</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Greece">Greece</option>
            <option value="Greenland">Greenland</option>
            <option value="Grenada">Grenada</option>
            <option value="Guadeloupe">Guadeloupe</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guinea">Guinea</option>
            <option value="Guinea-Bissau">Guinea-Bissau</option>
            <option value="Guyana">Guyana</option>
            <option value="Haiti">Haiti</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungary">Hungary</option>
            <option value="Iceland">Iceland</option>
            <option value="India">India</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Iraq">Iraq</option>
            <option value="Ireland">Ireland</option>
            <option value="Israel">Israel</option>
            <option value="Italy">Italy</option>
            <option value="Ivory Coast">Ivory Coast</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japan">Japan</option>
            <option value="Jordan">Jordan</option>
            <option value="Kampuchea">Kampuchea</option>
            <option value="Kazakhstan">Kazakhstan</option>
            <option value="Kenya">Kenya</option>
            <option value="Korea">Korea</option>
            <option value="Kosovo">Kosovo</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Kyrgyzstan">Kyrgyzstan</option>
            <option value="Laos">Laos</option>
            <option value="Latvia">Latvia</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Lesotho">Lesotho</option>
            <option value="Liberia">Liberia</option>
            <option value="Libya">Libya</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lithuania">Lithuania</option>
            <option value="Luxembourg">Luxembourg</option>
            <option value="Macedonia">Macedonia</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malawi">Malawi</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Maldives">Maldives</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Martinique">Martinique</option>
            <option value="Mauritania">Mauritania</option>
            <option value="Mauritius">Mauritius</option>
            <option value="Mayotte">Mayotte</option>
            <option value="Mexico">Mexico</option>
            <option value="Moldova">Moldova</option>
            <option value="Monaco">Monaco</option>
            <option value="Mongolia">Mongolia</option>
            <option value="Montenegro">Montenegro</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Morocco">Morocco</option>
            <option value="Mozambique">Mozambique</option>
            <option value="Myanmar">Myanmar</option>
            <option value="Namibia">Namibia</option>
            <option value="Nepal">Nepal</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Netherlands Antilles">Netherlands Antilles</option>
            <option value="New Zealand">New Zealand</option>
            <option value="Nicaragua">Nicaragua</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Norway">Norway</option>
            <option value="Oman">Oman</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Palestinian Territory">Palestinian Territory</option>
            <option value="Panama">Panama</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Philippines">Philippines</option>
            <option value="Poland">Poland</option>
            <option value="Portugal">Portugal</option>
            <option value="Qatar">Qatar</option>
            <option value="Romania">Romania</option>
            <option value="Russia">Russia</option>
            <option value="Rwanda">Rwanda</option>
            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
            <option value="Saint Lucia">Saint Lucia</option>
            <option value="Saint Martin">Saint Martin</option>
            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Senegal">Senegal</option>
            <option value="Serbia">Serbia</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Sierra Leone">Sierra Leone</option>
            <option value="Singapore">Singapore</option>
            <option value="Slovakia">Slovakia</option>
            <option value="Slovenia">Slovenia</option>
            <option value="Somalia">Somalia</option>
            <option value="South Africa">South Africa</option>
            <option value="Spain">Spain</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Suriname">Suriname</option>
            <option value="Swaziland">Swaziland</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Taiwan">Taiwan</option>
            <option value="Tajikistan">Tajikistan</option>
            <option value="Tanzania">Tanzania</option>
            <option value="Thailand">Thailand</option>
            <option value="Togo">Togo</option>
            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
            <option value="Tunisia">Tunisia</option>
            <option value="Turkey">Turkey</option>
            <option value="Turkmenistan">Turkmenistan</option>
            <option value="Turks and Caicos">Turks and Caicos</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Uganda">Uganda</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="United States">United States</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Vietnam">Vietnam</option>
            <option value="Western Sahara">Western Sahara</option>
            <option value="Yemen">Yemen</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </article>
      <article class="row">
        <div class="input-field col s12">
          <label for="business_plan">Business Plan</label>
          <textarea id="business_plan" name="business_plan" class="materialize-textarea" length="5000"></textarea>
        </div>
      </article>
      <article class="row">
        <div class="file-field input-field col s12">
          <div class="btn"> <span>Upload Multiple Files</span>
            <input type="file" multiple name="upload[]" id="file">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Upload one or more files">
          </div>
        </div>
      </article>
      <article class="row">
        <div class="input-field col s12">
          <button class="btn waves-effect waves-light" type="submit" name="action">Submit <i class="material-icons right">send</i> </button>
        </div>
      </article>
    </form>
  </section>
  
  <?php } ?>
  
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script> 
<script src="../js/jquery.validate.min.js"></script> 
<script src="../js/additional-methods.min.js"></script> 
<script>
 function exit_page(){
	 $("#loader").fadeIn("slow");
	 return true;
 }

$('.datepicker').pickadate({
    selectMonths: true,
    selectYears: 200,
	format: 'dd/mm/yyyy'
  });$(document).ready(function() {
    $('select').material_select();
    $('textarea#business_plan').characterCounter();
  $("#main-form").validate({
        rules: {
            first_name: {
                required: true
            },
			last_name: {
                required: true
            },
            email: {
                required: true,
                email:true
            },
            phone: {
				required: true,
				minlength: 10,
				number: true
			},
			date: {
				required: true
			},
            business_plan: {
				required: true,
				minlength: 50
            },
			 gender: {
                required: true
            },
			course_studied:{
				required: true
			},
			year_graduation:{
				required: true
			},
			campus:{
				required: true
			},
			year_graduation:{
				required: true
			},
			nationality:{
				required: true
			}
        },
        messages: {
            first_name: "Please enter the First Name.",
			last_name: "Please enter the Last Name.",
			email: "Please enter the Email.",
			phone: "Please enter Phone number.",
            date: "Please select your Date of Birth.",
			business_plan: "Please enter your Business Plan (Minimum Length 50 Characters).",
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        }
     });
   });
</script>
</body>
</html>