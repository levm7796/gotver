<template>
    <div class="form-group mt-3">
        <label class="control-label col-sm-2">{{ title }}: <i class="bi bi-plus-circle" @click="add"></i></label>
        <div class="form-row align-items-center col-sm-12 mt-3" style="margin-top:15px; margin-left:20px;" v-for="(link, index) in body" :key="index">
            <div class="form-row" style="width: 100%;display: flex;align-items: center;">
                <div class="col-auto col-sm-10">
                    <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Название списка" v-model="body[index].name" >
                </div>
                <div class="col-auto col-sm-2">
                    <i class="bi bi-x-lg" @click="del(index)"></i>
                </div>
            </div>
            <link-generator class="width: 100%;" :old="link?.list" @links="data => body[index].list = data"></link-generator>
        </div>
    </div>
    <input type="hidden" :name="name" :value="JSON.stringify(body)" @input="updateValue">
</template>

<script>
export default {
    name: "menu-links",
    props: ['old',  'title', 'name'],
    data() {
        return {
            body: this.old || []
        }
    },
    methods: {
        add(){
            this.body.push({name:'', list:[] })
        },
        del(index){
            this.body.splice(index, 1)
        },

    }
}
</script>

<style scoped>

</style>
