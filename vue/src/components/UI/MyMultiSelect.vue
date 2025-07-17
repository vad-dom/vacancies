<template>
  <select :value="modelValue" @change="changeOption" multiple class="select">
    <option disabled value="">Показать больше полей</option>
    <option v-for="option in options" :key="option.value" :value="option.value">{{ option.name }}</option>
  </select>
</template>

<script>
export default {
  name: "MyMultiSelect",
  props: {
    modelValue: {
      type: String
    },
    options: {
      type: Array,
      default: () => []
    },
  },
  methods: {
    changeOption(event) {
      this.$emit('update:modelValue', event.target.value)
    }
  }

}
</script>

<style scoped>

.select {
  border-radius: 5px;
  padding: 5px;
  box-shadow: #5c636a 0 0 3px;
}

</style>