<template>
    <div class="form-group mt-3 container" style="width: 100%;margin-left: 20px;">
        <label class="control-label col-sm-12">Элементы: <i class="btn bi bi-plus-circle" @click="add"></i></label>
        <div class="align-items-center col-sm-12" :class="index > 0 ? 'mt-3' : ''" v-for="(item, index) in body">
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseItem'+index" aria-expanded="false" aria-controls="collapseExample">
                Элемент {{ index + 1 }}: {{ body[index].name }}
            </button>
            <div class="collapse" :id="'collapseItem'+index">
                <div class="col-auto">
                    <i class="btn bi bi-x-lg mr-3" style="margin-right: 10px;" @click="del(index)"></i>
                    <label class="control-label" for="inlineFormInput">Название</label>
                    <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Название" v-model="body[index].name">
                </div>
                <div class="col-auto">
                    <label class="control-label" for="inlineFormInput">Описание</label>
                    <textarea class="form-control mb-2" v-model="body[index].description"></textarea>
                </div>

                <div class="col-auto">
                    <new-image :method="'thumb'" :max="1" :x="456" :y="800" :x2="100" :y2="100" :type="2" :andthumb="1" :name="'none'" :data="body?.[index]?.img ? [body?.[index]?.img] : []" :data2="body?.[index]?.imgthumb ? [body?.[index]?.imgthumb] : []" @updateImages="updateImg(index, $event)"></new-image>
                </div>

                <div class="col-auto">
                    <label class="control-label" for="inlineFormInput">Текст кнопки(оставить пустым что бы скрыть)</label>
                    <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Перейти в напраление туризма" v-model="body[index].btn">
                </div>
                <div class="col-auto">
                    <label class="control-label" for="inlineFormInput">Ссылка</label>
                    <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="/location/1" v-model="body[index].url">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "historyItems",
    props: {
        value: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            body: [...this.value],
        }
    },
    methods: {
        add(){
            this.body.push({name: '', description: '', url: '', img: '', imgthumb: '', btn: ''})
        },
        del(index){
            this.body.splice(index, 1)
        },
        updateImg(index, val){
            console.log('images',val)
            this.body[index].img = val?.normal[0]
            this.body[index].imgthumb = val?.thumb[0]
        }
    },
    watch: {
        body: {
            deep: true,
            handler(newValue) {
                this.$emit('updatee', newValue);
            }
        },
        // value(newValue) {
        //     this.body = [ ...newValue ]; // Обновляем локальное состояние
        // }
    }
}
</script>

<style scoped>

</style>
