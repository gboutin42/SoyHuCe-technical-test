<template>

	<div class="bg-green-400 shadow-2xl rounded-xl mt-10 mx-6 text-center text-white p-5">

		<div class="mb-5">
			<h2 class="text-2xl underline">Importer vos images</h2>
		</div>

		<div class="p-5">
			<form>
				<div>
					<label for="image">Choisissez des Images</label>
					<input type="file" accept="image/*" id="image" name="image" ref="image" @change="handleFileObject()">
				</div>
				<button @click="submit" type="submit" class="opacity-50 cursor-not-allowed focus:outline-none text-sm py-2.5 px-5 rounded-md bg-green-600 mt-5">Importer</button>
			</form>
		</div>

	</div>

</template>

<script>

import axios from 'axios'

export default {
    name: 'UploadForm',
    data() {
        return {
            image: null,
            imageName: null,
        }
    },
    methods: {
        submit() {
            let formData = new FormData()
            formData.append('image', this.image)

            axios.post('http://localhost:8000/api/upload', formData, {
                headers: {
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then(response => {
                if (response.status == 200) {
                    console.log("file upload with code " + response.status)
                    this.displayFiles()
                }
            }).catch(err => {
                    console.log(err)
            })
        },
        handleFileObject() {
            this.image = this.$refs.image.files[0]
            if (this.image){
                this.imageName = this.image.name
                var button = document.getElementsByTagName('button')[0]
                button.classList.remove("opacity-50", "cursor-not-allowed")
                button.classList.add("hover:bg-green-800", "transform", "hover:scale-110", "hover:shadow-lg")
            }
        },
        displayFiles() {
            axios.get('http://localhost:8000/api/fileslist', {
                    headers: {
                        'Content-Type': "image/*"
                    }
            }).then(response => {
                this.data = response.data.result
            }).catch(function(err) {
                console.log(err)
            })
        }
    }
}
</script>
