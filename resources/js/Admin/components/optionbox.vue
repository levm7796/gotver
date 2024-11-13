<template>
    <div id="optionbox">
        <div class="form-group mt-3">
            <label class="control-label ms-3">Опции:</label>
            <div class="col-sm-10">
                <div v-if="data.allOption !== undefined">
                    <select class="selectpicker" multiple data-live-search="true" name="optionIds[]">
                        <option v-for="tag in data.allOption" :value="tag.id">{{tag.content}}</option>
                    </select>
                </div>
                <div v-else>
                    <select class="selectpicker" multiple data-live-search="true" name="optionIds[]">
                        <option v-for="tag in data" :data-content="`<svg width='16' height='16' aria-hidden='true'><use xlink:href='/img/sprite.svg#`+tag.ico+`'></use></svg>` + tag.content" :value="tag.id">{{tag.content}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "optionbox",
    props: ['data'],
    mounted() {
        try {
            $('.selectpicker').val(this.data.oldOption);
        } catch (e) {
            console.log(e)
        }
    }
}
</script>

<style scoped>
select {
    width: 30em;
}
</style>


