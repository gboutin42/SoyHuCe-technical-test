<template>

  <div id="app" class="bg-red-50 text-blue-600 flex flex-col min-h-screen">

	<Header title="SoyHuCe technical test"/>
    <Main></Main>
	<Footer></Footer>

  </div>

</template>

<script>

import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import Main from './components/Main.vue'

export default {
  name: 'App',
  components: {
	Header,
	Footer,
    Main
  }
}

</script>

