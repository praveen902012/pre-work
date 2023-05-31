@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height page-content section-spacing">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<h1>
					Frequently Asked Questions (FAQs)
					</h1>
					<h2 class="instruction-heading">
					स्कूल द्वारा पू्छे जाने वाले सवाल
					</h2>
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ googletrans('१. प्रश्न : अभिभावक ऑनलाइन आवेदन कैसे कर सकते हैं?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : rte121c-ukd.in में जाकर अभिभावक अपने बच्चे का आर.टी.ई. के अंतर्गत आवेदन कर सकते हैं।', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									{{ googletrans('२. प्रश्न : पिछले वर्ष पोर्टल में पंजीकृत विद्यालयों को इस वर्ष दोबारा अपना पंजीकरण कराना होगा?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : नहीं। ऐसे विद्यालयों को पोर्टल में Registration में जाकर Resume Registration करना होगा। अपनी जानकारी की जाँच करने के बाद Submit बटन पर क्लिक करके अपना दोबारा पंजीकरण सुनिश्चित करना होगा, उसके बाद ही उनका विद्यालय सूची में ऑनलाइन दिखायी देगा', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									{{ googletrans('३. प्रश्न : अभिभावक द्वारा विद्यालय की प्राथमिकता भरे जाने के पश्चात विद्यालय को क्या करना है?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : विद्यालय को लॉट्री होने तक इन्तज़ार करना है, उसके बाद ही विद्यालय बच्चों को एड्मिशन दे सकते हैं, लॉट्री के बाद विद्यालय को आवंटित हुए बच्चों की सूची विद्यालय को अपने लॉगिन में दिख जायेगी', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									{{ googletrans('४. प्रश्न : क्या अभिभावकों को आवेदन करने के पश्चात आवेदन पत्र और प्रमाण पत्र विद्यालय में जमा करने हैं?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseFour" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : नहीं। अभिभावकों को विद्यालय में दस्तावेज नहीं जमा करने हैं, लॉट्री में नाम आने के बाद अभिभावकों को खण्ड शिक्षा अधिकारी के दफ़्तर में जमा करने हैं', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									{{ googletrans('५. प्रश्न : पोर्टल में लॉट्री के पश्चात विद्यालय को क्या करना होगा ?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseFive" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : विद्याल को आवंटित बच्चों के अभिभावकों से संपर्क करना है और खण्ड शिक्षा अधिकारी के द्वारा दस्तावेज सत्यापित हो जाने के बाद अपने लॉगिन में जाकर बच्चों के एडमिशन को स्वीकार या अस्वीकार करना है', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
									{{ googletrans('६. प्रश्न : बच्चों की फीस की प्रतिपूर्ति के लिये क्या करना होगा ?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseSix" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : एडमिशन होने के पश्चात जिला शिक्षा अधिकारी के माध्यम से विद्यालयो को ऑनलाइन पोर्टल के माधयम से फ़ीस की प्रतिपूर्ति की जायेगी। अधिक जानकारी के लिये जिला शिक्षा अधिकारी से सम्पर्क करें।', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')