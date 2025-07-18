<template>
  <textarea :value="modelValue" @input="updateInput" :rows="rows" class="area"></textarea>
</template>

<script>
export default {
  name: "VacancyTextArea",
  props: {
    modelValue: [String, Number],
    rows: {
      type: String,
      default: "3"
    },
  },
  methods: {
    updateInput(event) {
      this.$emit('update:modelValue', event.target.value)
    }
  }
}
</script>

<style scoped>

.area {
  padding: 10px 15px;
  margin-top: 15px;
  resize: vertical;
  border-radius: 5px;
  box-shadow: #5c636a 0 0 5px;
}

</style>