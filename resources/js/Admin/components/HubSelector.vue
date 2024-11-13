<template>
    <div class="form-group mt-3 col-sm-10">
        <label class="control-label col-sm-2">Хабовая:</label>
        <select class="form-select col-sm-10" v-model="sel" @change="handleChange" :name="name">
            <option :value="null" disabled>Выбрать</option>
            <option v-for="el in elements.filter(element => element.location_id == this.$store.getters.getSelectedLocation)" :key="el.id" :value="el.id">{{ el.name }}</option>
        </select>

        <!-- @if ($errors->has('order'))
            <span class="text-danger">{{ $errors->first('order') }}</span>
        @endif -->
    </div>
</template>
<script>
export default {
    props: ['elements', 'selected', 'name'],
    data() {
        return {
            sel: this.selected,
        }
    },
    methods: {

        handleChange(event) {
            const selectedValue = event.target.value;
            this.$store.commit('setSelectedHub', selectedValue);
        }

    },
    computed: {

    },
    mounted() {
        this.$store.commit('setSelectedHub', this.selected);
    },
    beforeDestroy() {
    }
}
</script>
