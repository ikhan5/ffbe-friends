<template>
  <div>
    <div class="container">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<style>
body {
  padding: 30px;
  background-color: #f8f8f8;
}

.container {
  width: 1200px;
  margin-top: 20px;
  background-color: white;
  padding: 20px;
}

.fade-enter-active {
  animation: fade-in 200ms ease-out forwards;
}

.fade-leave-active {
  animation: fade-out 200ms ease-out forwards;
}

@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes fade-out {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}
</style>

<script>
import Header from "./components/Header.vue";

export default {
  name: "app",
  components: {
    appHeader: Header
  }
};
</script>
