@include('state::includes.head')
@include('state::includes.header')
<section class="header-secondary">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<ul class="list-unstyled list-inline">
						<li>
							<a href="{{route('state', $state->slug)}}">
								<i class="fa fa-home home" aria-hidden="true"></i>
								Home
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="">
								{{$title}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="page-height page-content cm-content section-spacing">
	<div class="container">
		<div class="rte-container">
			<div class="heading-strip all-pg-heading ">
				<h1>
				Instructions for Students registration
				</h1>
				<h2 class="instruction-heading">
				छात्रों के पंजीकरण के लिए निर्देश
				</h2>
			</div>

			<div class="instruction-list">
				<ol class="">
					<li>
						{{ googletrans('अभिभावक rte121c-ukd.in पर जायें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('वेबसाइट खुलने पर रजिस्ट्रेशन पर क्लिक करें और स्टूडेंट रजिस्ट्रेशन पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('रजिस्ट्रेशन फ़ॉर्म खुलने पर सही जानकारी ध्यान से फ़ॉर्म में भरें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('अपने दिये हुए मोबाइल नम्बर पर आपको रजिस्ट्रेशन नम्बर प्राप्त होगा, जो लॉट्री के समय काम आयेगा।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('सभी प्रकार की जानकारी भरें और "आगे बढें (Save and Next)" बटन पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('सभी जानकारी भरने के पश्चात "जमा करें (Submit)" बटन पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('स्टार * लगे हुए क्षेत्रों में जानकारी भरना अनिवार्य है।', $_COOKIE['lang']) }}
					</li>
					<li>{{ googletrans('आयु मानदंड: तिथि 1 अप्रैल 2021 के अनुसार बच्चे की कक्षा और जन्म तिथि इस हिसाब से होनी चाहिए:', $_COOKIE['lang']) }}
								<ul>
									<li>{{ googletrans('प्री प्राइमरी: 1 अप्रैल 2016 से 31 मार्च 2018', $_COOKIE['lang']) }}</li>
									<li>{{ googletrans('पहली कक्षा: 1 अप्रैल 2015 से 31 मार्च 2016', $_COOKIE['lang']) }}</li>
								</ul>
							</li>
					<li>
						{{ googletrans('ऑनलाइन आवेदन के बाद माता-पिता अपने ब्लॉक के उपशिक्षा अधिकारी दफ़्तर पर दस्तावेज़ो/मूल अभिलेखों के सत्यापन के लिए ले जाये।  सत्यापन की आखरी तारीख 15 मार्च 2020 होगी।', $_COOKIE['lang']) }}
					</li>
					<li>
					{{ googletrans('लॉट्री उन्ही आवेदकों की होगी जिनके दस्तावेज़ खंड शिक्षा अधिकारी दफ्तर पर सत्यपित होंगे।', $_COOKIE['lang']) }}
					</li>
						 {{ googletrans('मूल अभिलेख:', $_COOKIE['lang']) }}
						<ol>
							<li>
								{{ googletrans('आवेदन पत्र की प्रति', $_COOKIE['lang']) }}
							</li>
							<li>
								{{ googletrans('पात्रता के दस्तावेज:', $_COOKIE['lang']) }}
								<ul>
									<li>
										{{ googletrans('बच्चे का जन्म प्रमाण पत्र (दस्तावेज़ जो स्वीकार्य हैं - जन्म प्रमाणपत्र, आधार कार्ड ,स्वघोषणा पत्र)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('माता/पिता के पते का प्रमाण पत्र (दस्तावेज़ जो स्वीकार्य हैं - स्थायी निवास प्रमाण पत्र/ आधार कार्ड/ वोटर   आई.डी. कार्ड/ राशन कार्ड/ ड्राइविंग लाइसेंस/ बैंक पासबुक/ बिजली का बिल)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('माता या पिता का आधार कार्ड/ वोटर आई. डी./ ड्राइविंग लाइसेंस/ पैन कार्ड', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('आय प्रमाणपत्र/ बीपीएल कार्ड (आर्थिक रूप से कमजोर परिवार के लिए, सालाना 55,000 से कम)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('माता या पिता का जाति प्रमाणपत्र ( यदि अनुसूचित जाति/जनजाति/अन्य पिछडी जाति से हैं)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('मेडिकल दस्तावेज (यदि बच्चा दिव्यांग/ कोढ़/ HIV पीड़ित है)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('निराश्रय दस्तावेज (यदि बच्चा निराश्रय है)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('तलाक का दस्तावेज (यदि माता तलाकशुदा है)', $_COOKIE['lang']) }}
									</li>
									<li>
										{{ googletrans('मृत्यु प्रमाण पत्र ( यदि माता विध)', $_COOKIE['lang']) }}
									</li>
								</ul>
							</li>
							
						</ol>
					<li>
						{{ googletrans('खंड शिक्षा अधिकारियों द्वारा सत्यपित आवेदको की लॉटरी 20 मार्च 2020 को होगी। जिनका नाम लाटरी में आएगा उनके पंजिकृत मोबाइल नंबर पर मैसेज आजायेगा।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('लॉटरी में नाम आने के बाद माता -पिता अपने दस्तावेज़ की एक कॉपी स्कूल में ले जाकर दाखिला कर सकते हैं।', $_COOKIE['lang']) }}
					</li>
				</ol>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')