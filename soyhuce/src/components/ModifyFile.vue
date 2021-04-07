<template>

    <div v-if="this.source" class="bg-green-400 shadow-2xl rounded-xl mt-10 mx-6 text-center text-white p-5">

        <h1 class="mb-5 text-3xl underline">{{this.shortName}}</h1>

        <img :src="source" :name="shortName" :alt="nameWithExtension" :class="this.filterResult" width="1024">

        <div class="flex flex-row">

            <section class="mx-auto mt-3 text-left flex flex-col">
                <h3 class="text-center">Filtres</h3>
                <label for="none" class="space-x-2">
                    <input type="radio" name="filter" v-on:change="updateFilter" id="none" value="none" checked>
                    <span>Aucun</span>
                </label>
                <label for="sepia" class="space-x-2">
                    <input type="radio" name="filter" v-on:change="updateFilter" id="sepia" value="sepia">
                    <span>Sépia</span>
                </label>
                <label for="grayscale" class="space-x-2">
                    <input type="radio" name="filter" v-on:change="updateFilter" id="grayscale" value="grayscale">
                    <span>Noir et Blanc</span>
                </label>
            </section>

            <section class="mx-auto mt-3 text-center flex flex-col">
                <h3>Redimensionner</h3>
                <div  class="flex m-auto px-6">
                    <input type="range" step="1" name="range" id="range" class="bg-green-400 w-36">
                </div>
            </section>

            <section>
            </section>

        </div>

        <div class="flex">
            <button @click="save" class="mx-auto focus:outline-none text-sm py-2.5 px-5 rounded-md bg-green-600 hover:bg-green-800 transform hover:scale-110 hover:shadow-lg mt-5">Enregistrer</button>
            <button @click="download" class="mx-auto focus:outline-none text-sm py-2.5 px-5 rounded-md bg-green-600 hover:bg-green-800 transform hover:scale-110 hover:shadow-lg mt-5">Télécharger</button>
        </div>

    </div>

</template>

<script>

import axios from 'axios'

export default {
    name: 'ModifyFile',
    props: {
      source: String,
      show: Boolean,
    },
    data() {
        return {
            shortName: null,
            nameWithExtension: null,
            filterResult: "none",
        }
    },
    updated() {
        if (this.show) {
            this.nameWithExtension = this.source.split('/').pop()
            this.shortName = this.nameWithExtension.split('.')[0]
        }
    },
    methods: {
        updateFilter: function(event) {
            this.filterResult = document.getElementById(event.srcElement.id).value
        },
        save() {
            let formData = new FormData()
            formData.append('name', this.nameWithExtension)
            formData.append('filter', this.filterResult)
            axios.post('http://localhost:80/SoyHuCe-technical-test/public/api/updatefilter', formData, {
                headers: {
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then(response => {
                if (response.status == 200) {
                    console.log("file update with code " + response.status)
                    // this.displayFiles()
                }
            }).catch(err => {
                    console.log(err)
            })
        },
        download() {
            axios.get(
                "http://localhost:80/SoyHuCe-technical-test/public/api/downloadfile/" + this.nameWithExtension,{
                responseType: 'blob'
            }).then(response => {
                const type = response.headers['content-type']
                const blob = new Blob([response.data], {type: type, encoding: 'UTF-8'})

                const link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = this.shortName
                link.click()
            }).catch(err => {
                console.log(err)
            })
        }
    }
}

</script>

<style scoped>

    .sepia {
        filter: sepia(1)
    }
    .grayscale {
        filter: grayscale(1)
    }
    .none {
        filter: none
    }

    input[type=range] {
        -webkit-appearance: none;
        margin: 10px 0;
    }
    input[type=range]:focus {
        outline: none;
    }
    input[type=range]::-webkit-slider-runnable-track {
        height: 6px;
        cursor: pointer;
        box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
        background: rgba(37, 99, 235, var(--tw-text-opacity));
        border-radius: 25px;
        border: 0px solid #000101;
    }
    input[type=range]::-webkit-slider-thumb {
        box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
        border: 0px solid #000000;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        background: rgba(239, 68, 68, var(--tw-bg-opacity));
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -3.6px;
    }

</style>
