@extends('Home.homeLayout')

@section('content')
<div class="container-fluid text-center">

    <div class="card mt-4" style="max-width: 600px; margin: auto;">
        <h3 class="mt-2 mb-0">Contact Us</h3>
        <div class="card-body">
            <p class="lead">
                We would love to hear from you! Reach out to us with any questions or concerns.
            </p>

            <h6 class="mt-4">Get in Touch</h6>
            <p>
                <i class="fas fa-phone-alt"></i> <strong>Phone:</strong> +8801711355858<br>
                <i class="fas fa-envelope"></i> <strong>Email:</strong> <a href="mailto:nujhattanzim@gmail.com?subject=Inquiry&body=Hello," style="font-size: 1.2em;">ayshi@gmail.com</a>
            </p>

            <h6 class="mt-4">Our Location</h6>
            <p>
                123 Car Rental Ave,<br>
                City, State, Zip Code<br>
                Country
            </p>

            <h6 class="mt-4">Follow Us</h6>
            <p>
                <a href="https://www.facebook.com" class="btn btn-primary btn-lg"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="https://www.instagram.com" class="btn btn-danger btn-lg"><i class="fab fa-instagram"></i> Instagram</a>
            </p>
        </div>
    </div>
</div>
@endsection