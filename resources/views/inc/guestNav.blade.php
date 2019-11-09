<header class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <router-link to="/" tag="a" active-class="active" class="navbar-brand">FFBE Friends</router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <router-link to="/" tag="a" active-class="active" class="nav-item nav-link" exact>All Units</router-link>
        </div>
        <div class="navbar-nav flex-row ml-md-auto d-md-flex ">
            <a class="nav-item nav-link mr-2" href="{{ route('login') }}">Login</a>
            <a class="nav-item nav-link" href="{{ route('register') }}">Register</a>
        </div>
    </div>
</header>
