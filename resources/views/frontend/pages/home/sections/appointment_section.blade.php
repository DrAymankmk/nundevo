<section class="video-area overflow-hidden space" data-bg-src=" {{ asset('frontend/assets/img/bg/video_bg_1.jpg') }}">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-7">
				<div class="appointment-area-wrapper">
					<form action="mail.php" method="POST"
						class="appointment-form wow fadeInUp ajax-contact">
						<div class="title-area mb-40">
							<span class="sub-title">Book an
								appointment</span>
							<h2 class="sec-title">Book an
								Appointment for <span
									class="fw-normal">Expert
									Consultation</span>
							</h2>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								<input type="text" class="form-control"
									name="name" id="name"
									placeholder="Patient name">
								<i class="fal fa-user"></i>
							</div>
							<div class="form-group col-md-6">
								<input type="email" class="form-control"
									name="email" id="email"
									placeholder="Email address">
								<i class="fal fa-envelope"></i>
							</div>
							<div class="form-group col-md-6">
								<select name="subject" id="subject"
									class="form-select nice-select">
									<option value="" disabled
										selected hidden>
										Select
										Location
									</option>
									<option
										value=" New York, USA">
										New York,
										USA
									</option>
									<option value="London, UK">
										London, UK
									</option>
									<option
										value="Toronto, Canada">
										Toronto,
										Canada
									</option>
									<option
										value="Los Angeles, USA">
										Los
										Angeles,
										USA
									</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<select name="subject" id="subject2"
									class="form-select nice-select">
									<option value="" disabled
										selected hidden>
										Choose
										Doctor
									</option>
									<option
										value="Dr. Sarah Johnso">
										Dr. Sarah
										Johnso
									</option>
									<option value="Dr. Raj Patel">
										Dr. Raj
										Patel
									</option>
									<option
										value="Dr. Emily Wong">
										Dr. Emily
										Wong
									</option>
									<option
										value="Dr. Olivia Smith ">
										Dr. Olivia
										Smith
									</option>
								</select>
							</div>
							<div class="form-group col-12">
								<select name="subject" id="subject3"
									class="form-select nice-select">
									<option value="" disabled
										selected hidden>
										Select
										Department
									</option>
									<option
										value="General Medicine">
										General
										Medicine
									</option>
									<option
										value="Heart Specialists">
										Heart
										Specialists
									</option>
									<option
										value="Skin & Hair Specialists">
										Skin &
										Hair
										Specialists
									</option>
									<option
										value="Child Specialists">
										Child
										Specialists
									</option>
								</select>
							</div>
							<div class="form-group col-12">
								<textarea name="message" id="message"
									cols="30" rows="3"
									class="form-control"
									placeholder="Appointment note"></textarea>
								<i class="fal fa-comment"></i>
							</div>
							<div class="col-12 form-group">
								<input type="checkbox" id="html">
								<label for="html">I agree to
									the Terms of Use and
									Privacy
									Policy</label>
							</div>
							<div class="btn-group col-12">
								<button
									class="th-btn style2 style-radius">Make
									Appointment <i
										class="fa-light fa-arrow-right-long ms-2"></i></button>
								<div class="call-info">
									<div class="call-icon">
										<a
											href="tel:+0012345678900"><i
												class="fa-solid fa-phone"></i></a>
									</div>
									<div class="media-body">
										<span
											class="call-label">For
											emergency,
											Call
											Now</span>
										<p
											class="call-link">
											<a
												href="tel:+0012345678900">+00
												(123)
												456789
												00</a>
										</p>
									</div>
								</div>
							</div>
						</div>
						<p class="form-messages mb-0 mt-3"></p>
					</form>
				</div>

			</div>
			<div class="col-xl-5">
				<div class="video-box1 wow fadeInRight text-center">
					<a href="https://www.youtube.com/watch?v=i2pMEhEzbEs"
						class="video-play-btn popup-video">
						<i class="fa-solid fa-play"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>