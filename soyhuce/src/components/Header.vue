<template>

    <header class="bg-blue-600 text-red-50 text-center text-3xl p-6">
        <h1>Bienvenue sur {{ title }}</h1>
    </header>

</template>

<script>

export default {
  name: 'Header',
  props: {
    title: String
  }
}

</script>
