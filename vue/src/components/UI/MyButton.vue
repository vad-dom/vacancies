<template>
  <button class="btn" :style="{width: width}">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "MyButton",
  props: {
    width: {
      type: String,
      default: "150px"
    }
  }
}
</script>

<style scoped>

.btn {
  padding: 10px 15px;
  white-space: nowrap;
  cursor: pointer;
  border-radius: 5px;
  box-shadow: #5c636a 0 0 5px;
}

</style>