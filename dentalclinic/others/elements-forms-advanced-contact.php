<?php
namespace PortoContactForm;
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/simple-php-captcha/simple-php-captcha.php';
require 'php/php-mailer/src/PHPMailer.php';
require 'php/php-mailer/src/SMTP.php';
require 'php/php-mailer/src/Exception.php';

// Step 1 - Enter your email address below.
$email = 'you@domain.com';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

if(isset($_POST['emailSent'])) {

	// If contact form don't has the subject input change the value of subject here
	$subject = ( isset($_POST['subject']) ) ? $_POST['subject'] : 'Define subject in php/contact-form.php line 29';

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (strtolower($_POST['captcha']) == strtolower($_SESSION['captcha']['code'])) {

		$message = '';

		foreach($_POST as $label => $value) {
			if( !in_array( $label, array( 'emailSent', 'captcha' ) ) ) {
				$label = ucwords($label);

				// Use the commented code below to change label texts. On this example will change "Email" to "Email Address"

				// if( $label == 'Email' ) {               
				// 	$label = 'Email Address';              
				// }

				// Checkboxes
				if( is_array($value) ) {
					// Store new value
					$value = implode(', ', $value);
				}

				$message .= $label.": " . htmlspecialchars($value, ENT_QUOTES) . "<br>\n";
			}
		}

		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = $debug;                            // Debug Mode

			// Step 3 (Optional) - If you don't receive the email, try to configure the parameters below:

			//$mail->IsSMTP();                                         // Set mailer to use SMTP
			//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
			//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			//$mail->Username = 'user@example.com';                    // SMTP username
			//$mail->Password = 'secret';                              // SMTP password
			//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
			//$mail->Port = 587;   								       // TCP port to connect to

			$mail->AddAddress($email);	 						       // Add a recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add another recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			// From - Name
			$fromName = ( isset($_POST['name']) ) ? $_POST['name'] : 'Website User';
			$mail->SetFrom($email, $fromName);

			// Repply To
			if( isset($_POST['email']) ) {
				$mail->AddReplyTo($_POST['email'], $fromName);
			}

			$mail->IsHTML(true);                                  		// Set email format to HTML

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			// Step 4 - If you don't want to attach any files, remove that code below
			if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
				$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
			}

			$mail->Send();

			$arrResult = array ('response'=>'success');

		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (\Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

	} else {

		$arrResult = array ('response'=>'captchaError');

	}

}
?>
<!DOCTYPE html>
<!-- devcode: !production -->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Forms | Porto - Responsive HTML5 Template 7.5.0</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">
		
		<!-- Demo CSS -->


		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css"> 

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>

		<div class="body">
			<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body border-top-0">
					<div class="header-top">
						<div class="container">
							<div class="header-row py-2">
								<div class="header-column justify-content-start">
									<div class="header-row">
										<nav class="header-nav-top">
									</div>
								</div>
								<div class="header-column justify-content-end">
									<div class="header-row">
										<ul class="header-social-icons social-icons d-none d-sm-block social-icons-clean">
											<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
											<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
											<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="index.html">
											<img alt="Porto" width="100" height="48" data-sticky-width="82" data-sticky-height="40" src="img/logo.png">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav header-nav-line header-nav-top-line header-nav-top-line-with-border order-2 order-lg-1">
										<div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
													<li class="dropdown">
												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">

				<section class="page-header page-header-modern page-header-background page-header-background-sm overlay overlay-color-primary overlay-show overlay-op-8 mb-5" style="background-image: url(img/page-header/page-header-elements.jpg);">
					<div class="container">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1>Forms</h1>

							</div>
							<div class="col-md-12 align-self-center order-1">
								<ul class="breadcrumb breadcrumb-light d-block text-center">
									<li><a href="#">Home</a></li>
									<li class="active">Elements</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<div class="container py-2">

					<div class="row">
						<div class="col-lg-3 order-2 order-lg-1">
							<aside class="sidebar mt-2">
						</div>
						<div class="col-lg-9 order-1 order-lg-2">
							
							<div class="offset-anchor" id="contact-sent"></div>

							<?php
							if (isset($arrResult)) {
								if($arrResult['response'] == 'success') {
								?>
								<div class="alert alert-success" id="contactSuccess">
									<strong>Success!</strong> Your message has been sent to us.
								</div>
								<?php
								} else if($arrResult['response'] == 'error') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> There was an error sending your message.
									<span class="font-size-xs mt-2 d-block" id="mailErrorMessage"><?php echo $arrResult['errorMessage'];?></span>
								</div>
								<?php
								} else if($arrResult['response'] == 'captchaError') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> Verification failed.
								</div>
								<?php
								}
							}
							?>

							<div class="overflow-hidden mb-1">
								<h2 class="font-weight-normal text-7 mb-0"><strong class="font-weight-extra-bold">Contact</strong> Us</h2>
							</div>
							<div class="overflow-hidden mb-4 pb-3">
								<p class="mb-0">Feel free to ask for details, don't save any questions!</p>
							</div>

							<form id="contactFormAdvanced" action="<?php echo basename($_SERVER['PHP_SELF']); ?>#contact-sent" method="POST" enctype="multipart/form-data">
								<input type="hidden" value="true" name="emailSent" id="emailSent">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="required font-weight-bold text-dark">Full Name</label>
										<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
									</div>
									<div class="form-group col-md-6">
										<label class="required font-weight-bold text-dark">Email Address</label>
										<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<label class="font-weight-bold text-dark">Subject</label>
										<select data-msg-required="Please enter the subject." class="form-control" name="subject" id="subject" required>
											<option value="">...</option>
											<option value="Option 1">Option 1</option>
											<option value="Option 2">Option 2</option>
											<option value="Option 3">Option 3</option>
											<option value="Option 4">Option 4</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<p class="mb-2">Checkboxes</p>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" name="checkboxes[]" type="checkbox" data-msg-required="Please select at least one option." id="inlineCheckbox1" value="option1"> 1
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" name="checkboxes[]" type="checkbox" data-msg-required="Please select at least one option." id="inlineCheckbox1" value="option2"> 2
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" name="checkboxes[]" type="checkbox" data-msg-required="Please select at least one option." id="inlineCheckbox1" value="option3"> 3
											</label>
										</div>
									</div>
									<div class="form-group col-md-6">
										<p class="mb-2">Radios</p>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" type="radio" name="radios" data-msg-required="Please select at least one option." id="inlineRadio1" value="option1"> 1
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" type="radio" name="radios" data-msg-required="Please select at least one option." id="inlineRadio2" value="option2"> 2
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" type="radio" name="radios" data-msg-required="Please select at least one option." id="inlineRadio3" value="option3"> 3
											</label>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<label class="font-weight-bold text-dark">Attachment</label>
										<input class="d-block" type="file" name="attachment" id="attachment">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12 mb-4">
										<label class="required font-weight-bold text-dark">Message</label>
										<textarea maxlength="5000" data-msg-required="Please enter your message." rows="6" class="form-control" name="message" id="message" required></textarea>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12 mb-0">
										<label class="font-weight-bold text-dark">Human Verification</label>
									</div>
								</div>
								<div class="form-row pt-2">
									<div class="form-group col-md-4">
										<div class="captcha form-control">
											<div class="captcha-image">
												<?php
												$_SESSION['captcha'] = simple_php_captcha(array(
													'min_length' => 6,
													'max_length' => 6,
													'min_font_size' => 22,
													'max_font_size' => 22,
													'angle_max' => 3
												));

												$_SESSION['captchaCode'] = $_SESSION['captcha']['code'];

												echo '<img id="captcha-image" src="' . "php/simple-php-captcha/simple-php-captcha.php/" . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
												?>
											</div>
											<div class="captcha-refresh">
												<a href="#" id="refreshCaptcha"><i class="fas fa-sync"></i></a>
											</div>
										</div>
									</div>
									<div class="form-group col-md-8">
										<input type="text" value="" maxlength="6" data-msg-captcha="Wrong verification code." data-msg-required="Please enter the verification code." placeholder="Type the verification code." class="form-control form-control-lg captcha-input" name="captcha" id="captcha" required>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<hr>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12 mb-5">
										<input type="submit" id="contactFormSubmit" value="Send Message" class="btn btn-primary btn-modern pull-right" data-loading-text="Loading...">
									</div>
								</div>
							</form>

						</div>
					</div>

				</div>

				<section class="section section-height-2 border-0 mt-5 mb-0 pt-5">
				
					<div class="container py-2">
						<div class="row mt-3 pb-4">
							<div class="col text-center">
								<h2 class="font-weight-semibold text-6 mb-0">Porto Elements</h2>
								<p class="lead text-4 pt-2 font-weight-normal">Porto comes with several elements options, it's easy to customize<br> and create the content of your website's pages.</p>
							</div>
						</div>
						<div class="row justify-content-center">

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-accordions.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-bars"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-bars"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Accordions</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-toggles.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-indent"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-indent"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Toggles</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-tabs.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-columns"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-columns"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Tabs</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-icons.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-check"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-check"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Icons</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-icon-boxes.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-check-circle"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-check-circle"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Icon Boxes</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-carousels.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-ellipsis-h"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-ellipsis-h"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Carousels</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-modals.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-expand"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-expand"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Modals</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-lightboxes.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-clone"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-clone"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Lightboxes</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-buttons.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-minus"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-minus"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Buttons</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-badges.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-bars"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-bars"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Badges</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-lists.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-list-ul"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-list-ul"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Lists</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-image-gallery.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-file-image"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-file-image"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Image Gallery</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-image-frames.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-images"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-images"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Image Frames</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-image-hotspots.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-hand-point-up"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-hand-point-up"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Image Hotspots</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-testimonials.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-comments"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-comments"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Testimonials</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-blockquotes.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-quote-left"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-quote-left"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Blockquotes</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-word-rotator.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fab fa-autoprefixer"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fab fa-autoprefixer"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Word Rotator</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-before-after.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-arrows-alt-h"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-arrows-alt-h"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Before / After</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-typography.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-font"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-font"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Typography</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-call-to-action.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-external-link-alt"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-external-link-alt"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Call to Action</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-pricing-tables.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-dollar-sign"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-dollar-sign"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Pricing Tables</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-tables.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-table"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-table"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Tables</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-progressbars.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-chart-bar"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-chart-bar"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Progress Bars</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-counters.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-sort-numeric-down"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-sort-numeric-down"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Counters</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-countdowns.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-clock"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-clock"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Countdowns</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-sections-parallax.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-images"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-images"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Sections &amp; Parallax</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-tooltips-popovers.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-comment-alt"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-comment-alt"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Tooltips &amp; Popovers</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-sticky-elements.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-compress"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-compress"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Sticky Elements</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-headings.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-text-height"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-text-height"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Headings</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-dividers.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-align-center"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-align-center"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Dividers</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-animations.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-asterisk"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-asterisk"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Animations</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-medias.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-play-circle"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-play-circle"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Medias</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-maps.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-map"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-map"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Maps</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-arrows.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-arrow-alt-circle-right"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-arrow-alt-circle-right"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Arrows</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-star-ratings.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-star"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-star"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Star Ratings</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-alerts.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-exclamation-triangle"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-exclamation-triangle"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Alerts</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-posts.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-calendar-alt"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-calendar-alt"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Posts</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-forms-basic-contact.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="far fa-file-alt"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="far fa-file-alt"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">Forms</span>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="col-6 col-sm-4 col-lg-2">
								<div class="featured-boxes featured-boxes-modern-style-2 featured-boxes-modern-style-2-hover-only featured-boxes-modern-style-primary m-0 mb-4 pb-3">
									<div class="featured-box featured-box-no-borders featured-box-box-shadow">
										<a href="elements-360-image-viewer.html" class="text-decoration-none">
											<span class="box-content px-1 py-4 text-center d-block">
												<span class="text-primary text-8 position-relative top-3 mt-3"><i class="fas fa-sync-alt"></i></span>
												<span class="elements-list-shadow-icon text-default"><i class="fas fa-sync-alt"></i></span>
												<span class="font-weight-bold text-uppercase text-1 negative-ls-1 d-block text-dark pt-2">360º Image Viewer</span>
											</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				</section>
			</div>
 
			<footer id="footer" class="mt-0">
		</div>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="js/examples/examples.forms.js"></script>

		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-12345678-1', 'auto');
			ga('send', 'pageview');
		</script>
		 -->

	</body>
</html>