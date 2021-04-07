<template>

    <footer class="bg-blue-600 text-red-50 text-center p-2">
        <p>&copy; Copyright &middot; Boutin Grégory &middot; {{this.date}}</p>
    </footer>

</template>

<script>

export default {
    name: 'Footer',
    data() {
        return {
            date: null,
        }
    },
    mounted() {
        const today = new Date()
        let month = today.getMonth() + 1
        month = (month < 10 ? "0" + month : month)
        this.date = month + ' / ' + today.getFullYear()
    }
}

</script>
