<template>
    <div class="form-group mt-3" style="margin-top:15px;margin-left:20px;    width: 100%;">
        <label class="control-label col-sm-12" v-if="title">{{ title }}: <i class="bi bi-plus-circle" @click="add"></i></label>
        <div class="form-row align-items-center col-sm-6" style="margin-bottom: 15px;" v-for="(link, index) in links">
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Текст</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend" v-if="withico">
                        <drop-down :elements="svgs" :selected="links[index].icon" @selecticon="val => links[index].icon = val"></drop-down>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Текст" v-model="links[index].name" @input="updateValue">
                </div>
            </div>
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInput">Ссылка</label>
                <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="/link" v-model="links[index].url" @input="updateValue">
            </div>
            <div class="col-auto">
                <i class="bi bi-x-lg" @click="del(index)"></i>
            </div>
        </div>
        <i v-if="!title" class="bi bi-plus-circle" @click="add"></i>
    </div>
    <input type="hidden" :name="name" :value="JSON.stringify(links)" @input="updateValue">
</template>

<script>
export default {
    name: "link-generator",
    props: ['svgs', 'old', 'withico', 'title', 'name'],
    data() {
        return {
            links: this.old || []
        }
    },
    methods: {
        add(){
            this.links.push({name:'', url:'', icon: 0 })
            this.updateValue()
        },
        del(index){
            this.links.splice(index, 1)
            this.updateValue()
        },
        updateValue(){
            this.$emit('links', this.links)
        }

    }
}
</script>

<style scoped>

</style>
