{{-- @section('footer') --}}
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <!-- Contact Info -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <p class="mb-2"><i class="fas fa-envelope"></i> <a href="mailto:bps3573@gmail.com" class="hover:underline">bps3573@gmail.com</a></p>
                    <p class="mb-2"><i class="fas fa-phone-alt"></i> <a href="tel:+6281250003573" class="hover:underline">0812 5000 3573</a></p>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Janti Barat 47, Kota Malang, Indonesia</p>
                </div>

                <!-- Links -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-lg font-semibold mb-4">Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}" class="hover:underline">Home</a></li>
                        <li><a href="{{ url('/about') }}" class="hover:underline">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" class="hover:underline">Contact</a></li>
                        <li><a href="{{ url('/privacy-policy') }}" class="hover:underline">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms-of-service') }}" class="hover:underline">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="w-full md:w-1/3">
                    <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com/yourpage" target="_blank" class="text-white hover:text-gray-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/yourprofile" target="_blank" class="text-white hover:text-gray-400"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/yourprofile" target="_blank" class="text-white hover:text-gray-400"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com/in/yourprofile" target="_blank" class="text-white hover:text-gray-400"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-4 text-center text-sm">
                <p>&copy; 2024 Badan Pusat Statistik Kota Malang. All rights reserved.</p>
            </div>
        </div>
    </footer>
{{-- @endsection --}}
