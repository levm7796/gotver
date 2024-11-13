<template>
    <div style="display: flex; flex-direction: row" class="mt-2 inputs" v-for="(item, index) in inputCounter" :id="'input_'+item['id']">
        <drop-down :elements="elements" :selected="item?.icon" @selecticon="val => inputCounter[index].icon = val"></drop-down>
        <input type="text" class="form-control ms-2" placeholder="Текст" v-model="inputCounter[index].place">
        <button class="btn btn-danger ms-2" type="button" v-on:click="removeInput(index)">Удалить</button>
    </div>
    <input type="hidden" :name="name || 'places'" :value="JSON.stringify(inputCounter)">
    <button class="btn btn-success mt-2" v-on:click="addInput()" type="button">+</button>
</template>

<script>
export default {
    name: "iconbox",
    props: {
        elements: {
            type: Array,
            default: ''
        },
        selected: {
            default: []
        },
        name:{

        },
    },
    data() {
        return {
            inputCounter: this.selected?.map(item => {
                                return {
                                    icon: item?.icon,
                                    place: item?.place || item?.text || item?.link || '' // Здесь мы переименовываем ключ text на place
                                };
                            }) || []
        }
    },
    methods: {
        addInput(){
            this.inputCounter.push({})
        },
        removeInput(index){
            this.inputCounter.spilce(index, 1)
        }
    },
}
</script>
