<footer class="section-footer border-top">
	<div class="container">
		<section class="footer-top padding-y">
			<div class="row">
				<aside class="col-md col-6">
					<h6 class="title">{{config('app.name')}}</h6>
					<ul class="list-unstyled">
						<li><a href="#">About us</a></li>
						<li><a href="#">Career</a></li>
						<li><a href="#">Find a store</a></li>
						<li><a href="#">Rules and terms</a></li>
						<li><a href="#">Sitemap</a></li>
					</ul>
				</aside>
				<aside class="col-md col-6">
					<h6 class="title">Account</h6>
					<ul class="list-unstyled">
                        <li><a href="{{route('user.overview')}}"> Account Overview </a></li>
                        <li><a href="{{route('user.orders')}}"> My Orders </a></li>
                        <li><a href="{{route('login')}}"> User Login </a></li>
                        <li><a href="{{route('register')}}"> User register </a></li>
					</ul>
				</aside>
				<aside class="col-md">
					<h6 class="title">Social</h6>
					<ul class="list-unstyled">
						<li><a href="#"> <i class="fab fa-facebook"></i> Facebook </a></li>
						<li><a href="#"> <i class="fab fa-twitter"></i> Twitter </a></li>
						<li><a href="#"> <i class="fab fa-instagram"></i> Instagram </a></li>
						<li><a href="#"> <i class="fab fa-youtube"></i> Youtube </a></li>
					</ul>
				</aside>
			</div> <!-- row.// -->
		</section>	<!-- footer-top.// -->

		<section class="footer-bottom border-top row">
			<div class="col-md-6">
				<p class="text-muted"> &copy {{ date('Y') }} {{ config('app.name') }} </p>
			</div>
			<div class="col-md-6 text-md-right text-muted">
				<i class="fab fa-lg fa-cc-visa"></i>
				<i class="fab fa-lg fa-cc-paypal"></i>
				<i class="fab fa-lg fa-cc-mastercard"></i>
			</div>
		</section>
	</div><!-- //container -->
</footer>
