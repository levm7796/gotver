<template>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Добавить
</button>

<!-- Модальное окно -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Добавить svg</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-4 position-relative">
            <label for="validationTooltip01" class="form-label">Ключ(латинецей)</label>
            <input type="text" class="form-control" id="validationTooltip01" value="asdf" v-model="id">
        </div>
        <div class="col-md-4 position-relative">
            <label for="validationTooltip01" class="form-label">Размер x</label>
            <input type="text" class="form-control" id="validationTooltip01" value="asdf" v-model="x">
            <label for="validationTooltip01" class="form-label">Размер Y</label>
            <input type="text" class="form-control" id="validationTooltip01" value="asdf" v-model="y">
        </div>
        <div class="mb-3">
            <label for="validationTextarea" class="form-label">Тело svg</label>
            <textarea class="form-control " id="validationTextarea" placeholder="Тело svg (path, g....)" v-model="body"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ref="close">Закрыть</button>
        <button type="button" class="btn btn-primary" @click="save">Вставить</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>

export default {
    props: [],
    name: "addSvg",
    data() {
        return {
            id: '',
            body: '',
            x: 20,
            y: 20,
        }
    },
    methods: {
        save() {
          let insertText = `
          <symbol id="${this.id}" viewBox="0 0 ${this.x} ${this.y}">${this.body}</symbol>`
          this.id = ''
          this.body = ''
          let txt = document.querySelector('#content')
          let newTxt = txt.value.replace(/<\/svg>/, `${insertText}</svg>`);
          txt.value = newTxt
          this.$refs.close.click()
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
