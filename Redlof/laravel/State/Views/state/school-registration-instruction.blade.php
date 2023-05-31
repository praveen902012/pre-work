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
				Instructions for schools which were registered last year
				</h1>
				<h2  class="instruction-heading">
				जिन स्कूलों का पंजीकरण पिछले साल हुआ था, उनके लिए निर्देश
				</h2>
			</div>
			<div class="instruction-list">
				<ol class="">
					<li>
						{{ googletrans('विद्यालय rte121c-ukd.in पर जायें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('वेबसाइट खुलने के पश्चात पंजीकरण पर जाकर "विद्यालय पंजीकरण" पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('Page खुलने पर Resume Registration पर क्लिक करें ।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('अपने विद्यालय की भरी हुई पूरी जानकारी को पढकर और यदि कुछ जानकारी में बदलाव करना है तो वो करने के बाद Submit करें ।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('इसके बाद खणड शिक्षा अधिकारी आपकी जानकारी को सत्यापित करेंगे, उसके बाद ही आपका विद्यालय ऑनलाइन फॉर्म भरते समय दिखाई देगा ।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('दिनांक 22 मार्च 2020 से 15 अप्रैल 2020 तक संबंधित निजी विद्यालय चयनित छात्रों को प्रवेश हेतु अनिवार्यतः सूचित करें।', $_COOKIE['lang']) }}
					</li>
					<!-- <li>
						सीटों की संख्या भरते समय  उपलब्ध कुल सीटों का 25% भरें, ना कि वो जितने बच्चों का एड्मिशन हुआ है।
					</li>
					<li>
						स्टार * लगे हुए क्षेत्रों में जानकारी भरना अनिवार्य है।
					</li> -->
				</ol>
			</div>
			<div class="rte-container">
			<div class="heading-strip all-pg-heading ">
				<h1>
				Instructions for registration of new schools
				</h1>
				<h2  class="instruction-heading">
				नये विद्यालयों को पंजीकरण के लिए निर्देश
				</h2>
			</div>
			<div class="instruction-list">
				<ol class="">
					<li>
						{{ googletrans('विद्यालय rte121c-ukd.in पर जायें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('वेबसाइट खुलने के पश्चात पंजीकरण पर जाकर "विद्यालय पंजीकरण" पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('फ़ॉर्म खुलने पर सभी जानकारी ध्यान से सही भरें और "आगे बढें (Save and Next)" बटन पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('सभी जानकारी भरने के पश्चात "जमा करें (Submit)" बटन पर क्लिक करें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('एन्ट्री क्लास मे वो कक्षा भरें जिसकी मान्यता विद्यालय को जारी है। प्री-प्राइमरी अथवा पहली कक्षा।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('पते की जानकारी के page में आप शहरी या ग्रामीण क्षेत्र से हैं पहले वो चुने और फिर उस अनुसार अपना वार्ड या ग्राम पंचायत चुनें।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('री्ज़न सेलेक्शन के समय पास के वार्ड या ग्राम पन्चायत चुनें जो आपके वार्ड या ग्राम पन्चायत से लगे हुए हों।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('सीटों की संख्या भरते समय अपने विद्यालय की एन्ट्री क्लास की कुल सीटें भरें, उसका 25% स्वयं की कैलकुलेट हो कर आपको दिख जायेगा।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('रजिस्ट्रेशन के पश्चात आपको अपने मोबाइल नम्बर और ई-मेल पर पासवर्ड आयेगा जिसके द्वारा आप पोर्टल पर भविष्य में लॉगिन कर सकते हैं।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('स्टार * लगे हुए क्षेत्रों में जानकारी भरना अनिवार्य है।', $_COOKIE['lang']) }}
					</li>
					<li>
						{{ googletrans('दिनांक 22 मार्च 2020 से 15 अप्रैल 2020 तक संबंधित निजी विद्यालय चयनित छात्रों को प्रवेश हेतु अनिवार्यतः सूचित करें।', $_COOKIE['lang']) }}
					</li>
				</ol>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')