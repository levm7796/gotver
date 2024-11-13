<template>
<div id="blocks">
    <div class="form-group mt-5">
        <h5 class="control-label col-sm-2">Блоки:</h5>
        <button @click="addItem()" type="button" class="btn btn-success ml-3">Добавить блок</button>
        <div class="form-group mt-2 ml-3 bg-light rounded-1 w-75 p-2" :id="'block_'+data" v-for="(block, index) in blocks">
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="ml-3 mr-3">
                    <input type="text" class="form-control w-100" v-model="blocks[index].title">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Описание:</label>
                <div class="ml-3 mr-3">
                    <textarea class="editor" descr-block :ref="'editor' + index" :class=" 'editor-'+index "></textarea>
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3 img">
                    <!-- <input type="file" id="blockImg" :name="'blockImg_'+data" class="border-0"/> -->
                    <new-image :max="1" :x="870" :y="500" :name="'none'" :data="[blocks[index].img]" type="1" @updateImages="val => blocks[index].img = val?.normal?.[0]"></new-image>
                </div>
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Подпись:</label>
                <div class="ml-3 mr-3">
                    <input type="text" class="form-control" placeholder="Текст" v-model="blocks[index].signature">
                </div>
            </div>

            <button type="button" @click="removeItem(index)" class="btn btn-danger mt-3">Delete</button>

        </div>
        <input type="hidden" :name="'blocks'" :value="JSON.stringify(blocks)">
    </div>
</div>
</template>
<script>
export default {
    name: "newsBlocks",
    props: ['data', 'type'],
    data() {
        return {
            blocks: this.data || [{}],
            items: {},
            blockCounter: 0,
            blockId: 0,
            asdfg: '',
        }
    },
    mounted(){
        this.onInit();
    },
    methods: {
        onInit(){
            try{
                this.initializeEditor()
            }catch($err){
                setTimeout(()=>{
                    this.onInit()
                }, 100)
            }
        },
        addItem(){
            console.log(typeof $.fn.froalaEditor);
            this.blocks.push({})
            this.$nextTick(() => {
                this.initializeEditor(this.blocks.length-1);
            });
        },
        removeItem(index){
            this.blocks.splice(index, 1)
            this.items.splice(index, 1)
        },
        cleanHtml(html) {
            console.log(1, html)
            // Создание DOMParser
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Получение всех элементов <p> с атрибутом data-f-id="pbf"
            const elements = doc.querySelectorAll('p[data-f-id="pbf"]');

            // Удаление найденных элементов из DOM
            elements.forEach(el => el.remove());

            // Сериализация документа обратно в строку
            console.log(2, doc.body.innerHTML.trim())
            return doc.body.innerHTML.trim();
        },
        initializeEditor() {
            $('.selectpicker').selectpicker();
            this.$nextTick(() => {
                this.blocks.forEach((item, index) => {
                    const editorRef = 'editor' + index;
                    const editorElement = this.$refs[editorRef][0]; // Получаем первый элемент из массива refs
                    if (typeof $ !== 'undefined') {
                        // Инициализация редактора
                        if(!this.items[index])
                            this.items[index] = {}
                        this.items[index].new = false;
                        if(!this.items[index].editor){
                            this.items[index].new = true;
                            let token = document.querySelector('[name="_token"]').value;
                            this.items[index].editor = new FroalaEditor(editorElement, {
                            // let froalaEditor = new FroalaEditor(editorElement, {
                                placeholderText: 'Текст...',
                                pastePlain: true,
                                imageUploadURL:'/admin/editor-upload',
                                imageUploadMethod:'POST',
                                imageUploadParams: {
                                    _token: token
                                },
                                events:{
                                    'image.beforeRemove': function ($img){

                                        const url = '/admin/editor-delete',
                                        params ={
                                            src: $img[0].src
                                        };

                                        fetch(url,{
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': token
                                            },
                                            body: JSON.stringify(params)
                                        })
                                        .then(response => {
                                            const reposList = response.json();
                                            console.log(reposList);
                                        })
                                        .catch(err => console.log(err))
                                    }
                                },


                                toolbarButtons: [
                                    ['undo', 'redo', "paragraphFormat", 'fontFamily', 'fontSize', 'bold', 'italic', 'underline', 'strikeThrough'],
                                    ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'textColor', 'backgroundColor'],
                                    ['formatOLSimple', 'formatUL', 'insertLink', 'insertImage', 'html'],
                                ],
                            });
                            // this.$set(this.items, index, { ...this.items[index], editor: froalaEditor });
                        }
                        setTimeout(()=>{
                            this.hideElementsWithStyle('z-index:9999;width:100%;position:relative');
                            this.hideElementsWithStyle('z-index:9999;width:100%;position:relative;');
                            this.hideElementsWithStyle('z-index:9999;position:relative;width:100%;');
                            this.hideElementsWithStyle('position:relative;width:100%;z-index:9999');
                            this.hideElementsWithStyle('width:100%;position:relative;z-index:9999');
                            // Установка начального текста
                            this.items[index].editor.html.set(this.blocks[index]?.description);

                            // Сохранение ссылки на редактор для последующего использования

                            // Отслеживаем изменения и обновляем модель данных

                            if(this.items[index].new == true) {
                                this.items[index].new = false;
                                this.items[index].editor.events.on('contentChanged', () => {
                                    this.blocks[index].description = this.cleanHtml(this.items[index].editor.html.get());
                                });
                            }
                        },500)
                    }
                });
            });
        },
        hideElementsWithStyle(style) {
            // Находим все элементы с указанным стилем
            const elements = document.querySelectorAll(`[style="${style}"]`);

            // Изменяем display для каждого найденного элемента
            elements.forEach(element => {
                element.classList.add('dontShow')
                element.remove()
                // element.style.display = 'none';
                // element.style.visibility = 'hidden';
                // element.style.height = '0';
            });
        }

    },
    watch: {
        blocks: {
            handler() {

            },
            deep: true
        }
    }
}
</script>
<style>
.fr-wrapper > div[style]:first-child, .dontShow{
    z-index: 9999 !important;
    width: 100% !important;
    position: relative !important;
    display: none !important;
    visibility: hidden !important;
    height: 0px !important;
}
</style>
