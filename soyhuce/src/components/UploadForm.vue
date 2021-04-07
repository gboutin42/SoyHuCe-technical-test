<template>

	<div class="bg-green-400 shadow-2xl rounded-xl mt-10 mx-6 text-center text-white p-5">

		<div class="mb-5">
			<h2 class="text-2xl underline">Importer vos images</h2>
		</div>

		<div class="p-5">
			<form>
				<div>
					<label for="image">Choisissez des Images</label>
					<input type="file" accept="image/*" multiple="multiple" id="image" name="image" ref="image" @change="handleFileObject()">
				</div>
				<button @click="submit" type="submit" class="focus:outline-none text-sm py-2.5 px-5 rounded-md bg-green-600 hover:bg-green-800 transform hover:scale-110 hover:shadow-lg mt-5">Importer</button>
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
            imageName: null
        }
    },
    methods: {
        submit() {
            let formData = new FormData()
            formData.append('image', this.image)
            for (var value of formData.values())
                console.log(value)
            axios.post('http://localhost:80/SoyHuCe-technical-test/public/api/upload', formData, {
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
            this.imageName = this.image.name
        },
        displayFiles() {
            axios.get('http://localhost:80/SoyHuCe-technical-test/public/api/fileslist', {
                headers: {
                    'Content-type': 'application/json',
                }
            }).then(response => {
                this.data = response.data.result
                console.log(this.data)
            }).catch(function(err) {
                console.log(err)
            })
        }
    }
}
</script>
