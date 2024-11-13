<template>
    <div class="form-group mt-3" style="width: 100%;">
        <label class="control-label col-sm-12" v-if="title">{{ title }}: <i class="btn bi bi-plus-circle" @click="add"></i></label>
        <div class="align-items-center col-sm-12 " :class="index > 0 ? 'mt-3' : ''" v-for="(item, index) in body" style="    margin-left: 20px;">
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseExample'+index" aria-expanded="false" aria-controls="collapseExample">
                Гуппа {{ index + 1 }}: {{ body[index].name }}
            </button>
            <div class="collapse" :id="'collapseExample'+index">
                <div class="col-auto">
                    <i class="btn bi bi-x-lg mr-3" style="margin-right: 10px;" @click="del(index)"></i>
                    <label class="control-label" for="inlineFormInput">Название</label>
                    <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Название" v-model="body[index].name">
                </div>
                <history-items :value="body[index].items" @updatee="val => body[index].items = val"></history-items>
            </div>
        </div>
        <i v-if="!title" class="bi bi-plus-circle" @click="add"></i>
    </div>
    <input type="hidden" :name="name" :value="JSON.stringify(body)">
</template>

<script>
export default {
    name: "history",
    props: ['old', 'title', 'name'],
    data() {
        return {
            body: this.old || []
        }
    },
    methods: {
        add(){
            this.body.push({name:'', items:[]})
        },
        del(index){
            this.body.splice(index, 1)
        },
    }
}
</script>

<style scoped>

</style>
