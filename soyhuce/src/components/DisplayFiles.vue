<template>

    <div>
        <ModifyFile v-bind:source="this.source" v-bind:show="this.show"></ModifyFile>
        <ul v-if="this.data" class="grid grid-cols-3 gap-5">
            <li v-for="(data, i) in this.data" :key="i + data" class="text-center w-32 mx-auto my-5">
                <p contentEditable="true" :id="data.name" v-on:focusout="inputName" class="truncate transform hover:scale-150">{{data.name}}</p>
                <img :src="data.path" :alt="data.name">
                <button @click="modifyImage(data.path)" class="text-white w-32 focus:outline-none text-sm py-1.5 px-3 rounded-md bg-green-600 hover:bg-green-800 transform hover:scale-110 hover:shadow-lg mt-2">Modifier</button>
            </li>
        </ul>
    </div>

</template>

<script>

import axios from 'axios'
import ModifyFile from './ModifyFile.vue'

export default {
    name: 'DisplayFiles',
    components: {
        ModifyFile
    },
    data() {
        return {
            data: null,
            source: null,
            show: false,
        }
    },
    mounted() {
        console.log(this.$url)

        axios.get('http://localhost:80/SoyHuCe-technical-test/public/api/fileslist', {
            headers: {
                'Content-type': 'application/json',
            }
        }).then(response => {
            var data = []
            response.data.result.forEach(function(value, key) {
                var split = value.split('/')
                var name = split[split.length - 1].split('.')[0]
                data.push(
                    {
                        name: name,
                        path: "http://localhost:80/SoyHuCe-technical-test/storage/app/" + value,
                        button: "modifyImage_" + key
                    }
                )
            });
            this.data = data
        }).catch(function(err) {
            console.log(err)
        })
    },
    methods: {
        inputName: function(event) {
            var element = document.getElementById(event.srcElement.id)
            var oldName = element.nextSibling.nextSibling.getAttribute('src').split('/').pop()
            var extension = oldName.split('.').pop()
            var newName = element.innerText + "." + extension

            let formData = new FormData()
            formData.append('oldName', oldName)
            formData.append('newName', newName)

            axios.post('http://localhost:80/SoyHuCe-technical-test/public/api/updatename', formData, {
                headers: {
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then(response => {
                console.log(response)
            }).catch(err => {
                console.log(err)
            })
        },
        modifyImage(srcPath) {
            this.source = srcPath
            this.show = true
        }
    }
}

</script>
