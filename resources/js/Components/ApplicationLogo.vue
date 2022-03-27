<template>
  <div class="application-logo">
    <img
      src="/img/logo-lg.svg"
      alt="logo"
      class="logo hidden xs:hidden sm:hidden md:hidden lg:block max-h-11 max-w-md"
    />
    <!-- <img src="/img/logo-md.svg " alt="logo" class="logo md:block hidden" /> -->
    <!-- <img
      src="/img/logo-sm.svg "
      alt="logo"
      class="logo hidden sm:block lg:hidden max-h-10"
    /> -->
    <!-- <img src="/img/logo-xs.svg " alt="logo" class="logo hidden-xs-and-up" /> -->
    <img
      src="/img/logo.svg"
      alt="logo"
      class="logo block lg:hidden max-h-11"
    />
  </div>
</template>

<style>
.application-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}

.logo {
  width: 100%;
  height: auto;
}
</style>