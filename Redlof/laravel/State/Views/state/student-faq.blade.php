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
					अभिभावकों द्वारा पू्छे जाने वाले सवाल
					</h2>
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									{{ googletrans('१. प्रश्न : मेरे हैबिटेशन (ग्रामपंचायत / पारा / मोहल्लल्लला / एररया ) में कोई भी स्कूल नहीं दिख रहा है ?', $_COOKIE['lang']) }}
								</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in">
								<div class="panel-body">
									<p>{{ googletrans('उत्तर : आपके चुने हुए क्षेत्र में चुनी कक्षा के लिये कोई स्कूल नहीं आता है। अधिक जानकारी के लिये अपने नोडल ऑफिसर से संपर्क करें कि क्या आपके क्षेत्र में आने वाले विद्यालय RTE पोर्टल में पंजीकृत हैं?', $_COOKIE['lang']) }}</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> {{ googletrans('२. प्रश्न : हमारे पास बच्चे का जन्म प्रमाण पत्र नहीं है ?', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : माता - पिता या अभिभावक बच्चे के जन्म प्रमाण पत्र के लिये (जिला अस्पताल में जाकर) ऑनलाइन आवेदन की तिथि आने से पहले आवेदन करें।', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">{{ googletrans('३. प्रश्न : बच्चे का दिव्यांग होने का प्रमाण पत्र नहीं है ?', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर :दिव्यांग होने के प्रमाण पत्र के लिये फॉर्म भरकर (जिला अस्पताल में जाकर) जल्द से जल्द दिव्यांग होने का प्रमाण पत्र प्राप्त करें ।', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">{{ googletrans('४. प्रश्न : जन्म तिथि सत्यापन की जानकारी:', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseFour" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : जन्म प्रमाण पत्र, आधार कार्ड', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">{{ googletrans('५. प्रश्न : पहचान पत्र की जानकारी (पालक / अभिभावक के नाम और फोटो के साथ ):', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseFive" class="panel-collapse collapse">
								<div class="panel-body">
									<p>{{ googletrans('उत्तर :', $_COOKIE['lang']) }}
										<ul>
											<li>{{ googletrans('आधार कार्ड', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('वोटर आईडी कार्ड', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('ड्राइविंग लाइसेंस', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('पैन कार्ड', $_COOKIE['lang']) }}</li>
										</ul>
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">{{ googletrans('६. प्रश्न : पता के प्रमाण पत्र की जानकारी : ', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseSix" class="panel-collapse collapse">
								<div class="panel-body">
									<p>{{ googletrans('उत्तर :', $_COOKIE['lang']) }}
										<ul>
											<li>{{ googletrans('आधार कार्ड', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('राशन कार्ड', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('मूल निवास प्रमाण पत्र', $_COOKIE['lang']) }}</li>
											<li>{{ googletrans('बिजली का बिल', $_COOKIE['lang']) }}</li>
										</ul>
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">{{ googletrans('७. प्रश्न : स्टूडेंट का रजिस्ट्रेशन कर लिया है, अब इसके बाद क्या करना होगा ?', $_COOKIE['lang']) }}</a>
								</h4>
							</div>
							<div id="collapseSeven" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans("उत्तर : आवेदन भरने के पश्चात आवेदन फॉर्म और दस्तावेजों की दो-दो कॉपी अपने खंड शिक्षा अधिकारी के दफ्तर में जमा कराएं' लोटरी  होने  के बाद परिणाम में  एडमिसन  की स्थिति चेक करें | अगर लोटरी में नाम आया है तो विध्यालय में जाकर एडमिसन कराएं", $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>


						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">{{ googletrans('८. प्रश्न : RTE के तहत प्रवेश प्राप्त होने पर विद्यालय में कितना शुल्क देना होगा ?', $_COOKIE['lang']) }}</a>
								</h4>

							</div>
							<div id="collapseEight" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर : उत्तर : प्रवेशित छात्र को कोई शुल्क नही देना होगा, शुल्क की प्रतिपूर्ती विद्यालय को शासन द्वारा की जायेगी |', $_COOKIE['lang']) }}
									</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseNine">{{ googletrans('९. प्रश्न : हम अपने बच्चे के लिये कितने विद्यालयों का चुनाव कर सकते हैं?', $_COOKIE['lang']) }}</a>
								</h4>

							</div>
							<div id="collapseNine" class="panel-collapse collapse">
								<div class="panel-body">
									<p>
										{{ googletrans('उत्तर :सूची में जो विद्यालय आपको फॉर्म में दिखायी देंगे, उनमें से आप कम से कम एक और ज्यादा से ज्यादा जितने विद्यालय देखेंगे उन सब को चुन सकते है', $_COOKIE['lang']) }}
									</p>
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
