<template>
  <button class="btn" :class="big ? 'big' : 'small'">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "VacancyButton",
  props: {
    big: {
      type: Boolean,
      default: true,
    }
  }
}
</script>

<style scoped>

.btn {
  white-space: nowrap;
  cursor: pointer;
  border-radius: 5px;
  box-shadow: #5c636a 0 0 5px;
}

.big {
  width: 150px;
  margin-top: 15px;
  padding: 10px 15px;
}

.small {
  width: 80px;
  height: 30px;
  padding: 5px 10px;
}

</style>