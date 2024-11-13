<template>
    <div id="tagsbox">
        <div class="form-group mt-3 col-sm-12">
            <label class="control-label">{{ lable ? lable : 'Тэги:' }}</label>
            <div class="col-sm-10">
                <div>
                    <template v-for="(vl, index) in myValue">
                        <button type="button" class="btn btn-outline-danger" @click="remove2(vl)" style="padding: 0 3px;margin: 3px;">
                            {{ idObject()?.[vl]?.content || idObject()?.[vl]?.name }}
                        </button>
                    </template>
                </div>
                <div v-if="data.all !== undefined">
                    <select :class="['selectpicker', 'tagsbox-'+classNumber]" multiple data-live-search="true" :name="hiddenData ? 'none' : (name ? name : 'optionIds[]')" v-model="selection">
                        <option v-for="tag in data.all" :class="'option-'+tag.id+'-'+classNumber" :value="tag.id">{{tag?.content || tag.name}}</option>
                    </select>
                </div>
                <div v-else>
                    <select :class="['selectpicker', 'tagsbox-'+classNumber]" multiple data-live-search="true" :name="hiddenData ? 'none' : (name ? name : 'optionIds[]')" v-model="selection">
                        <option v-for="tag in data" :value="tag.id">{{ tag?.content || tag.name}}</option>
                    </select>
                </div>
                <!-- <input type="hidden" :name="!hiddenData ? 'none' : (name ? name : 'optionIds[]')" :value="JSON.stringify(myValue)"> -->
                <template v-for="(val, index) in myValue" :key="index">
                    <input type="hidden" :name="!hiddenData ? 'none' : (name ? name : 'optionIds[]')" :value="val" >
                </template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "tagsbox",
    props: ['data', 'lable', 'name', 'hiddenData'],
    data() {
        return{
            myValue: this.data?.old?.map(i => Number(i)) || [],
            selection: this.data?.old?.map(i => Number(i)) || null,
            classNumber: Math.floor(Math.random() * 900) + 100.
        }
    },
    mounted() {
        // console.log(this.data)
        try {
            $('.tagsbox'+this.classNumber).val(this.data.old);
        } catch (e) {
            console.warn('tagsbox',e)
        }
    },
    methods: {
        add(value) {
            if (!this.myValue.includes(value)) {
                this.myValue.push(value);
            }
        },
        remove(value) {
            const index = this.myValue.indexOf(value);
            if (index !== -1) {
                this.myValue.splice(index, 1);
            }

        },
        remove2(value) {
            // document.querySelector('.option-'+value+'-'+this.classNumber).click()
            const index = this.myValue.indexOf(value);
            console.log(value, index)
            if (index !== -1) {
                this.myValue.splice(index, 1);
            }
            const index2 = this.selection.indexOf(value);
            if (index2 !== -1) {
                this.selection.splice(index2, 1);
            }
            $('.tagsbox'+this.classNumber).val(this.myValue);
        },
        idObject(){
            // console.log("data",this.data?.all, this.data)
            return (this.data?.all || this.data).reduce((acc, item) => {
                acc[item.id] = item;
                return acc;
            }, {});
        },
    },
    watch: {
        selection(newValues, oldValues) {
            const added = newValues?.filter(value => !oldValues?.includes(value)) || [];
            const removed = oldValues?.filter(value => !newValues?.includes(value)) || [];

            if (added.length > 0) {
                console.log('Added:', added);
                this.add(added[0])
            }
            if (removed.length > 0) {
                console.log('Removed:', removed);
                this.remove(removed[0])
            }

            // this.previousSelectedValues = [...newValues];
        }
    },
}
</script>

<style >
select {
    width: 30em;
}
.dropdown-toggle{
    height: 40px;
}
</style>


