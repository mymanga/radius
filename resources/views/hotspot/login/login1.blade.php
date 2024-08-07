<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>SleekSpot - Hotspot Login</title>
    <link href="{{ URL::asset('assets/hotspot/clean/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/login1.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <img id="logo" src="{{ URL::asset(setting('logo')) }}" alt="Company logo">
            <h1 class="navbar-brand">{{ strtoupper(setting('hotspotName')) }}</h1>
        </div>
        @if(session()->has('common_data'))
        @php
        $common_data = session()->get('common_data');
        @endphp
        <div class="form-input">
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onsubmit="return doLogin()" rel="noreferrer">
                <input type="hidden" name="dst" value="/status">
                <input type="hidden" name="popup" value="true">
                @if(!empty($common_data['error']))
                <div class="text-danger text-center">{{ $common_data['error'] }}</div>
                @endif
                <input type="text" class="form-control" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" required>
                <input name="password" type="hidden">
                <button class="btn-custom" type="submit">Connect</button>
            </form>
        </div>
        @endif
        <div class="footer">
            <p><b>Phone:</b> {{setting('company_phone')}}<br/>
               <b>Email:</b> {{setting('company_email')}}<br>
            </p>
        </div>
    </div>

    <script src="{{ URL::asset('assets/hotspot/clean/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/hotspot/clean/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/hotspot/clean/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/hotspot/clean/vibrant.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.getElementById('logo');
            const header = document.querySelector('.header');
            const navbarBrand = document.querySelector('.navbar-brand');
            const button = document.querySelector('.form-input button');

            if (logo.getAttribute('src')) {
                header.style.display = 'block';
                logo.style.display = 'block';
                navbarBrand.style.display = 'none';
                adjustColorScheme(logo, button);
            } else {
                header.style.display = 'block';
                logo.style.display = 'none';
                navbarBrand.style.display = 'block';
            }
        });

        function adjustColorScheme(logo, button) {
            const img = new Image();
            img.src = logo.src;
            img.onload = function() {
                Vibrant.from(img).getPalette()
                    .then(palette => {
                        let primaryColor = '#ff7e5f'; // Default color if no vibrant color found
                        let secondaryColor = '#feb47b'; // Default secondary color

                        const swatches = Object.values(palette)
                            .filter(swatch => swatch)
                            .sort((a, b) => b.getPopulation() - a.getPopulation());

                        if (swatches.length > 0) {
                            primaryColor = swatches[0].getHex();
                        }
                        if (swatches.length > 1) {
                            secondaryColor = swatches[1].getHex();
                        }

                        document.querySelector('body').style.background = `linear-gradient(135deg, ${primaryColor} 50%, ${secondaryColor} 50%)`;
                        if (button) {
                            button.style.background = `linear-gradient(to right, ${primaryColor}, ${secondaryColor})`;
                            button.addEventListener('mouseover', () => {
                                button.style.background = `linear-gradient(to right, ${secondaryColor}, ${primaryColor})`;
                            });
                            button.addEventListener('mouseout', () => {
                                button.style.background = `linear-gradient(to right, ${primaryColor}, ${secondaryColor})`;
                            });
                        }
                    });
            }
        }
    </script>
    @include('hotspot.login.js.js')
</body>
</html>
