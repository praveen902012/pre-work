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
				Instructions for Deputy Education Officers 
				</h1>
				<h2  class="instruction-heading">
				उपशिक्षा अधिकारियों के लिए निर्देश
				</h2>
			</div>
			<div class="instruction-list">
				<ol class="">
					<li>
					इस वर्ष (2019-20) सभी उप शिक्षा अधिकारी अपने विकासखण्ड में स्थित निजी विद्यालयों की मान्यता तथा उसके स्थानीय निकाय-वॉर्ड/ ग्राम पंचायत/ नगर पंचायत/ नगर पालिका/ नगर इकाई का सत्यापन कर इस आशय का घोषणा पत्र राज्य परियोजना कार्यालय को उपलब्ध करायेंगे। घोषणा पत्र उप शिक्षा अधिकारी द्वारा पोर्टल में भी अपलोड किया जाना होगा।
					</li>
					<li>
					मूल अभिलेखों की जाँच के उपरांत अभिभावक आवेदन पत्र के साथ स्वयं हस्ताक्षरित घोषणा पत्र और सभी संबंधित अभिलेखों की 2-2 स्वप्रमाणित छायाप्रति उपशिक्षा कार्यालय में जमा करायेंगे।
					</li>
					<li>
					उपशिक्षा अधिकारी कार्यालय द्वारा चयनित छात्रों की पृथक - पृथक 2 फाइल बनायी जायेंगी। एक छात्र फाइल संबंधित निजी विद्यालय जहाँ छात्र का प्रवेश हुआ है, को प्रेषित की जायेगी तथा दूसरी फाइल कार्यालय में सुरक्षित रखी जायेगी। यह प्रक्रिया 15 जून तक संपन्न की जानी है।
					</li>
				
				</ol>
			</div>
			
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')