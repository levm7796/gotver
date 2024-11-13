<!--<template>-->
<!--<textarea type="text" class="editor" :placeholder="placeholder" :name="name" :value="value"></textarea>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--name: "Froala",-->
<!--    props: ['name', 'value', 'placeholder'],-->
<!--    data() {-->
<!--        return {-->
<!--            editor: '',-->
<!--            editorText: '',-->
<!--        }-->
<!--    },-->
<!--    mounted(){-->
<!--        this.onInit();-->
<!--    },-->
<!--    methods: {-->
<!--        onInit() {-->
<!--            try {-->
<!--                this.initializeEditor()-->
<!--            } catch ($err) {-->
<!--                setTimeout(() => {-->
<!--                    this.onInit()-->
<!--                }, 100)-->
<!--            }-->
<!--        },-->
<!--        initializeEditor() {-->
<!--            this.editor = new FroalaEditor('.editor', {-->
<!--                pastePlain: true-->
<!--            });-->

<!--            this.editor.events.on('contentChanged', (value) => {-->
<!--                this.editorText = value-->
<!--            })-->

<!--            setTimeout(()=>{-->
<!--                this.hideElementsWithStyle('z-index:9999;width:100%;position:relative');-->
<!--                this.hideElementsWithStyle('z-index:9999;width:100%;position:relative;');-->
<!--                this.hideElementsWithStyle('z-index:9999;position:relative;width:100%;');-->
<!--                this.hideElementsWithStyle('position:relative;width:100%;z-index:9999');-->
<!--                this.hideElementsWithStyle('width:100%;position:relative;z-index:9999');-->
<!--                // Установка начального текста-->
<!--                this.editor.html.set(this.editorText);-->

<!--                // Сохранение ссылки на редактор для последующего использования-->

<!--                // Отслеживаем изменения и обновляем модель данных-->

<!--                    this.items[index].editor.events.on('contentChanged', () => {-->
<!--                        this.blocks[index].description = this.cleanHtml(this.items[index].editor.html.get());-->
<!--                    });-->
<!--            },500)-->
<!--        },-->
<!--    }-->
<!--}-->
<!--</script>-->

<!--<style scoped>-->

<!--</style>-->


<template>
            <div :id="'block_'+data" v-for="(block, index) in blocks">
                <textarea class="editor" descr-block :ref="'editor' + index" :class=" 'editor-'+index "  :value="value"></textarea>
            </div>
           <input type="hidden" :name="name" :value="value2">
</template>
<script>
export default {
    name: "newsBlocks",
    props: ['data', 'type', 'name', 'placeholder', 'value'],
    data() {
        return {
            blocks: this.data || [{}],
            items: {},
            blockCounter: 0,
            blockId: 0,
            value2: this.value,
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
                                placeholderText: this.placeholder,
                                pastePlain: true,
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
                                    ['undo', 'redo',  "paragraphFormat", 'fontFamily', 'fontSize', 'bold', 'italic', 'underline', 'strikeThrough'],
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
                            this.items[index].editor.html.set(this.value);

                            // Сохранение ссылки на редактор для последующего использования

                            // Отслеживаем изменения и обновляем модель данных

                            if(this.items[index].new == true) {
                                this.items[index].new = false;
                                this.items[index].editor.events.on('contentChanged', () => {
                                    // this.blocks[index].description = this.cleanHtml(this.items[index].editor.html.get());
                                    this.value2 = this.cleanHtml(this.items[index].editor.html.get());
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
                element.style.display = 'none';
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
