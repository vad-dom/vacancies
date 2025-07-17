<template>
  <input :value="modelValue" @input="updateInput" class="input">
</template>

<script>
export default {
  name: "MyInput",
  props: {
    modelValue: [String, Number]
  },
  methods: {
    updateInput(event) {
      this.$emit('update:modelValue', event.target.value)
    }
  }
}
</script>

<style scoped>

.input {
  //width: 100%;
  padding: 10px 15px;
  margin-top: 15px;
  border-radius: 5px;
  box-shadow: #5c636a 0 0 5px;
}

</style>