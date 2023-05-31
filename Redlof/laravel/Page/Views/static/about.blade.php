@include('page::includes.head')
@include('page::includes.header-static')
<section class="bg-lt-blue body-spacing">
	<div class="container">
		<div class="static-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="">
						<h2>
							About Us
						</h2>
						<p>
							One thing we all have in common, no matter where we are from – we want to be happy. How we imagine happiness may differ from one another, but we all have wanting happiness in common. Many of us spend our entire lives trying to find happiness, yet we often find ourselves lost.
						</p>
						<p>
							When you ask people what is the connection between being happy and grateful, most say it’s easy – when you are happy, you are grateful. But think again… is it really the happy people that are grateful? We all know quite a number of people who have everything that it would take to be happy, and they are not happy; they want something else, they want more of the same. And we also know a lot of people who have lots of misfortune, the misfortunes that none of us want to have… and they are deeply happy. They radiate happiness; we are surprised. Why? Because they are grateful. So it is gratefulness that makes us happy, not the other way around.
						</p>
						<h5>
							So what do we really mean by gratefulness, and how does it work?
						</h5>
						<p>
							We all know from experience how it goes – we experience something that is valuable to us, and that something valuable is given to us. These 2 things have to come together – something valuable to us, and it’s a real gift; you haven’t bought it, you haven’t earned it, you haven’t traded in anything for it – it was just given to you. When these 2 things come together – something that’s really valuable to you, and you realize it’s freely given to you, then gratefulness and happiness spontaneously rise from your heart. That’s how it happens.
						</p>
						<p>
							The key to all of this is that we cannot just wish to experience this once in a while, and we cannot always only have grateful experiences, but we can be people who live gratefully – grateful living, that’s the thing. And how can we live gratefully? By experiencing and becoming aware that every moment is a moment given to us – it’s a gift we haven’t earned. We have no way of assuring that there will be another moment given to us, and yet that’s the most valuable thing that can ever be given to us.
						</p>
						<p>
							It can change our world in immensely important ways because if we are grateful, we are not fearful, if we are not fearful, we are not violent. If we are grateful, we act out of a sense of abundance, and not of a sense of scarcity, and we are willing to share. If we are grateful, we are enjoying the differences between people, and we are respectful to everybody, and that changes this power pyramid under which we live. It doesn’t make for equality, but it makes for equal respect, and that is the important thing.
						</p>
						<h5>
							The future of the world will be a network, not a pyramid nor a pyramid upside down. This will create a revolution, a non-violent revolution.
						</h5>
						<p>
							Now, re-imagine the future, full of hope, gratitude and appreciation. All of us, though most don’t realize, have the power to influence. Thorough simple powers of compliments, forgiveness, gratitude and random acts of kindness we can make this world a better, happier place.
						</p>
						<p>
							In order to start this movement, we at <a href=""> RTE</a>, thought the best way to let people feel this emotion is to give them a channel to express gratitude to strangers and kins they received help from, but had not had a chance to thank them properly, in a thoughtful, memorable way.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@if(\AuthHelper::isSignedInWithCookie())
@include('page::includes.footer-static')
@else
@include('page::includes.footer')
@endif

@include('page::includes.foot')