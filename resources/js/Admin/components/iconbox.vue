<template>
    <div style="display: flex; flex-direction: row" class="mt-2 inputs" v-for="(item, index) in inputCounter" :id="'input_'+item['id']">
        <drop-down :elements="elements" :selected="item['icon']" :name="'icon_'+item['id']"></drop-down>
        <input type="text" class="form-control ms-2" placeholder="Текст" :value="item['text']" :name="'places_'+item['id']" :id="'places_'+item['id']">
        <button class="btn btn-danger ms-2" type="button" v-on:click="removeInput(item['id'])">Удалить</button>
    </div>
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
        }
    },
    data() {
        return {
            inputCounter: this.selected
        }
    },
    methods: {
        addInput() {
            if(this.inputCounter.length == 0) {
                this.inputCounter.push({icon: null, text: null, id: 0})
            } else {
                this.inputCounter.forEach((item, index)=>{
                    let value = document.getElementById('places_'+item['id']).value
                    let icon = document.getElementById('input_'+item['id']).querySelector('.dropdown').querySelector('.dropdown-toggle').innerText
                    icon = icon.replace(/\s/g, '');
                    this.inputCounter[index]['text'] = value
                    this.inputCounter[index]['icon'] = icon
                })

                let lastIndex = this.inputCounter.length - 1
                let lastId = this.inputCounter[lastIndex]['id']

                this.inputCounter.push({icon: null, text: null, id: lastId + 1})
            }
        },
        removeInput(id) {
            this.inputCounter.forEach((item, index)=>{
                let value = document.getElementById('places_'+item['id']).value
                let icon = document.getElementById('input_'+item['id']).querySelector('.dropdown').querySelector('.dropdown-toggle').innerText
                icon = icon.replace(/\s/g, '');
                this.inputCounter[index]['text'] = value
                this.inputCounter[index]['icon'] = icon
            })
            this.inputCounter = this.inputCounter.filter(obj => obj.id != id);
            let a = this.inputCounter
            this.inputCounter = null
            setTimeout(()=>{
                this.inputCounter = a
            },0)
        }
    },
    mounted() {
        // this.inputCounter.forEach((item, index)=>{
        //     this.inputCounter[index]['id'] = index
        // })
        // console.log(this.inputCounter)
    }
}
</script>

<style scoped>

</style>
