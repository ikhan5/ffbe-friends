<template>
  <header class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <router-link to="/" tag="a" active-class="active" class="navbar-brand">FFBE Friends</router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <router-link to="/" tag="a" active-class="active" class="nav-item nav-link mr-2" exact>All Units</router-link>
      </div>
       <div class="navbar-nav">
        <router-link to="/requests" tag="a" class="nav-item nav-link mr-2" exact>Request A Unit</router-link>
      </div>
      <div class="navbar-nav w-50 nav-cta">
        <router-link
          to="/unit/add"
          tag="button"
          class="btn btn-sm btn-outline-primary"
          exact
        >+ Add A Unit</router-link>
      </div>
      <div class="navbar-nav flex-row ml-md-auto d-md-flex user-options">
        <router-link
          to="/profile"
          tag="a"
          active-class="active"
          class="nav-item nav-link mr-2"
        >Your Profile</router-link>
        <a class="logout nav-item nav-link" href="/logout">Logout</a>
      </div>
    </div>
  </header>
</template>

<style scoped>
  @media only screen and (max-width: 600px) {
    .user-options{
      flex-direction: column !important;
    }

    .nav-cta{
     width: 100% !important;
    }
  }
</style>