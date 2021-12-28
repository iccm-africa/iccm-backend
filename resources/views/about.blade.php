@extends('layouts.app')

@section('title')
About
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('About') }}</div>

						<div class="card-body">
							<p>
							<center>
							<a href="{{ asset('pdf/KingdomIT-ICCM_Africa-ENG.pdf') }}" target="_blank"><button type="button" class="btn btn-success">ICCM-AFRICA information leaflet</button></a>
							</center>
							</p>
							ICCM, the “International Conference on Computing and Mission” is an annual technology conference for missionaries, by missionaries.  There are a number of different regions where this conference is held, ICCM-USA, ICCM-Australia, ICCM-Europe, and now ICCM-Africa.
							<br/><br/>
							The goal of ICCM is that the people who are doing the work of the Great Commission have the technological expertise needed to do the tasks they are called to do.  While the conference has a lot of good computer training, the strength of ICCM lies in its international community.  The goal is to not only answer the current technological questions the IT missionaries have, but to give the techies a community they can go to when they come up with more questions throughout the year.
							<br/><br/>
							ICCM is “For Missionaries, By Missionaries.”  That is, it is for the people enacting the Great Commission, and put on by the people enacting the Great Commission.  The reason for this is so that the knowledge shared is not just the “corporate knowledge”, but focuses on “what technologies are being effective for the Kingdom.”  So most of the teaching that happens comes from missionary techies who will say, “This is the technology we have used, this is how we used it, and this is why it is effective for the Kingdom.”  Most of the people who create technology want to sell it to you in the hopes you will find it effective.  In ICCM, we attempt to share the technologies we have already found to be effective.  We always try to have some sessions on the future technologies and discussion on how they might be useful. But the outlook on technology is such that we are all using God’s funds, we are all working towards fulfilling the Great Commission, and we are using technology creatively to do so.
							<br/><br/>
							ICCM is NOT “For Westerners, By Westerners”  ICCM Africa is being started by Westerners because ICCM started in a Westernized country.  As soon as possible, the leadership and management of the conference will pass into the hands of the missionaries in Africa.  ICCM is NOT “For Africans, By Africans” either.  It is “For Missionaries, By Missionaries.”  Any missionary that will benefit from the knowledge of technology within Africa, or whose knowledge would be helpful to teach the missionaries within Africa is welcome.
							<br/><br/>
							<h2>And what is a “Missionary?”</h2>
							 In Western contexts, the missionary is someone sent overseas to help accomplish the Great Commission.  Most of the “Missionary Techies,” however, remain back in their home country, providing an infrastructure for those doing the work.  In the context of countries where much of the spreading of the Gospel is being done by national workers, ICCM the “Missionary” does not need to come from afar or be working with someone outside their culture.  ICCM is the International Conference on Computing and MISSION.  Anyone involved in Mission (whose primary goal is to fulfill the great commission) and who is a techie, is welcome.  As the conference grows and stabilizes, we may come up with a clear and concise form of communicating this to those in Africa.  But for now, anyone who is using technology to fulfill the Great Commission, or who is supporting the technology for a group that is attempting to fulfill the Great Commission, is welcome to attend.
							<br/><br/>
							<h2>Why regional conferences?</h2>  We know that it is expensive for people to travel internationally.  And while a lot of the strength of the conference comes from the variety of perspectives that come from people from different cultures, we realize that even in a regional conference we get a fair bit of different perspectives.  Keeping the conference cost-effective so more people can attend is very important.  But we try to keep our email lists generic such that people from all the regional conferences will give their opinions about the various topics.  So we are trying to maintain the balance of keeping ICCM accessible to all the people who need it, while maintaining the International flavor.
							<br/><br/>
							<h2>Why Africa?</h2>  Africa has a huge amount of national workers in it who are building churches, missions, and ministries of many different sorts.  Africa has some areas of high technology, and many areas of low technology.  Many Western organizations are using technology to reach into Africa, and many African missions are working within Africa.  And with the fairly unique technological needs, it stands to reason to have a regional conference dedicated to the specific needs of Africa.  But also, by having the conference within Africa, and hosted at a location that is geared towards serving nationals, it keeps the cost at a level that nationals can afford.
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
