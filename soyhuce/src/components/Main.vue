<template>

    <main role="main" class="text-center mt-10 m-auto">
		<p class="p-2">
			Ici vous pouvez télécharger des photos depuis votre ordinateur,<br>
			vous pouvez modifier leurs apparences grâce à des filtres ( black & white, et sépia ),<br>
			vous pouvez aussi redimensionner et/ou recadrer vos images,<br>
			leurs donner un nouveau nom et enfin les récupérés sur votre ordinateur.
		</p>
        <div class="mx-20">
            <UploadForm></UploadForm>
            <ModifyFile></ModifyFile>
            <DisplayFiles></DisplayFiles>
        </div>
    </main>

</template>

<script>

import UploadForm from './UploadForm.vue'
import DisplayFiles from './DisplayFiles.vue'
import ModifyFile from './ModifyFile.vue'

export default {
    name: 'Main',
    components: {
        UploadForm,
        DisplayFiles,
        ModifyFile
    }
}

</script>

