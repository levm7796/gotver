<template>
    <div class="form-group mt-2 ml-3 bg-light rounded-1 w-75 p-2" :id="'block_'+data">
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Название:</label>
            <div class="ml-3 mr-3">
                <input type="text" class="form-control w-100" placeholder="Название" :name="'blockName_'+data">
            </div>
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Описание:</label>
            <div class="ml-3 mr-3">
                <textarea class="editor" :name="'editordata_' + data"></textarea>
            </div>
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Изображение:</label>
            <div class="ml-3 mr-3 img">
                <!-- <input type="file" id="blockImg" :name="'blockImg_'+data" class="border-0"/> -->
                <new-image :x="870" :y="500" :name="'img'" :data="[]" type="1"></new-image>
            </div>
        </div>


        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Подпись:</label>
            <div class="ml-3 mr-3">
                <input type="text" class="form-control" placeholder="Текст" :name="'blockSignature_'+data">
            </div>
        </div>

        <button type="button" @click="remove(data)" class="btn btn-danger mt-3">Delete</button>

        <input type="hidden" :name="'blockId_'+data" :value="data">
    </div>
</template>

<script>

export default {
    props: ['blockCounter', 'blockId'],
    name: "block",
    data() {
        return {
            data: this.blockCounter + this.blockId
        }
    },
    methods: {
        remove() {
            document.getElementById('block_'+this.data).remove()
        }
    },
    mounted() {
        let token = document.querySelector('[name="_token"]').value;
        new FroalaEditor('.editor', {
            placeholderText: 'Текст...',
            // imageUploadURL:'/support-app/public/upload',
            // imageUploadMethod:'POST',
            // imageUploadParams: {
            //     _token: token
            // },
            // toolbarButtons: [
            //     ['fontSize', 'bold'],
            //     [ 'alignLeft'],
            //     ['formatOLSimple'],
            // ],
        })
    }
}
</script>

<style scoped>

</style>
