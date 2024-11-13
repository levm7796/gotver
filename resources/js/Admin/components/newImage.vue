<template>
    <div id="hotelImage">
            <input type="file" ref="fileinput" @change="changeInput" @cancel="cancelInput" multiple style="display: none"/>
            <input type="text" :name="name || 'imgs'" style="display: none" :value="inputObject?.[0]"/>
            <input type="text" v-if="name2" :name="name2" style="display: none" :value="inputObject2?.[0]"/>
            <!-- <input type="text" ref="oldImgs" name="oldImgs" style="display: none" :value="oldImgs"/> -->
        <div :id="'inputImage_'+index" class="mt-2" v-for="(url, index) in minisecond ?  inputObject2 : inputObject">
<!--            <p>{{url}}</p>-->
            <img :src="url" class="mb-2" style="max-width: 100%;"> <br>
<!--            <button class="btn btn-success me-1" type="button" v-on:click="insertInput(item.id)">Добавить</button>-->
            <button v-if="(minisecond ? inputObject2.length : inputObject.length) > 1" class="btn btn-secondary me-1" type="button" v-on:click="replaceInput(index, 1)"><i class="bi bi-chevron-up"></i></button>
            <button v-if="(minisecond ? inputObject2.length : inputObject.length) > 1" class="btn btn-secondary me-1" type="button" v-on:click="replaceInput(index, 0)"><i class="bi bi-chevron-down"></i></button>
            <button class="btn btn-primary me-1" type="button" v-on:click="insertInput(index)">Редактировать</button>
            <button class="btn btn-danger" v-on:click="deleteInput(index)" type="button">Удалить</button>
        </div>
        <button v-if="((minisecond ? inputObject2.length : inputObject.length) < max || !max)" class="btn btn-success mt-2" type="button" v-on:click="addInput()" id="addButton"><i class="bi bi-plus"></i></button>
    </div>
</template>

<script>
export default {
name: "newImage",
    props: ['method', 'data', 'name', 'x', 'y', 'type', 'max', 'andthumb', 'x2', 'y2', 'name2', 'data2', 'minisecond'],
    data() {
        return {
            inputObject: this.data?.filter(item => !!item) || [],
            inputObject2: this.data2?.filter(item => !!item) || [],
            // oldImgs: this.data,
            currentIndex: null,
        }
    },
    methods: {
        addInput() {

            this.$refs.fileinput.click()
        },
        deleteInput(index) {
            // console.log(this.inputObject.splice(index, 1))
            // console.log(index)
                this.inputObject.splice(index, 1)
                this.inputObject2.splice(index, 1)
            // console.log(this.inputObject)
                // this.$refs.imgs.value = this.inputObject
                // if(this.oldImgs[index] !== null) {
                //     this.oldImgs.splice(index, 1)
                //     this.$refs.oldImgs.value = this.oldImgs
                // }
            this.$emit('updateImages', {'normal' : this.inputObject, 'thumb' : this.inputObject2})
        },
        replaceInput(index, method) {
            if(method === 1) {
                if(this.inputObject[index - 1]) {
                    let a = this.inputObject[index - 1]
                    this.inputObject[index - 1] = this.inputObject[index]
                    this.inputObject[index] = a
                }
            } else {
                if(this.inputObject[index + 1]) {
                    let a = this.inputObject[index + 1]
                    this.inputObject[index + 1] = this.inputObject[index]
                    this.inputObject[index] = a
                }
            }
            this.$emit('updateImages', {'normal' : this.inputObject, 'thumb' : this.inputObject2})
        },

        // inputObjectUpdate() {
        //     for(let index = 1; index<=this.inputCounter; index++) {
        //         this.inputObject[index] = document.getElementById('inputImage_'+index)
        //     }
        //     console.log(this.inputObject)
        // },

        changeInput(event) {
            if(document.getElementById('addButton')){
                document.getElementById('addButton').disabled = true
                document.getElementById('addButton').innerHTML = '<i class="bi bi-hourglass"></i>'
            }
            let push = false;
            if(this.currentIndex == null){
                push = true;
                this.currentIndex = this.inputObject.length
            }
            // if(event.target.files.length == 0) {
            //
            // }
            let csrf = document.querySelector('meta[name="csrf-token"]').content;
            const data = new FormData()

            data.append('file', event.target.files[0])
            data.append('x', this.x || 10)
            data.append('x2', this.x2 || 10)
            data.append('y', this.y || 10)
            data.append('y2', this.y2 || 10)
            data.append('type', this.type || 0)
            data.append('andthumb', this.andthumb || 0)
            if(this.method)
                data.append('meth', this.method)

            axios.post(`/news/image`, data, {
                headers: {
                    'X-CSRF-Token': csrf,
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res=>{
                // if(push)
                //     this.inputObject.push('')
                this.inputObject[this.currentIndex] = res.data.first
                if(this.andthumb){
                    // if(push)
                    //     this.inputObject2.push('')
                    this.inputObject2[this.currentIndex] = res.data.second
                }
                // this.$refs.imgs.value = this.inputObject
                if(document.getElementById('addButton')){
                    document.getElementById('addButton').disabled = false
                    document.getElementById('addButton').innerHTML = '<i class="bi bi-plus"></i>'
                }
                this.$emit('updateImages', {'normal' : this.inputObject, 'thumb' : this.inputObject2})
            }).finally(()=>{
                this.$refs.fileinput.value = ''; // Сброс состояния инпута
                this.cancelInput()
                this.currentIndex = null;
            })
        },

        cancelInput(data) {
            console.log('cancel', data)
            // this.inputObject.splice(this.inputObject.length - 1, 1)
            if(document.getElementById('addButton')){
                document.getElementById('addButton').innerHTML = '<i class="bi bi-plus"></i>'
                document.getElementById('addButton').disabled = false
            }
        },

        insertInput(index) {
            console.log('insert')
            if(document.getElementById('addButton')){
                document.getElementById('addButton').disabled = true
                document.getElementById('addButton').innerHTML = '<i class="bi bi-hourglass"></i>'
            }
            this.currentIndex = index
            this.$refs.fileinput.click()
        },
        // importImg(name) {
        //     if(name !== null) {
        //         return new URL('/public/images/'+name, 'http://localhost:8000/')
        //     }
        //     // return require('/public/images/'+name)
        // }
    },
    mounted() {
        return
        this.oldImgs.forEach(i=>{
            this.inputObject.push(i)
        })
        // setTimeout(()=>{
        //     this.$refs.imgs = this.inputObject
        //     this.$refs.oldImgs = this.oldImgs
        // }, 10)
        // console.log(this.$refs.oldImgs.value)
        if(this.inputObject.length >= 1 && typeof this.inputObject === Array) {
            this.$refs.oldImgs.value = this.inputObject
            this.$refs.imgs.value = this.inputObject
            let csrf = document.querySelector('meta[name="csrf-token"]').content;

            axios.post(`/news/deleteImages`, {
                headers: {
                    'X-CSRF-Token': csrf,
                    'Content-Type': 'multipart/form-data'
                }
            })
            this.inputObject.forEach(imgName=>{

                const data = new FormData()
                data.append('file', imgName)
                data.append('x', this.x || 10)
                data.append('y', this.y || 10)
                data.append('type', this.type || 0)
                axios.post(`/news/image`, data, {
                    headers: {
                        'X-CSRF-Token': csrf,
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res=>{
                    console.log(res)
                })
            })
        }
    },
}

</script>

<style scoped>

</style>
