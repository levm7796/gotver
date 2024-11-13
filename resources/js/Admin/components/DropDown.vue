<template>
    <div class="dropdown">
        <button class="btn btn-outline-dark dropdown-toggle"  type="button" @click="toggleList()" aria-expanded="true">
            <svg width="24" height="24" aria-hidden="true">
                <use :xlink:href="'/img/sprite.svg#'+elements[current]"></use>
            </svg>
        </button>
        <ul ref="list" class="dropdown-menu" style="max-height: 350px;overflow: auto;display: block;" v-if="visible">
            <template v-for="(el, index) in elements">
                <li :style="current == index ? 'background: #dbf1d3;' : ''" style="cursor: pointer">
                    <a class="dropdown-item" @click="select(index)">
                        <svg width="24" height="24" aria-hidden="true">
                            <use :xlink:href="'/img/sprite.svg#'+el"></use>
                        </svg>
                        {{ el }}
                    </a>
                </li>
            </template>
        </ul>
    </div>
    <input type="hidden" :name="name" :value="elements[current]">
</template>
<script>
export default {
    props: ['elements', 'selected', 'name'],
    emits: ['selecticon'],
    data() {
        return {
            current: this.elements.indexOf(this.selected) !== -1 ? this.elements.indexOf(this.selected) : 0,
            visible: false,
        }
    },
    methods: {
        toggleList() {
            this.visible = !this.visible;
            if (this.visible) {
                setTimeout(()=>{
                    document.addEventListener('click', this.onClickOutside);
                },100)
            } else {
                document.removeEventListener('click', this.onClickOutside);
            }
        },
        select(i){
            this.current = i
            this.visible = false;
            this.$emit('selecticon', this.elements[i])
            document.removeEventListener('click', this.onClickOutside);
        },
        onClickOutside(event) {
            if (!this.$refs.list.contains(event.target)) {
                console.log('this.visible = false')
                this.visible = false;
                document.removeEventListener('click', this.onClickOutside);
            }
        },
    },
    computed: {

    },
    mounted() {

    },
    beforeDestroy() {
        document.removeEventListener('click', this.onClickOutside);
    }
}
</script>
<style scoped>
.btn-outline-dark:hover {
    color: #212529;
    background-color: #e0e0e0;
}
</style>
