<template>
    <div class="form-group mt-3">
      <label class="control-label col-sm-2">Телефон:</label>
      <div class="col-sm-10">
        <input
            type="text"
            class="form-control"
            placeholder="Телефон"
            :value="formattedPhone"
            @input="onInput"
            :name="name"
            maxlength="18"
        >
      </div>
      <span v-if="error" class="text-danger">{{ error }}</span>
    </div>
  </template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: 'phone'
    },
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      rawPhone: this.parsePhoneNumber(this.value.toString()) // Храним только цифры
    };
  },
  computed: {
    formattedPhone() {
      return this.formatPhoneNumber(this.rawPhone);
    }
  },
  methods: {
    // Убираем все нецифровые символы
    parsePhoneNumber(phone) {
      return phone?.toString()?.replace(/\D/g, '') || '';
    },
    // Форматируем номер телефона для отображения
    formatPhoneNumber(phone) {
      // Убираем все нецифровые символы
      phone = phone?.replace(/\D/g, '');

      // Форматируем по шаблону +_ (__) ___ __ __
      const format = '+_ (___) ___ __ __';

      let formatted = '';
      let index = 0;

      for (let char of format) {
        if (char === '_') {
          if (index < phone.length) {
            formatted += phone[index++];
          } else {
            break;
          }
        } else {
          formatted += char;
        }
      }

      return formatted;
    },
    onInput(event) {
      // Получаем значение ввода и убираем все нецифровые символы
      const rawValue = event.target?.value?.replace(/\D/g, '');

      this.rawPhone = rawValue; // Храним числовое значение
      this.$emit('input', rawValue); // Передаем очищенное значение (без форматирования)
    }
  },
  watch: {
    value(newValue) {
      this.rawPhone = this.parsePhoneNumber(newValue);
    }
  }
};
</script>

  <style scoped>
  /* Добавьте стили, если необходимо */
  </style>
