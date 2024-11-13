<template>
    <div id="blocks">
        <div class="form-group mt-5">
            <h5 class="control-label col-sm-2">Блоки:</h5>
            <button @click="add()" type="button" class="btn btn-success ml-3">Добавить блок</button>
            <div class="blocks mt-4">
        <div class="form-group mt-2 ml-3 bg-light rounded-1 w-75 p-2" v-if="blocks !== null" v-for="block in blocks" :id="'block_'+block.id">
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="ml-3 mr-3">
                    <input type="text" class="form-control w-100" placeholder="Название" :value="block.name" :name="'blockName_'+block.id">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Описание:</label>
                <div class="ml-3 mr-3">
                    <textarea class="editor" :name="'editordata_' + block.id" v-if="typeof block.description !== null" v-html="block.description"></textarea>
                    <textarea class="editor" :name="'editordata_' + block.id" v-else></textarea>
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3 img">
                    <input type="file" :name="'blockImg_'+block.id" class="border-0"/>
                    <input type="hidden" :value="block.img" :name="'blockOldImg_'+block.id">
                    <!-- <new-image :x="870" :y="500" :name="'img'" :data="[block.img]" type="1"></new-image> -->
                    <img :src="'http://localhost:8000/images/' + block.img" alt="">
                </div>
            </div>


            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Подпись:</label>
                <div class="ml-3 mr-3">
                    <input type="text" class="form-control" placeholder="Текст" :value="block.signature" :name="'blockSignature_'+block.id">
                </div>
            </div>
            <button type="button" @click="remove(block.id)" class="btn btn-danger mt-3">Delete</button>
            <input type="hidden" :name="'blockId_'+block.id" :value="block.id">
        </div>

        <block :blockCounter="index" :blockId="blockId" class="block" v-for="index in blockCounter"></block>

            </div>
        </div>
    </div>
</template>

<script>
// import FroalaEditor from "froala-editor";
import block from "./block";

export default {
    name: "blocks",
    props: ['data', 'type'],
    data() {
        return {
            blocks: this.data,
            blockCounter: 0,
            blockId: 0
        }
    },
    components: {
        'block': block
    },
    mounted() {
            if(this.blocks !== undefined && this.blocks.length) {
                console.log(this.blocks)
                this.blockId = this.blockId + this.blocks[this.blocks.length - 1].id
            } else {
                this.blockCounter = 1
            }
            new FroalaEditor('.editor', {placeholderText: 'Текст...', pastePlain: true})
    },
    methods: {
        add() {
            this.blockCounter++
        },
        remove(id) {
            document.getElementById('block_'+id).remove()
        }
    }
}

</script>

<style scoped>

</style>
